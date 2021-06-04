<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function getUnpaidCustomer() {
        if(Auth::guard('employee')->check()) {
            $data = Bill::where('status', Bill::UNPAID)->all();
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
