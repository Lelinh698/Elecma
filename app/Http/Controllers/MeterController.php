<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MeterController extends Controller
{
    public function get_current_year_number($customer_id) {
        $current_year = date('Y', time());
        $customer = Customer::find($customer_id);
        $meter = $customer->meter->find(1);
        $list_number = $meter->meter_reading->where('year', '=', $current_year)->pluck(['number']);
        return view('customers.number_list')->with('year', $current_year)->with('numbers', json_encode($list_number, JSON_NUMERIC_CHECK));
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $customer_id = $request['customer_id'];
            $year = $request['year'];
            $list_number = [];
            $customer = Customer::find($customer_id);
            if ($customer) {
                $meter = $customer->meter->find(1);
                $list_number = $meter->meter_reading->where('year', '=', $year)->pluck(['number']);
            }
            $data = [
                'numbers' => $list_number,
                'year' => $year
            ];
            return Response(json_encode($data));
        }
    }

    public function abnormal_electricity() {

    }
}
