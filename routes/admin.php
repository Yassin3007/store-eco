<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//note that there is prefix admin for all the page

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){ //...

    Route::get('/', function () {
        return view('welcome');
    });
    route::group(['namespace'=>'Admin' ,'middleware' =>'auth:admin','prefix'=>'admin'] ,function(){
        route::get('/' , 'DashboardController@index')->name('admin.dashboard') ;

        route::group(['prefix' => 'settings' ,'prefix'=>'admin'] , function(){
            route::get('shipping-methods/{type}' , 'SettingsController@editShippingMethods')->name('edit.shippings.methods');
            route::put('shipping-methods/{id}' , 'SettingsController@updateShippingMethods')->name('update.shippings.methods');
        });


    });
    route::group(['namespace'=>'Admin','middleware'=>'guest:admin', 'prefix'=>'admin'],function(){
        route::get('login' , 'LoginController@login') ;
        route::post('login' , 'LoginController@postLogin')->name('admin.post.login') ;
    });




    route::get('ad' , function(){
        return 'admin loginnnnnnnn' ;
    })->name('admin.login');

});


