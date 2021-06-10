<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatisticController extends Controller
{
    public function index() {
        $unpaidData = $this->getUnpaidCustomer();
        return view('employees.statistic')->with('unpaidData', $unpaidData);
    }

    public function getUnpaidCustomer() {
        if(Auth::guard('employee')->check()) {
            $data = [];
            $bills = Bill::where('status', Bill::UNPAID)->get();
            foreach ($bills as $bill) {
                $customer = Customer::find($bill->customer_id);
                array_push($data, [
                    'username' => $customer->username,
                    'name' => $customer->name,
                    'phone' => $customer->phone,
                    'address' => $customer->address,
                    'time' => date('m/Y', strtotime($bill->to_date)),
                    'amount' => $bill->amount,
                ]);
            }
            return $data;
        }
    }

    public function getPaidCustomer() {
        if(Auth::guard('employee')->check()) {
            $data = Bill::where('status', Bill::PAID)->all();
            return $data;
        }
    }

    public function getTotalAmount() {

    }
}
