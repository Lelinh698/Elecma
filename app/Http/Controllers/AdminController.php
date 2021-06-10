<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Electricity_price;
use App\Models\Employee;
use App\Models\Meter_reading;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        $customers = Customer::all()->count();
        $employees = Employee::all()->count();
        $departments = Department::all()->count();
        $bills = Bill::all()->count();
        return view('admin.index')->with('customers',$customers)->with('employees', $employees)
            ->with('departments', $departments)->with('bills', $bills);
    }

    public function getCustomer() {
        $customers = Customer::get();
        return view('admin.customer')->with('customers',$customers);
    }

    public function getEmployee() {
        $employees = Employee::get();
        return view('admin.employee')->with('employees',$employees);
    }

    public function getDepartment() {
        $departments = Department::get();
        return view('admin.department')->with('departments',$departments);
    }

    public function getBill() {
        $bills = Bill::get();
        return view('admin.bill')->with('bills',$bills);
    }

    public function getUpdatePriceForm(){
        $price = Electricity_price::get();
        return view('admin.update_electric_price')->with('price', $price);
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
