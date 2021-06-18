<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
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

    public function store(Request $request)
    {
        $validator = $request->validate([
            'name'=>'required',
            'address' => 'required'
        ]);

        $department = Department::create(
            [
                'name'  => $request->get('name'),
                'address' => $request->get('address'),
            ]);

        return response()->json($department);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $department = Department::find($id);
    
        return response()->json($department);
    }

    public function update(Request $request, $id)
    {
        $validator = $request->validate([
            'name'=>'required',
            'address' => 'required'
        ]);

        $department = Department::updateOrCreate(
            ['id' => $id],
            [
                'name'  => $request->get('name'),
                'address' => $request->get('address'),
            ]);

        return response()->json($department);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $department = Department::find($id)->delete();
            return response()->json(['status' => 'Xóa thành công']);
        }
        catch (Exception $e) {
            return response()->json(['error' => $e]);
        }
    }
}
