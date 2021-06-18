<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        if (Auth::guard('employee')->check()) {
            $employee_id = Auth::guard('employee')->user()->id;
            $employee = Employee::find($employee_id);
            $department = $employee->department;
            $bills = Bill::where('status', '=', Bill::UNPAID)->get();
            // $data = [];
            // if ($bills) {
            //     foreach ($bills as $bill) {
            //         $temp = [
            //             'time' => date('m/Y', strtotime($bill['to_date'])),
            //             'from_date' => date('d-m-Y', strtotime($bill['from_date'])),
            //             'to_date' => date('d-m-Y', strtotime($bill['to_date'])),
            //             'id' => $bill['id'],
            //             'customer' => Customer::where('id', $bill['customer_id'])->first()->username,
            //             'amount' => $bill['amount'],
            //             'status' => $bill['status'] ? 'Đã trả' : 'Chưa trả',
            //         ];
            //         array_push($data, $temp);
            //     }
            // }
            return view('employees.index')->with('employee',$employee)->with('department', $department)
                ->with('bills', $bills);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employee.create');
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
            'password' => 'required',
            'name'=>'required',
            'email'=>'required',
            'phone' => 'required',
            'department_id' => 'required'
        ]);

        $employee = Employee::create(
            [
                'username' => $request->get('username'),
                'password' => Hash::make($request->get('password')),
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'department_id' => $request->get('department_id'),
            ]);
        return response()->json($employee);
    }

    public function show(Employee $employee)
    {
        //
    }

    public function edit($id)
    {
        $employee = Employee::find($id);

        // return view('employees.edit', compact('employee'));
        return response()->json($employee);
    }

    public function update(Request $request, $id)
    {
        $validator = $request->validate([
            'username'=>'required',
            'password' => 'required',
            'name'=>'required',
            'email'=>'required',
            'phone' => 'required',
            'department_id' => 'required'
        ]);

        $employee = Employee::updateOrCreate(
            ['id' => $id],
            [
                'username' => $request->get('username'),
                'password' => Hash::make($request->get('password')),
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'department_id' => $request->get('department_id'),
            ]);

        return response()->json($employee);
    }

    public function destroy($id)
    {
        try {
            $employee = Employee::where('id', '=', $id)->delete();
            return response()->json(['status' => 'Xoá thành công!']);
        } 
        catch (Exception $e){
            return response()->json(['error' => $e]);
        }
    }
}
