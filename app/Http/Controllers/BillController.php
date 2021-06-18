<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Customer;
use App\Models\Electricity_price;
use App\Models\Meter_reading;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;

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
        $price_per_number = $request->price_per_number;
        $amount = $request->amount;
//        $from_date = date('Y-m-d H:i:s');
//        $to_date = date('Y-m-d H:i:s', strtotime($from_date . ' +10 day'));
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $status = $request->status;

        $request->validate([
            'customer_id'=>'required',
            'initial_number'=>'required',
            'final_number'=>'required',
            'status' => 'required'
        ]);

        try {
            $newBill = Bill::create([
                'customer_id'  => $customer_id,
                'initial_number' => $initial_number,
                'final_number' => $final_number,
                'price_per_number' => $price_per_number,
                'amount' => $amount,
                'from_date' => $from_date,
                'to_date' => $to_date,
                'status' => $status,
            ]);
    
            Meter_reading::create([
                'meter_id' => Customer::find($customer_id)->meter->id,
                'number' => $final_number - $initial_number,
                'month' => date('m', strtotime($from_date)),
                'year' => date('Y', strtotime($from_date)),
            ]);
    
            $bill = Bill::find($newBill->id);
            $customer = $bill->customer;
            $department = $customer->department;
            $data['department'] = $department;
            $data['customer'] = $customer;
            $data['bill'] = $bill;
            $data['date'] = date('d-m-Y');
            
            Mail::to($customer->email)->send(new SendMail($data));
            return response()->json(['status' => 'Cập nhật thành công']);
        } catch (Exception $e) {
            return response()->json(['error' => $e]);
        }
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
                'amount' => $bill['amount'],
                'status' => $bill['status'] ? 'Đã trả' : 'Chưa trả',
            ];
        }
        return Response(json_encode($data));
    }

    public static function calculate($initial, $final) {
        $consumption = $final - $initial;
        $elec_price = Electricity_price::where([
            ['from_number', '<=', $consumption], ['to_number', '>=', $consumption]])->first();
        $amount = (floor(($consumption * $elec_price['price'])/1000) + 1) *1000;
        $data = [
            'price_per_number' => $elec_price['price'],
            'amount' => $amount
        ];
        return $data;
    }

    public function pay(Request $request) {
        $amount = $request->amount;
        $returnHTML = view('vnpay.index')->with('amount', $amount)->render();
        return response()->json(array('success' => true, 'html'=>$returnHTML));
    }

    public function update_electric_number() {
        return view('employees.update_enumber');
    }

    public function getBillInfo(Request $request) {
        if (Auth::guard('customer')->check() || Auth::guard('employee')->check()) {
            $bill_id = $request->bill_id;
            session(['bill_id'=> $bill_id]);
            $bill = Bill::find($bill_id);
            $customer = $bill->customer;
            $department = $customer->department;
            $data['department'] = $department;
            $data['customer'] = $customer;
            $data['bill'] = $bill;
            return response()->json($data);
        }
    }

    public function createPayment() {
        session(['url_prev' => url()->previous()]);
        $vnp_TxnRef = self::generateRandomString();
        $vnp_OrderInfo = $_POST['order_desc'];
        $vnp_OrderType = $_POST['order_type'];
        $vnp_Amount = $_POST['amount'] * 100;
        $vnp_Locale = $_POST['language'];
        $vnp_BankCode = $_POST['bank_code'];
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.0.0",
            "vnp_TmnCode" => env('VNP_TMN_CODE'),
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => route('vnpay.return'),
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . $key . "=" . $value;
            } else {
                $hashdata .= $key . "=" . $value;
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = env('VNP_URL') . "?" . $query;
        $vnp_HashSecret = env('VNP_HASH_SECRET');
        if (isset($vnp_HashSecret)) {
            // $vnpSecureHash = md5($vnp_HashSecret . $hashdata);
            $vnpSecureHash = hash('sha256', $vnp_HashSecret . $hashdata);
            $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
        , 'message' => 'success'
        , 'data' => $vnp_Url);
//        echo json_encode($returnData);
        return redirect($vnp_Url);
    }

    public function vnpayReturn(Request $request) {
        $url = session('url_prev','/');
        if($request->vnp_ResponseCode == "00") {
            $bill_id = session('bill_id');
            if ($bill_id) {
                $bill = Bill::find($bill_id);
                $bill->paid_date = date('Y-m-d H:i:s');
                $bill->paid_mode = 'vnpay';
                $bill->status = 1;
                $bill->save();
            }
            session()->forget('bill_id');
            return redirect($url)->with('success' ,'Đã thanh toán phí dịch vụ');
        }
        session()->forget('url_prev');
        return redirect($url)->with('errors' ,'Lỗi trong quá trình thanh toán phí dịch vụ');
    }

    public static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
