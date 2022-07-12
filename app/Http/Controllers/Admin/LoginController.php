<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use Illuminate\Http\Request;
use auth ;

class LoginController extends Controller
{
    //

    public function login(){
        return view('admin.auth.login') ;
    }
    public function postLogin(AdminLoginRequest $request)
    {
        $remember_me = $request->has('remember_me');

        if (auth()->guard('admin')->attempt(['email' => $request->input("email"), 'password' => $request->input("password")], $remember_me)) {
            // notify()->success('تم الدخول بنجاح  ');
            return redirect() -> route('admin.dashboard');
        }
        // notify()->error('خطا في البيانات  برجاء المجاولة مجدا ');
        return redirect()->back()->with(['error' => 'هناك خطا بالبيانات']);
    }
    public function logout(){
        $guard=$this->getGuard();
        $guard->logout();
        return redirect()->route('admin.login');
    }

    private function getGuard()
    {
        return auth('admin') ;
    }


}
