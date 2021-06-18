<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Customer;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index()
    {
        if (Auth::guard('customer')->check()) {
            $customer_id = Auth::guard('customer')->user()->id;
            $customer = Customer::find($customer_id);
            $department = $customer->department;
            $bills = Bill::where('customer_id', '=', $customer_id)->where('status', '=', Bill::UNPAID)->get();
            $data = [];
            if ($bills) {
                foreach ($bills as $bill) {
                    $temp = [
                        'time' => date('m/Y', strtotime($bill['to_date'])),
                        'initial_number' => $bill['initial_number'],
                        'final_number' => $bill['final_number'],
                        'from_date' => date('d-m-Y', strtotime($bill['from_date'])),
                        'to_date' => date('d-m-Y', strtotime($bill['to_date'])),
                        'id' => $bill['id'],
                        'amount' => $bill['amount'],
                        'status' => $bill['status'] ? 'Đã trả' : 'Chưa trả',
                    ];
                    array_push($data, $temp);
                }
            }
            return view('customers.index')->with('customer',$customer)->with('department', $department)
                ->with('bills',$data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username'=>'required|string',
            'password' => 'required|string',
            'name'=>'required',
            'email'=>'required|string|email',
            'address'=>'required',
            'phone' => 'required',
            'department_id' => 'required'
        ]);

        $customer = Customer::create(
            [
                'username' => $request->get('username'),
                'password' => Hash::make($request->get('password')),
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'address'=> $request->get('address'),
                'phone' => $request->get('phone'),
                'department_id' => $request->get('department_id'),
            ]);
        return response()->json($customer);
    }

    public function show(Customer $customer)
    {
        //
    }

    public function edit($id)
    {
        $customer = Customer::find($id);
        if (Auth::guard('customer')->check()) {
            return  view('customers.edit', compact('customer'));
        }
        elseif (Auth::guard('admin')->check()) {
           return response()->json($customer);
        }
    }

    public function update(Request $request, $id)
    {
        if (Auth::guard('customer')->check()) {
            $request->validate([
                'username'=>'required',
                'name'=>'required',
                'email'=>'required',
                'phone' => 'required',
                'address' => 'required'
            ]);

            $customer = Customer::updateOrCreate(
                ['id' => $id],
                [
                    'username'  => $request->get('username'),
                    'name'  => $request->get('name'),
                    'email' => $request->get('email'),
                    'phone' => $request->get('phone'),
                    'address' => $request->get('address'),
                ]);
    
            return redirect(route('customer.edit', $id));
        }
        elseif (Auth::guard('admin')->check()) {
            $request->validate([
                'username'=>'required',
                'password'=>'required',
                'name'=>'required',
                'email'=>'required',
                'phone' => 'required',
                'address' => 'required',
                'department_id' => 'required'
            ]);

            $customer = Customer::updateOrCreate(
                ['id' => $id],
                [
                    'username' => $request->get('username'),
                    'password' => Hash::make($request->get('password')),
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'phone' => $request->get('phone'),
                    'address' => $request->get('address'),
                    'department_id' => $request->get('department_id'),
                ]);
    
            return response()->json($customer);
        }
    }

    public function destroy($id)
    {
        try {
            $customer = Customer::where('id', '=', $id)->delete();
            return response()->json(['status' => 'Xoá thành công!']);
        } 
        catch (Exception $e){
            return response()->json(['error' => $e]);
        }
    }

    public function getCustomerListView() {
        if (Auth::guard('employee')->check()) {
            $data = [];
            $department_id = Auth::guard('employee')->user()->id;

            $customers = Customer::where('department_id', $department_id)->get();

            foreach ($customers as $customer) {
                $data[$customer->id] = [
                    'id' => $customer->id,
                    'username' => $customer->username,
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                    'address' => $customer->address
                ];
            }

            return view('employees.customer_list')->with('customers',$data);
        }
    }

    public function getCustomerList() {
        if (Auth::guard('employee')->check()) {
            $data = [];
            $department_id = Auth::guard('employee')->user()->id;

            $customers = Customer::select('id', 'username', 'name')
                        ->where('department_id', $department_id)->get();

            foreach ($customers as $customer) {
                $data[$customer->id] = [
                    'id' => $customer->id,
                    'username' => $customer->username,
                    'name' => $customer->name
                ];
            }

            return response()->json($data);
        }
    }

    public function getCustomerInfo(Request $request) {
        if (Auth::guard('employee')->check()) {
            $customer_id = $request->customer_id;
            $initial_number = $request->initial_number;
            $final_number = $request->final_number;
            $from_date = $request->from_date;
            $to_date = $request->to_date;
            $customer = Customer::find($customer_id);
            $department = $customer->department;
            $bill = BillController::calculate($initial_number, $final_number);
            $data['department'] = $department;
            $data['customer'] = $customer;
            $data['bill'] = [
                'amount' => $bill['amount'],
                'price_per_number' => $bill['price_per_number'],
                'initial_number' => $initial_number,
                'final_number' => $final_number,
                'from_date' => $from_date,
                'to_date' => $to_date
            ];

            return response()->json($data);
        }
    }
}
