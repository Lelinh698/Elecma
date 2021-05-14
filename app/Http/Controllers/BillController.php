<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Customer;
use App\Models\Electricity_price;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer_id = $request->customer_id;
        $initial_number = $request->initial_number;
        $final_number = $request->final_number;
        $from_date = date('Y-m-d H:i:s');
        $to_date = date('Y-m-d H:i:s', strtotime($from_date . ' +10 day'));
        $status = $request->status;

        $request->validate([
            'customer_id'=>'required',
            'initial_number'=>'required',
            'final_number'=>'required',
            'status' => 'required'
        ]);

        $id = $request->get('id');
        $bill = Bill::updateOrCreate(
            ['id' => $id],
            [
                'customer_id'  => $customer_id,
                'consumption' => $final_number - $initial_number,
                'from_date' => $from_date,
                'to_date' => $to_date,
                'status' => $status,
            ]);
        return Response(json_encode(['status'=> 'success']));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bill = Bill::find($id);
        $customer = $bill->customer;
        $department = $customer->department;
        $data = [
            'bill' => $bill,
            'department' => $department,
            'customer' => $customer
        ];
        echo json_encode($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search(Request $request) {
        $customer_id = $request->customer_id;
        $month = $request->month;
        $year = $request->year;

        $bill = Bill::where('customer_id', '=', $customer_id)->whereMonth('to_date', '=', $month)
                        ->whereYear('to_date', '=', $year)
                        ->first();
        $data = null;
        if ($bill) {
            $data = [
                'time' => date('m/Y', strtotime($bill['to_date'])),
                'from_date' => date('d-m-Y', strtotime($bill['from_date'])),
                'to_date' => date('d-m-Y', strtotime($bill['to_date'])),
                'id' => $bill['id'],
                'amount' => self::calculate($bill['consumption'])['amount'],
                'status' => $bill['status'] ? 'Đã trả' : 'Chưa trả',
            ];
        }
        return Response(json_encode($data));
    }

    public function getLastestBill($id) {
//        $customer_id = $request['customer_id'];
        $customer_id = $id;
        $bill = Bill::where('customer_id', '=', $customer_id)->where('status', '=', Bill::UNPAID)->get();
        $data = [];
        if ($bill) {
            $data = [
                'from_date' => $bill['from_date'],
                'to_date' => $bill['to_date'],
                'id' => $bill['id'],
                'amount' => $bill['consumption'],
                'status' => $bill['status'] ? 'Đã trả' : 'Chưa trả',
            ];
        }
        return Response(json_encode($data));
    }

    public static function calculate($consumption) {
        $elec_price = Electricity_price::where([
            ['from_number', '<=', $consumption], ['to_number', '>=', $consumption]])->first();
        $amount = (floor(($consumption * $elec_price['price'])/1000) + 1) *1000;
        $data = [
            'price' => $elec_price['price'],
            'amount' => $amount
        ];
        return $data;
    }

    public function pay() {
        $customer_id = Auth::guard('customer')->id();
        Bill::where([['customer_id', $customer_id],['status', Bill::UNPAID]])
            ->update(['status' => Bill::PAID]);
        return redirect()->intended(route('customer.index'));
    }

    public function update_electric_number() {
        return view('employees.update_enumber');
    }


}
