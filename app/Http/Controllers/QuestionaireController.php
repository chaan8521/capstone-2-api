<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questionaire;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class QuestionaireController extends Controller
{
    public function index(Request $request){
        $questions = Questionaire::all();
        return response()->json([
            'status' => true,
            'message' => 'Questions listed Successfully',
            'data' => $questions
        ], status: 200);
    }

    public function create(Request $request){
        $validateQuestionaire = Validator::make($request->all(), [
            'description' => 'required|string|max:255|unique:questionaires,description',
            'status' => 'required|string|max:255'
        ]);

        if ($validateQuestionaire->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'error' => $validateQuestionaire->errors()
            ], status: 401);
        }
        $question = Questionaire::create([
            'description' => $request->description,
            'status' => $request->status,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Question Created successfully',
        ], 200);
    
    }

    public function update(Request $request, $id){
        $duplicate_questionaire = Questionaire::where('description', $request->description)->where('id', '!=', $id)->first();

        if($duplicate_questionaire) {
            return response()->json([
                'message' => $request->description .' is already exist',
            ], status: 422);
        }
      
        $question = Questionaire::findOrFail($id);
        $question->update($request->all());
        $question->save();
        return response()->json([
            'status' => true,
            'message' => 'Question Updated successfully',
            'data' => $question
        ], 200);
    
    }

    public function delete($id)
    {
        $question = Questionaire::findOrFail($id);
        $question->delete();

        return response()->noContent();
    }
}
