<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EvaluationResult;
use Illuminate\Support\Facades\Validator;
use App\Models\AssignedSchedule;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EvaluationResultController extends Controller
{
    public function index(Request $request){
        $eval_result = EvaluationResult::with(['question','assigned_schedule'])->get();
   
        return response()->json([
            'status' => true,
            'message' => 'Evaluation Result listed Successfully',
            'data' => $eval_result
        ], status: 200);
    }

    public function create(Request $request){
        $eval_result = $request->all();
        if(count($eval_result) > 0){

            foreach($eval_result as $result){
                $check_assigned_schedule_if_exist = AssignedSchedule::where('id', $result['assigned_schedule_Id'])->first();
                if(blank($check_assigned_schedule_if_exist)) {

                    return response()->json(['message' => 'Assigned Schedule not found '],400);
                }

                $duplicate_eval_results = EvaluationResult::where(
                    'assigned_schedule_Id', $request->assigned_schedule_Id
                    )
                    ->first();

                    if(blank($duplicate_eval_results)){
                        $data[] =[
                            'assigned_schedule_Id' => $result['assigned_schedule_Id'],
                            'question_Id' => $result['question_Id'],
                            'score' => $result['score'],
                       
                        ];
                    }

            }
            EvaluationResult::insert($data);
            return response()->json(['message' => 'Evaluation result Uploaded Successfully'],200);
        }
    }

    public function EvaluationResult(Request $request, $id)
    {
        $result = DB::table('evaluation_results')
                    ->select(
                        'questionaires.id as question_id',
                        'questionaires.description as question_description',
                        'subjects.descriptiveTitle as subject_title',
                        'schedules.id as schedule_id',
                        DB::raw('AVG(score) as score'),
                        DB::raw('SUM(score) as sum'),
                        DB::raw('COUNT(evaluation_results.id) as response')
                    )
                    ->leftJoin('assigned_schedules as as1', 'as1.id', '=', 'evaluation_results.assigned_schedule_Id')
                    ->leftJoin('schedules', 'schedules.id', '=', 'as1.schedule_Id')
                    ->leftJoin('users', 'users.id', '=', 'schedules.user_Id')
                    ->leftJoin('subjects', 'subjects.id', '=', 'schedules.subject_Id')
                    ->leftJoin('questionaires', 'questionaires.id', '=', 'evaluation_results.question_Id')
                    ->where('schedules.id', $id)
                    ->groupBy(
                        'questionaires.id',
                        'questionaires.description',
                        'subjects.descriptiveTitle',
                        'schedules.id'
                    )
                    ->get();
    
        return response()->json([
            'status' => true,
            'message' => 'Evaluation Result listed Successfully',
            'data' => $result
        ], status: 200);
    }
    
    public function EvaluationChartResult(Request $request, $teacherId)
    {
        $result = DB::table('evaluation_results')
                    ->select(
                        'schedules.id as schedule_id',
                        'subjects.descriptiveTitle as subject_title',
                        DB::raw('GROUP_CONCAT(DISTINCT questionaires.id) as question_ids'),
                        DB::raw('GROUP_CONCAT(DISTINCT questionaires.description) as question_descriptions'),
                        DB::raw('SUM(score) as sum')
                    )
                    ->leftJoin('assigned_schedules as as1', 'as1.id', '=', 'evaluation_results.assigned_schedule_Id')
                    ->leftJoin('schedules', 'schedules.id', '=', 'as1.schedule_Id')
                    ->leftJoin('users', 'users.id', '=', 'schedules.user_Id')
                    ->leftJoin('subjects', 'subjects.id', '=', 'schedules.subject_Id')
                    ->leftJoin('questionaires', 'questionaires.id', '=', 'evaluation_results.question_Id')
                    ->where('schedules.user_Id', $teacherId)
                    ->groupBy(
                        'schedules.id',
                        'subjects.descriptiveTitle',)
                    ->get();
    
        return response()->json([
            'status' => true,
            'message' => 'Evaluation Result listed Successfully',
            'data' => $result
        ], status: 200);
    }
    
}
