<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class BrandsController extends Controller
{
    public function index(){
        $brands = Brand::orderBy('id','DESC')->paginate(PAGINATION_COUNT);
        return view('admin.brands.index',compact('brands'));
    }

    public  function create(){
        return view('admin.brands.create');
    }

    public function store(BrandRequest $request){




            if($request->has('is_active')){
                $request->request->add(['is_active'=>1]);
            }else{
                $request->request->add(['is_active'=>0]);
            }
            if($request->has('photo')){
                $filepath= uploadImage('brands',$request->photo);
            }
            $brand = Brand::create($request->except('_token','photo'));
            $brand->name = $request->name ;
            $brand->photo = $filepath ;
            $brand->save();
            return redirect()->route('admin.brands')->with(['success'=>'تمت الاضافة بنجاح']);


    }

    public  function  edit($id){
        $brand = Brand::find($id);
        return view('admin.brands.edit',compact('brand')) ;
    }
    public function update($id , BrandRequest $request){

        try {
            DB::beginTransaction();
            $brand = Brand::find($id);
            if(! $brand){
                return redirect()->route('admin.brands')->with(['error'=>'هذه الماركة غير موجودة']);
            }
            if($request->has('photo')){
                $filename = uploadImage('brands',$request->photo);
                Brand::where('id',$id)->update(['photo'=>$filename]);

            }

            if ($request->has('is_active')){
                $request->request->add(['is_active'=>1]);
            }else
                $request->request->add(['is_active'=>0]);

            $brand->update($request->except(['id','_token','photo']));

            $brand->name = $request->name ;
            $brand->save();
            DB::commit();
            return redirect()->route('admin.brands')->with(['success'=>'تم التعديل بنجاح']);



        }catch (\Exception $ex){
            DB::rollBack();
            return redirect()->route('admin.brands')->with(['error'=>'حدث خطا ما']);
        }



    }
    public function destroy($id){
        try {
            $brand = Brand::find($id);
            if(! $brand){
                return redirect()->route('admin.brands')->with(['error'=>'هذه الماركة غير موجودة  ']);
            }
            $brand->delete();
            return redirect()->route('admin.brands')->with(['success'=>'تم الحذف بنجاح ']);

        }catch (\exception $ex){
            return redirect()->route('admin.brands')->with(['error'=>'حدث خطا ما ']);
        }


    }
}
