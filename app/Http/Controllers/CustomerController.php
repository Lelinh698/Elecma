<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Customer;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'username'=>'required',
            'password'=>'required',
            'email'=>'required',
            'phone' => 'required',
            'address' => 'required'

        ]);

        $id = $request->get('id');
        $customer = Customer::updateOrCreate(
            ['id' => $id],
            [
                'username'  => $request->get('username'),
                'password' => Hash::make($request->get('$password')),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'address' => $request->get('address'),
            ]);

        return redirect(route('customer.edit', $id));
    }

    public function show(Customer $customer)
    {
        //
    }

    public function edit($id)
    {
        $customer = Customer::find($id);

        return  view('customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username'=>'required',
            'email'=>'required',
            'phone' => 'required',
            'address' => 'required'

        ]);

        $customer = Customer::updateOrCreate(
            ['id' => $id],
            [
                'username'  => $request->get('username'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'address' => $request->get('address'),
            ]);

        return redirect(route('customer.edit', $id));
    }

    public function destroy($id)
    {
        $customer = Customer::where('id', '=', $id)->delete();

//        return Response::json($customer);
        return redirect('/customers')->with('success', 'Customer deleted!');
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
            $customer = Customer::find($customer_id);
            $department = $customer->department;
            $bill = BillController::calculate($initial_number, $final_number);
            $data['department'] = $department;
            $data['customer'] = $customer;
            $data['bill'] = [
                'amount' => $bill['amount'],
                'price_per_number' => $bill['price_per_number'],
                'initial_number' => $initial_number,
                'final_number' => $final_number
            ];

            return response()->json($data);
        }
    }
}
