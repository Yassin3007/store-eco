<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(){
        $data =[] ;
        $data['categories'] = Category::parent()->select('id' ,'slug')->with(['childrens'=>function($q){
            $q->select('id','parent_id' , 'slug') ;
            $q->with(['childrens'=>function($qq){
                $qq->select('id', 'parent_id','slug');

            }]);

        }])->get();
       return view('front.home',$data);
    }
}
