<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeRequest;
use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributesController extends Controller
{
    public function index(){
        $attributes = Attribute::orderBy('id','DESC')->paginate(PAGINATION_COUNT);
        return view('admin.attributes.index',compact('attributes'));
    }

    public function create(){
        return view('admin.attributes.create');
    }

    public function store(AttributeRequest $request){

        try {
            $attribute = Attribute::create([]);
            $attribute->name = $request->name ;
            $attribute->save();

            return redirect()->route('admin.attributes')->with(['success' => 'تم التحديث بنجاح']);

        }catch (\Exception $ex){
            return redirect()->route('admin.attributes')->with(['error' => 'حدث خطا ما  ']);

        }
    }
    public function edit($id){
        $attribute = Attribute::find($id);
        if (! $attribute){
            return redirect()->route('admin.attributes')->with(['error' => 'حدث خطا ما  ']);
        }

        return view('admin.attributes.edit',compact('attribute'));
    }

    public function update($id ,AttributeRequest $request){

        try {
            $attribute = Attribute::find($id);

            $attribute->name =$request->name ;
            $attribute->save();
            return redirect()->route('admin.attributes')->with(['success' => 'تم التحديث بنجاح']);

        }catch (\Exception $ex){
            return redirect()->route('admin.attributes')->with(['error' => 'حدث خطا ما  ']);
        }




    }

    public function destroy($id){
        $attribute = Attribute::find($id);
        if (! $attribute){
            return redirect()->route('admin.attributes')->with(['error' => 'حدث خطا ما  ']);
        }
        $attribute->delete();

        return redirect()->route('admin.attributes')->with(['success' => 'تم الحذف بنجاح']);

    }




}
