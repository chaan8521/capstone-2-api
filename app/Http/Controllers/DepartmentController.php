<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\Validator;


class DepartmentController extends Controller
{
    public function index(Request $request){
        $departments = Department::all();
        return response()->json([
            'status' => true,
            'message' => 'Department listed Successfully',
            'data' => $departments
        ], status: 200);
    }

    public function create(Request $request){
        $validateDepartment = Validator::make($request->all(), [
            'department' => 'required|string|max:255|unique:departments,department',
        ]);

        if ($validateDepartment->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'error' => $validateDepartment->errors()
            ], status: 401);
        }
        $question = Department::create([
            'department' => $request->department,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Department Created successfully',
        ], 200);
    
    }

    public function update(Request $request, $id){


        $duplicate_department = Department::where('department', $request->department)->where('id', '!=', $id)->first();

        if($duplicate_department) {
            return response()->json([
                'message' => $request->department .' is already exist',
            ], status: 422);
        }
        
      
        $department = Department::findOrFail($id);
        $department->update($request->all());
        $department->save();
        return response()->json([
            'status' => true,
            'message' => 'Department Updated successfully',
            'data' => $department
        ], 200);
    
    }

    public function delete($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        return response()->noContent();
    }
}
