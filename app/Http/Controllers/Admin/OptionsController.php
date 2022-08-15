<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OptionsRequest;
use App\Models\Attribute;
use App\Models\Option;
use App\Models\Product;
use Illuminate\Http\Request;

class OptionsController extends Controller
{
    public function index(){
        $options = Option::with(['product' => function ($prod) {
            $prod->select('id');
        }, 'attribute' => function ($attr) {
            $attr->select('id');
        }])->select('id', 'product_id', 'attribute_id', 'price')->paginate(PAGINATION_COUNT);
        return view('admin.options.index',compact('options'));
    }

    public function create(){
        $data =[];
        $data['products'] = Product::active()->select('id')->get();
        $data['attributes'] = Attribute::select('id')->get();

        return view('admin.options.create',$data);
    }

    public function store(OptionsRequest $request){
        try {

            $option = Option::create($request->except('_token'));

            $option->name = $request->name ;
            $option->save();

            return redirect()->route('admin.options')->with(['success' => 'تم ألاضافة بنجاح']);

        }catch (\Exception $ex){

            return redirect()->route('admin.options')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);

        }
    }

    public function edit($id){

        $data = [];
        $data['option'] = Option::find($id);

        if (! $data['option']){
            return redirect()->route('admin.options')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);

        }

        $data['products'] = Product::active()->select('id')->get();
        $data['attributes'] = Attribute::select('id')->get();

        return view('admin.options.edit', $data);
    }

    public function update($id ,OptionsRequest $request){

        try {
            $option = Option::find($id);
            if (! $option)
                return redirect()->route('admin.options')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);

            $option->update($request->except(['_token','id']));

            $option->name = $request->name ;
            $option->save();

            return redirect()->route('admin.options')->with(['success' => 'تم التحديث بنجاح']);

        }catch (\Exception $ex){
            return redirect()->route('admin.options')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }


    }
    public function destroy($id){

        try {
            $option = Option::find($id);
            if (! $option)
                return redirect()->route('admin.options')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);

            $option->delete();

            return redirect()->route('admin.options')->with(['success' => 'تم الحذف بنجاح']);

        }catch (\Exception $ex){
            return redirect()->route('admin.options')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }




    }
}
