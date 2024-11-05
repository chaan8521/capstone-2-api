<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SystemTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SystemTableController extends Controller
{
    public function index(Request $request){
        $systemTable = SystemTable::all();
        return response()->json([
            'status' => true,
            'message' => 'Table System listed Successfully',
            'data' => $systemTable
        ], status: 200);
    }

    public function system_table_by_category($category)
    {
        $systemTable = SystemTable::where('category', $category)
            ->orderBy('id', 'ASC')
            ->get();

            return response()->json([
                'status' => true,
                'message' => 'Table System listed Successfully',
                'data' => $systemTable
            ], status: 200);
    }

    public function create(Request $request){
        $validateSystemTable = Validator::make($request->all(), [
            'category' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        if ($validateSystemTable->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'error' => $validateSystemTable->errors()
            ], status: 401);
        }
        $systemTable = SystemTable::create([
            'category' => $request->category,
            'description' => $request->description,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Table System Created successfully',
        ], 200);
    
    }

    public function update(Request $request, $id){

        $duplicate_sytemTable = SystemTable::where(
            'description', $request->description
            )->where('id', '!=', $id)
            ->first();

        if($duplicate_sytemTable) {
            return response()->json([
                'message' => $request->category .' is already exist',
            ], status: 422);
        }
        
      
        $systemTable = SystemTable::findOrFail($id);
        $systemTable->update($request->all());
        $systemTable->save();
        return response()->json([
            'status' => true,
            'message' => 'Updated successfully',
            'data' => $systemTable
        ], 200);
    
    }

    public function delete($id)
    {
        $systemTable = SystemTable::findOrFail($id);
        $systemTable->delete();

        return response()->json([
            'status' => true,
            'message' => 'Deleted successfully'
        ], 200);
    }
}
