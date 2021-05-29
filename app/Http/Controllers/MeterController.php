<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Meter;
use App\Models\Meter_reading;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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
        // Truy van
        if (Auth::guard('employee')->check()) {
            $department_id = Auth::guard('employee')->user()->department_id;
            $d1 = $this->year_tendency($department_id);
//            var_dump($this->getReading());
            // $meter = Meter::
            // $list_number = $meter->meter_reading->where('year', '=', $year)->pluck(['number']);
        }

        //Cho vao ma tran

        //Chuan hoa vector

        //Tinh toan mau so cho chuan hoa vector

        //return
    }

    public function year_tendency($department_id) {
        $customers = Customer::where('department_id', $department_id)->get();
        $current_year = date('Y', time());
        $data1 = $data2 = $data3 = [];
//        $years = $meter->meter_reading->unique('year')->pluck('year');
//        foreach ($customers as $customer) {
//            $data1["id_".$customer->id] = $this->year_number_cal($customer->id);
//            $data2[$customer->id] = $this->consecutive_year_cal($customer->id);
//            $data3["id_".$customer->id] = $this->address_cal($customer->id);
////            var_dump($customer->meter->first()->meter_reading->pluck('number')->toArray());
//        }

        $data1 = $this->year_number_cal();
        $data3 = $this->address_cal();
//        var_dump($data1);
//        var_dump($data2);
//        var_dump($data3);
        $result = array_merge_recursive($data1, $data3);
//        $data3 = array_column($data3, 1);
//        var_dump($result);
//        echo json_encode($data3);

        return [];
    }

    public function year_number_cal() {
        $department_id = Auth::guard('employee')->user()->department_id;
        $customers = Customer::where('department_id', $department_id)->get();
        $years = Meter_reading::select('year')->distinct()->pluck('year');
        $data = [];
        foreach ($years as $year) {
            foreach ($customers as $customer) {
                $meter = Meter::where('customer_id', $customer->id)->first();
                if (!empty($meter)) {
                    $temp = $meter->meter_reading->where('year', $year)->pluck('number')->toArray();
                    $year_average = array_sum($temp)/count($temp);
                    $result = [];
                    foreach ($temp as $key => $value) {
                        $result["month_".$key] = $value / $year_average;
                    }
                    $data["year_".$year]['id_'.$customer->id] = $result;
                }
            }
        }

        return $data;
    }

    public function consecutive_year_cal($customer_id) {
        $data = [];
        $meter = Meter::where('customer_id', $customer_id)->first();
        if (!empty($meter)) {
            $years = $meter->meter_reading->unique('year')->pluck('year');
            for ($i=1; $i<count($years); $i++) {
                $year1 = $meter->meter_reading->where('year', '=', $years[$i-1])->pluck('number');
                $year2 = $meter->meter_reading->where('year', '=', $years[$i])->pluck('number');
                foreach ($year1 as $key => $value) {
                    $result[] = $year2[$key] / $value;
                }
                // $result = array_map( function($val) { return $val / $year_average; }, $temp);
                $data[$years[$i]] = $result;
            }
        }
        return $data;
    }

    public function address_cal() {
        $data = [];
        $col_array = array();
        $department_id = Auth::guard('employee')->user()->department_id;
        $customers = Customer::where('department_id', $department_id)->get();
        $years = Meter_reading::select('year')->distinct()->pluck('year');
        foreach ($years as $year) {
            foreach ($customers as $customer) {
                $meter = Meter::where('customer_id', $customer->id)->first();
                if (!empty($meter)) {
                    $temp = $meter->meter_reading->where('year', $year)->pluck('number')->toArray();
                    foreach ($temp as $key => $value) {
                        $result["month_".$key] = $value;
//                        array_push($col_array["year_".$year]["month_".$key], $value);
                    }
                    $data["year_".$year]['id_'.$customer->id] = $result;
                }
            }
        }
        var_dump($data['year_2020']);
//        var_dump(array_column($data['year_2020'], 'month_0'));
        return $data;
    }

    public function getAllCustomerReading() {
        $department_id = Auth::guard('employee')->user()->department_id;
        $customers = Customer::where('department_id', $department_id)->get();
        $data = [];
        foreach ($customers as $customer) {
            $meter = Meter::where('customer_id', $customer->id)->first();
            if (!empty($meter)) {
                $years = $meter->meter_reading->unique('year')->pluck('year');
                foreach ($years as $year) {
                    $temp = $meter->meter_reading->where('year', '=', $year)->pluck('number')->toArray();

                    foreach ($temp as $key => $value) {
                        $result["month_".$key] = $value;
                    }
                    $data['id_'.$customer->id]["year_".$year] = $result;
                }
            }
        }

//        foreach ($sa as $item) {
//
//        }

        return $data;
    }

    public function getReading() {
        $department_id = Auth::guard('employee')->user()->department_id;
        $customers = Customer::where('department_id', $department_id)->get();
        $years = Meter_reading::select('year')->distinct()->pluck('year');
        $data = [];
        foreach ($years as $year) {
            foreach ($customers as $customer) {
                $meter = Meter::where('customer_id', $customer->id)->first();
                if (!empty($meter)) {
                    $temp = $meter->meter_reading->where('year', $year)->pluck('number')->toArray();
                    foreach ($temp as $key => $value) {
                        $result["month_".$key] = $value;
                    }
                    $data["year_".$year]['id_'.$customer->id] = $result;
                }
            }
        }
        return $data;
    }
}
