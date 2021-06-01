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

    public function getCustomerMeterDetail(Request $request) {
        if (Auth::guard('employee')->check()) {
            $customer_id = $request->customer_id;
            $month = $request->month;
            $year = $request->year;
            $customer = Customer::find($customer_id);
            $number = $customer->meter->first()->meter_reading->where('year', $year)->pluck('number');
            $customer = [
                'name' => $customer->name,
                'address' => $customer->address,
            ];
            return view('abnormal.detail')->with('customer', $customer)
                ->with('meter', $number)->with('year', $year);
        }
    }

    public function abnormal_electricity(Request $request) {
        if (Auth::guard('employee')->check()) {
            $previous_year = date('Y', time()) - 1;
            $year = 'year_'.$previous_year;
            $month_number = $request->month;
            $month = 'month_'.$request->month;
            $data = $this->get_tendency($previous_year);

            $topsis = [];
            $denominator = [];
//            foreach (array_keys($data) as $year) {
//                foreach (array_keys($data[$year]) as $month) {
                    $denominator[$year][$month] = [
                        'year' => 0,
                        'present' => 0,
                        'group' => 0
                    ];
                    foreach (array_keys($data[$year][$month]) as $customer) {
                        $denominator[$year][$month]['year'] += pow($data[$year][$month][$customer]['year'], 2);
                        $denominator[$year][$month]['present'] += pow($data[$year][$month][$customer]['present'], 2);
                        $denominator[$year][$month]['group'] += pow($data[$year][$month][$customer]['group'], 2);
                    }
                    $denominator[$year][$month]['year'] = sqrt($denominator[$year][$month]['year']);
                    $denominator[$year][$month]['present'] = sqrt($denominator[$year][$month]['present']);
                    $denominator[$year][$month]['group'] = sqrt($denominator[$year][$month]['group']);
//                }
//            }

//            foreach (array_keys($data) as $year) {
//                foreach (array_keys($data[$year]) as $month) {
                    foreach (array_keys($data[$year][$month]) as $customer) {
                        $topsis[$year][$month][$customer]['year'] =
                            number_format($data[$year][$month][$customer]['year']*6
                            / $denominator[$year][$month]['year'],4);
                        $topsis[$year][$month][$customer]['present'] =
                            number_format($data[$year][$month][$customer]['present']*6
                                / $denominator[$year][$month]['present'],4);
                        $topsis[$year][$month][$customer]['group'] =
                            number_format($data[$year][$month][$customer]['group']*4
                                / $denominator[$year][$month]['group'],4);
                    }
//                }
//            }

            $min = $max = [];

//            foreach (array_keys($data) as $year) {
//                foreach (array_keys($data[$year]) as $month) {
                    $col_year = array_column($topsis[$year][$month], 'year');
                    $col_present = array_column($topsis[$year][$month], 'present');
                    $col_group = array_column($topsis[$year][$month], 'group');
//                    var_dump($col_group);
                    $max[$year][$month]['year'] = max($col_year);
                    $max[$year][$month]['present'] = max($col_present);
                    $max[$year][$month]['group'] = max($col_group);
                    $min[$year][$month]['year'] = min($col_year);
                    $min[$year][$month]['present'] = min($col_present);
                    $min[$year][$month]['group'] = min($col_group);
//                }
//            }
            $distance = [];
//            foreach (array_keys($data) as $year) {
//                foreach (array_keys($data[$year]) as $month) {
                    foreach (array_keys($data[$year][$month]) as $customer) {
                        $temp = $topsis[$year][$month][$customer];
                        $distance[$year][$month][$customer]['good'] = number_format(
                            sqrt(pow($temp['year'] - $max[$year][$month]['year'], 2)
                                + pow($temp['present'] - $max[$year][$month]['present'], 2)
                            +pow($temp['group'] - $max[$year][$month]['group'], 2)), 4);

                        $distance[$year][$month][$customer]['bad'] = number_format(
                            sqrt(pow($temp['year'] - $min[$year][$month]['year'], 2)
                                + pow($temp['present'] - $min[$year][$month]['present'], 2)
                            +pow($temp['group'] - $min[$year][$month]['group'], 2)), 4);

                        $distance[$year][$month][$customer]['C'] = $distance[$year][$month][$customer]['bad']
                                    / ($distance[$year][$month][$customer]['bad'] + $distance[$year][$month][$customer]['good']);
                    }
//                }
//            }
            foreach (array_keys($data[$year][$month]) as $customer) {
                $customer_id = explode('_',$customer)[1];
                $customer_model = Customer::find($customer_id);
                $final[$customer] = [
                    'customer_id' => $customer_id,
                    'name' => $customer_model->name,
                    'address' => $customer_model->address,
                    'C' => $distance[$year][$month][$customer]['C']
                ];
            }
//            rsort($final);
            $C = array_column($final, 'C');

            array_multisort($C, SORT_DESC, $final);

//            var_dump($final);
            return view('abnormal.index')->with('res', $final)
                    ->with('year', $previous_year)->with('month', $month_number);
        }

    }

    public function get_tendency($year) {
        $data1 = $this->year_number_cal($year);
        $data2 = $this->consecutive_year_cal($year);
        $data3 = $this->address_cal($year);
//        var_dump($data1['year_2020']);
//        var_dump($data2['year_2020']);
//        var_dump($data3['year_2020']);
        $result = array_merge_recursive($data1, $data2, $data3);
//        var_dump($result['year_2020']);
//        echo json_encode($data3);

        return $result;
    }

    public function year_number_cal($year=null) {
        $department_id = Auth::guard('employee')->user()->department_id;
        $customers = Customer::where('department_id', $department_id)->get();
        $years = Meter_reading::select('year')->distinct()->pluck('year');
        $data = [];
//        foreach ($years as $year) {
        for ($month=1; $month<=12; $month++) {
            foreach ($customers as $customer) {
                $meter = Meter::where('customer_id', $customer->id)->first();
                if (!empty($meter)) {
                    $meter_reading = $meter->meter_reading->where('year', $year)
                        ->where('month', $month)->first();

                    if (isset($meter_reading)) {
                        $average_year = $meter->meter_reading->where('year', $year)->avg('number');
                        $data["year_" . $year]['month_'.$month]['id_' . $customer->id]['year'] = $meter_reading->number/$average_year;
                    } else {
                        $data["year_" . $year]['month_'.$month]['id_' . $customer->id] = 0;
                    }
                }
            }
        }
//        }

        return $data;
    }

    public function consecutive_year_cal($year) {
        $data = [];
        $department_id = Auth::guard('employee')->user()->department_id;
        $customers = Customer::where('department_id', $department_id)->get();

        for ($month=1; $month<=12; $month++) {
            foreach ($customers as $customer) {
                $meter = Meter::where('customer_id', $customer->id)->first();
                if (!empty($meter)) {
                    $meter_reading = $meter->meter_reading->where('year', $year)
                        ->where('month', $month)->first();

                    $meter_reading_2 = $meter->meter_reading->where('year', $year-1)
                        ->where('month', $month)->first();

                    if (isset($meter_reading)) {
                        $number_1 = $meter_reading->number;
                        $number_2 = $meter_reading_2->number;
                        $data["year_" . $year]['month_'.$month]['id_' . $customer->id]['present'] = $number_1/$number_2;
                    } else {
                        $data["year_" . $year]['month_'.$month]['id_' . $customer->id] = 0;
                    }
                }
            }
        }
        return $data;
    }

    public function address_cal($year) {
        $data = [];
        $department_id = Auth::guard('employee')->user()->department_id;
        $customers = Customer::where('department_id', $department_id)->get();
        $years = Meter_reading::select('year')->distinct()->pluck('year');
        $average_group = [];
//        foreach ($years as $year) {
            for ($month=1; $month<=12; $month++) {
                $total = 0;
                $average = 0;
                foreach ($customers as $customer) {
                    $meter = Meter::where('customer_id', $customer->id)->first();
                    if (!empty($meter)) {
                        $meter_reading = $meter->meter_reading->where('year', $year)
                                ->where('month', $month)->first();
                        if(isset($meter_reading)) {
                            $total += $meter_reading->number;
                            $data["year_".$year]['month_'.$month]['id_'.$customer->id]['group'] = $meter_reading->number;
                        } else {
                            $data["year_" . $year]['month_'.$month]['id_' . $customer->id] = 0;
                        }
                    }
                    $average = $total / count($data["year_".$year]['month_'.$month]);
                }
                $average_group["year_".$year]['month_'.$month] = $average;
            }
//        }
        foreach (array_keys($data) as $year) {
            foreach (array_keys($data[$year]) as $month) {
                foreach (array_keys($data[$year][$month]) as $customer) {
                    $data[$year][$month][$customer]['group'] /= $average_group[$year][$month];
                }
            }
        }
        return $data;
    }
}
