<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Electricity_price;
use App\Models\Employee;
use App\Models\Meter_reading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index() {
        if (Auth::guard('admin')->check()) {
            $customers = Customer::all()->count();
            $employees = Employee::all()->count();
            $departments = Department::all()->count();
            $bills = Bill::all()->count();
            return view('admin.index')->with('customers',$customers)->with('employees', $employees)
                ->with('departments', $departments)->with('bills', $bills);
        }
    }

    public function getCustomer() {
        if (Auth::guard('admin')->check()) {
            $customers = Customer::paginate(5);
            $departments = Department::get();
            return view('admin.customer')->with('customers',$customers)->with('departments', $departments);
        }
    }

    public function getEmployee() {
        if (Auth::guard('admin')->check()) {
            $employees = Employee::paginate(5);
            $departments = Department::get();
            return view('admin.employee')->with('employees',$employees)->with('departments', $departments);
        }
    }

    public function getDepartment() {
        if (Auth::guard('admin')->check()) {
            $departments = Department::paginate(5);
            return view('admin.department')->with('departments',$departments);
        }
    }

    public function getBill() {
        if (Auth::guard('admin')->check()) {
            $bills = Bill::get();
            return view('admin.bill')->with('bills',$bills);
        }
    }

    public function getUpdatePriceForm(){
        if (Auth::guard('admin')->check()) {
            $price = Electricity_price::get();
            return view('admin.update_electric_price')->with('price', $price);
        }
    }

    public function storeElectricPrice(Request $request) {
        for ($i=1; $i<=6; $i++) {
            $key = 'price_'.$i;
            Electricity_price::updateOrCreate(
                ['id' => $i],
                [
                    'price'  => $request->get($key),
                ]);
        }

        return redirect('/admin/update_electric_price');
    }
}
