<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function getRegister() {
        $departments = Department::get();
        return view('auth.registration')->with('departments', $departments);
    }

    protected function storeUser(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:customers',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'department' => 'required',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        Customer::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'department_id' => $request->department,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/customer');
    }
}
