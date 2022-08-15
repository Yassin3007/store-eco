<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WishListController extends Controller
{
    public function store(){
        if (! auth()->user()->wishlistHas(\request('productId'))) {
            return \request('productId');
            auth()->user()->wishlist()->attach(\request('productId'));
            return response() -> json(['status' => true , 'wished' => true]);
        }
        return response() -> json(['status' => true , 'wished' => false]);  // added before we can use enumeration here
    }
}
