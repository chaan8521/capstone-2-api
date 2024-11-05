<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{
    public function index(Request $request){
        $subject = Subject::all();
        return response()->json([
            'status' => true,
            'message' => 'Subject listed Successfully',
            'data' => $subject
        ], status: 200);
    }

    public function create(Request $request){
        $validateSubject = Validator::make($request->all(), [
            'subjectCode' => 'required|string|max:255|unique:subjects,subjectCode',
            'descriptiveTitle' => 'required|string|max:255',
            'unit' => 'required',
            'room' => 'required|string|max:255'
        ]);

        if ($validateSubject->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'error' => $validateSubject->errors()
            ], status: 401);
        }
        $subject = Subject::create([
            'subjectCode' => $request->subjectCode,
            'descriptiveTitle' => $request->descriptiveTitle,
            'unit' => $request->unit,
            'room' => $request->room,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Subject Created successfully',
        ], 200);
    
    }
    public function update(Request $request, $id){

        $duplicate_subject = Subject::where(
            'subjectCode', $request->subjectCode
            )->where('id', '!=', $id)
            ->first();

        if($duplicate_subject) {
            return response()->json([
                'message' => $request->subjectCode .' is already exist',
            ], status: 422);
        }
        
      
        $subject = Subject::findOrFail($id);
        $subject->update($request->all());
        $subject->save();
        return response()->json([
            'status' => true,
            'message' => 'Updated successfully',
            'data' => $subject
        ], 200);
    
    }
    public function delete($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return response()->json([
            'status' => true,
            'message' => 'Deleted successfully'
        ], 200);
    }
}
