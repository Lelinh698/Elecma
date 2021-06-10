<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function getLogin()
    {
        return view('auth.login');//return ra trang login để đăng nhập
    }

    public function postLogin(Request $request)
    {
        $arr = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::guard('customer')->attempt($arr)) {
            return redirect('/customer');
        } elseif (Auth::guard('employee')->attempt($arr)) {
            return redirect('/employee');
        } elseif (Auth::guard('admin')->attempt($arr)) {
            return redirect('/admin');
        } else {
            return redirect()->back()->with('status', 'Email hoặc Password không chính xác');
        }
    }

    public function getLogout()
    {
        if (Auth::guard('admin')->check())
        {
            Auth::guard('admin')->logout();
        }
        elseif (Auth::guard('customer')->check())
        {
            Auth::guard('customer')->logout();
        }
        elseif (Auth::guard('employee')->check())
        {
            Auth::guard('employee')->logout();
        }
        return redirect('/');
    }
}
