<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssignedSchedule;
use Illuminate\Support\Facades\Auth;

class AssignedScheduleController extends Controller
{
    public function index(Request $request){
        $schedule = AssignedSchedule::with(['user','schedule'])->get();
        return response()->json([
            'status' => true,
            'message' => 'Schedule listed Successfully',
            'data' => $schedule
        ], status: 200);
    }

    public function assignedScheduleByUserId(Request $request)
    {
        $userId = Auth::id(); 
        $assignedSchedule = AssignedSchedule::with(['user', 'schedule'])
            ->where('user_id', $userId) 
            ->get();
    
        return response()->json([
            'status' => true,
            'message' => 'Assigned schedule listed successfully',
            'data' => $assignedSchedule
        ], 200); 
    }


    public function create(Request $request){
      
        $assignedSchedule = AssignedSchedule::create([
            'user_Id' => $request->user_Id,
            'schedule_Id' => $request->schedule_Id,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Assigned Schedule Created successfully',
        ], 200);
    
    }
    public function update(Request $request, $id){

        $assignedSchedule = AssignedSchedule::findOrFail($id);
        $assignedSchedule->update($request->all());
        $assignedSchedule->save();
        return response()->json([
            'status' => true,
            'message' => 'Updated successfully',
            'data' => $assignedSchedule
        ], 200);
    
    }
    public function delete($id)
    {
        $assignedSchedule = AssignedSchedule::findOrFail($id);
        $assignedSchedule->delete();

        return response()->json([
            'status' => true,
            'message' => 'Deleted successfully'
        ], 200);
    }
}
