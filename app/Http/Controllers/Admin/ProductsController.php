<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GeneralProductRequest;
use App\Http\Requests\ProductImageRequest;
use App\Http\Requests\ProductPriceRequest;
use App\Http\Requests\ProductStockRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB ;
use App\Models\Product ;
use mysql_xdevapi\Exception;
use phpDocumentor\Reflection\Types\AbstractList;

class ProductsController extends Controller
{

    public function index()
    {
        $products = Product::select('id', 'slug', 'price', 'created_at')->paginate(PAGINATION_COUNT);

        return view('admin.products.general.index', compact('products'));

    }


    public function create()
    {
        $data = [];
        $data['brands'] = Brand::active()->select('id')->get();
        $data['tags'] = Tag::select('id')->get();
        $data['categories'] = Category::active()->select('id')->get();

        return view('admin.products.general.create', $data);
    }

    public function store(GeneralProductRequest $request)
    {

        DB::beginTransaction();

        //validation

        if (!$request->has('is_active'))
            $request->request->add(['is_active' => 0]);
        else
            $request->request->add(['is_active' => 1]);

        $product = Product::create([
            'slug' => $request->slug,
            'brand_id' => $request->brand_id,
            'is_active' => $request->is_active,
        ]);
        //save translations
        $product->name = $request->name;
        $product->description = $request->description;
        $product->short_description = $request->short_description;
        $product->save();

        //save product categories

        $product->categories()->attach($request->categories);

        //save product tags

        DB::commit();
        return redirect()->route('admin.products')->with(['success' => 'تم ألاضافة بنجاح']);

    }

    public function getPrice($id)
    {
        return view('admin.products.prices.create', compact('id'));
    }

    public function saveProductPrice(ProductPriceRequest $request)
    {


        try {

            Product::whereId($request->product_id)->update($request->only(['price', 'special_price', 'special_price_type', 'special_price_start', 'special_price_end']));

            return redirect()->route('admin.products')->with(['success' => 'تم التحديث بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.products')->with(['error' => 'حدث خطا ما  ']);
        }


    }

    public function getStock($id){
        return view('admin.products.stock.create',compact('id'));
    }



    public function saveProductStock(ProductStockRequest $request ){
        try {

            Product::whereId($request->product_id)->update($request->except(['_token', 'product_id']));

            return redirect()->route('admin.products')->with(['success' => 'تم التحديث بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.products')->with(['error' => 'حدث خطا ما  ']);
        }

    }

    public  function addImages($id){
        return view('admin.products.images.create',compact('id'));
    }

    public  function saveProductImages(Request $request){
        $file = $request->file('dzfile');
        $filename= uploadImage('products',$file);

        return response()->json([
            'name'=>$filename ,
            'original_name'=>$file->getClientOriginalName()
        ]);

    }

    public function saveProductImagesDB(ProductImageRequest $request){
        try {
            if ($request->has('document')&&count($request->document) >0){
                foreach ($request->document as $image){
                    Image::create([
                        'product_id'=>$request->product_id ,
                        'photo'=>$image
                    ]);

                }
                return redirect()->route('admin.products')->with(['success' => 'تم التحديث بنجاح']);
            }


        }catch (\Exception $ex){
            return redirect()->route('admin.products')->with(['error' => 'حدث خطا ما  ']);

        }

    }


}
