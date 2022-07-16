<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            DB::commit();


    }
}
