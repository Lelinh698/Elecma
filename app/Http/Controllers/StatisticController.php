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
        $paidData = $this->getPaidCustomer();
        return view('employees.statistic')->with('unpaidData', $unpaidData)
                ->with('paidData', $paidData);
    }

    public function getUnpaidCustomer() {
        if(Auth::guard('employee')->check()) {
            $data = [];
            $bills = Bill::where('status', Bill::UNPAID)->paginate(5);
            return $bills;
        }
    }

    public function getPaidCustomer() {
        if(Auth::guard('employee')->check()) {
            $data = Bill::where('status', Bill::PAID)->get();
            return $data;
        }
    }

    public function getTotalAmount() {

    }
}
