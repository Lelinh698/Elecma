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
                $list_number = $customer->meter->meter_reading->where('year', '=', $year)->pluck(['number']);
            }
            $data = [
                'numbers' => $list_number,
                'year' => $year
            ];
            return Response(json_encode($data));
        }
    }

    public function get_latest_number(Request $request) {
        if (Auth::guard('employee')->check()) {
            $customer_id = $request->customer_id;
            $customer = Customer::find($customer_id);
            $latest_number = $customer->meter->meter_reading->last();
            $data = [
                'number' => $latest_number->number,
                'month' => $latest_number->month,
                'year' => $latest_number->year
            ];
            return Response(json_encode($data));
        }
    }

    public function getCustomerMeterDetail(Request $request) {
        if (Auth::guard('employee')->check()) {
            $customer_id = $request->customer_id;
            $month = $request->month;
            $year = $request->year;
            $customer = Customer::find($customer_id);
            $number_model = $customer->meter->meter_reading;

            $customer = [
                'name' => $customer->name,
                'address' => $customer->address,
            ];
            $current['number'] = $previous['number'] = $month = [];
            foreach ($number_model->take(-12)->all() as $data) {
                array_push($month, $data->month);
                array_push($current['number'], $data->number);
                array_push($previous['number'],
                     $number_model->where('year', $data->year-1)
                         ->where('month', $data->month)->first()->number);
            }
//            var_dump($previous);
            return view('abnormal.detail')->with('customer', $customer)->with('month', json_encode($month))
                ->with('current', json_encode($current))->with('previous', json_encode($previous));
        }
    }

    public function abnormal_electricity(Request $request) {
        if (Auth::guard('employee')->check()) {
            $previous_year = date('Y', time()) - 1;
            $year = 'year_'.$previous_year;
            $month_number = $request->month;
            $month = 'month_'.$request->month;
            $year_weight = 4;
            $present_weight = 4;
            $group_weight = 2;
            $data = $this->get_tendency($previous_year);

            $topsis = $final = $denominator = [];
            $denominator[$month] = [
                'year' => 0,
                'present' => 0,
                'group' => 0
            ];
            foreach (array_keys($data[$month]) as $customer) {
                $denominator[$month]['year'] += pow($data[$month][$customer]['year'], 2);
                $denominator[$month]['present'] += pow($data[$month][$customer]['present'], 2);
                $denominator[$month]['group'] += pow($data[$month][$customer]['group'], 2);
            }
            $denominator[$month]['year'] = sqrt($denominator[$month]['year']);
            $denominator[$month]['present'] = sqrt($denominator[$month]['present']);
            $denominator[$month]['group'] = sqrt($denominator[$month]['group']);

            foreach (array_keys($data[$month]) as $customer) {
                $topsis[$month][$customer]['year'] =
                    number_format($data[$month][$customer]['year'] * $year_weight
                    / $denominator[$month]['year'],4);
                $topsis[$month][$customer]['present'] =
                    number_format($data[$month][$customer]['present'] * $present_weight
                        / $denominator[$month]['present'],4);
                $topsis[$month][$customer]['group'] =
                    number_format($data[$month][$customer]['group'] * $group_weight
                        / $denominator[$month]['group'],4);
            }

            $min = $max = [];

            $col_year = array_column($topsis[$month], 'year');
            $col_present = array_column($topsis[$month], 'present');
            $col_group = array_column($topsis[$month], 'group');
            $max[$month]['year'] = max($col_year);
            $max[$month]['present'] = max($col_present);
            $max[$month]['group'] = max($col_group);
            $min[$month]['year'] = min($col_year);
            $min[$month]['present'] = min($col_present);
            $min[$month]['group'] = min($col_group);

            $distance = [];
            foreach (array_keys($data[$month]) as $customer) {
                $temp = $topsis[$month][$customer];
                $distance[$month][$customer]['good'] = number_format(
                    sqrt(pow($temp['year'] - $max[$month]['year'], 2)
                        + pow($temp['present'] - $max[$month]['present'], 2)
                    +pow($temp['group'] - $max[$month]['group'], 2)), 4);

                $distance[$month][$customer]['bad'] = number_format(
                    sqrt(pow($temp['year'] - $min[$month]['year'], 2)
                        + pow($temp['present'] - $min[$month]['present'], 2)
                    +pow($temp['group'] - $min[$month]['group'], 2)), 4);

                $distance[$month][$customer]['C'] = $distance[$month][$customer]['bad']
                            / ($distance[$month][$customer]['bad'] + $distance[$month][$customer]['good']);
            }

            foreach (array_keys($data[$month]) as $customer) {
                $customer_id = explode('_',$customer)[1];
                $customer_model = Customer::find($customer_id);
                $final[$customer] = [
                    'customer_id' => $customer_id,
                    'name' => $customer_model->name,
                    'address' => $customer_model->address,
                    'C' => $distance[$month][$customer]['C']
                ];
            }
//            rsort($final);
            $C = array_column($final, 'C');

            array_multisort($C, SORT_DESC, $final);

            return view('abnormal.index')->with('res', $final)
                    ->with('year', $previous_year)->with('month', $month_number);
        }
    }

    public function get_tendency() {
        $data1 = $this->year_number_cal();
        $data2 = $this->consecutive_year_cal();
        $data3 = $this->address_cal();
//        var_dump($data1['year_2020']);
//        var_dump($data2['year_2020']);
//        var_dump($data3['year_2020']);
        $result = array_merge_recursive($data1, $data2, $data3);
//        var_dump($result);

        return $result;
    }

    public function year_number_cal() {
        $department_id = Auth::guard('employee')->user()->department_id;
        $customers = Customer::where('department_id', $department_id)->get();
        $data = [];
        foreach ($customers as $customer) {
            $meter = Meter::where('customer_id', $customer->id)->first();
            if (!empty($meter)) {
                $latest_twelve_month = $meter->meter_reading->take(-12);
                $average_year = $latest_twelve_month->avg('number');
                foreach($latest_twelve_month->pluck('month') as $month) {
                    $data['month_'.$month]['id_' . $customer->id]['year'] =
                        $latest_twelve_month->where('month', $month)->first()->number/$average_year;
                }
            }
        }

        return $data;
    }

    public function consecutive_year_cal() {
        $data = [];
        $department_id = Auth::guard('employee')->user()->department_id;
        $customers = Customer::where('department_id', $department_id)->get();

        foreach ($customers as $customer) {
            $meter = Meter::where('customer_id', $customer->id)->first();
            if (!empty($meter)) {
                $latest_twelve_month = $meter->meter_reading->take(-12);
                foreach($latest_twelve_month->pluck('month') as $month) {
                    $data1 = $latest_twelve_month->where('month', $month)->first();
                    $number_1 = $data1->number;
                    $year1 = $data1->year;
                    $number_2 = $meter->meter_reading->where('month', $month)
                                ->where('year', $year1-1)->first()->number;
                    $data['month_'.$month]['id_' . $customer->id]['present'] = $number_1/$number_2;
                }
            }
        }
        return $data;
    }

    public function address_cal() {
        $data = [];
        $department_id = Auth::guard('employee')->user()->department_id;
        $customers = Customer::where('department_id', $department_id)->get();
        $average_group = [];
        foreach ($customers as $customer) {
            $meter = Meter::where('customer_id', $customer->id)->first();
            if (!empty($meter)) {
                $latest_twelve_month = $meter->meter_reading->take(-12);
                foreach($latest_twelve_month->pluck('month') as $month) {
                    $customer_data = $latest_twelve_month->where('month', $month)->first();
                    $group_average = Meter_reading::where('year', $customer_data->year)->where('month', $month)->avg('number');
                    $data['month_'.$month]['id_'.$customer->id]['group'] = $customer_data->number/$group_average;
                }
            }
        }
        return $data;
    }
}
