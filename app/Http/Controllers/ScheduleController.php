<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index(Request $request){
        $schedule = Schedule::with(['subject','user'])->get();
   
        return response()->json([
            'status' => true,
            'message' => 'Schedule listed Successfully',
            'data' => $schedule
        ], status: 200);
    }

    
    public function create(Request $request){
        $validateSchedule = Validator::make($request->all(), [
            'edpCode' => 'required|string|max:255',
            'offeringCode' => 'required|string|max:255',
            'subject_Id' => 'required',
            'day' => 'required|string|max:255',
            'timeIn' => 'required|string|max:255',
            'timeOut' => 'required|string|max:255',
            'user_Id' => 'required',
        ]);

        if ($validateSchedule->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'error' => $validateSchedule->errors()
            ], status: 401);
        }
        $schedule = Schedule::create([
            'edpCode' => $request->edpCode,
            'offeringCode' => $request->offeringCode,
            'subject_Id' => $request->subject_Id,
            'day' => $request->day,
            'timeIn' => $request->timeIn,
            'timeOut' => $request->timeOut,
            'user_Id' => $request->user_Id,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Schedule Created successfully',
        ], 200);
    
    }

    public function update(Request $request, $id){

        $duplicate_schedule = Schedule::where(
            'edpCode', $request->edpCode
            )->where('id', '!=', $id)
            ->first();

        if($duplicate_schedule) {
            return response()->json([
                'message' => $request->edpCode .' is already exist',
            ], status: 422);
        }
        
      
        $schedule = Schedule::findOrFail($id);
        $schedule->update($request->all());
        $schedule->save();
        return response()->json([
            'status' => true,
            'message' => 'Updated successfully',
            'data' => $schedule
        ], 200);
    
    }

    public function delete($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return response()->json([
            'status' => true,
            'message' => 'Deleted successfully'
        ], 200);
    }
}
