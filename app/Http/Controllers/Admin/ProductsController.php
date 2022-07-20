<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class ProductsController extends Controller
{


    public function create(){
        $data =[];
        $data['brands'] =Brand::active()->select('id')->get();
        $data['brands'] =Tag::select('id')->get();
        $data['categories'] =Category::active()->select('id')->get();

        return view('admin.products.general.create',compact('data'));
    }


}
