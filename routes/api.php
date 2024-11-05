<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\QuestionaireController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AssignedScheduleController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SystemTableController;
use App\Http\Controllers\TableSystemController;
use App\Http\Controllers\EvaluationResultController;

//Register
Route::post("register",[RegisterController::class,"register"]);

//Login
Route::post("login",[LoginController::class,"login"]);



Route::group([
    "middleware" => ["auth:sanctum"]
],function(){
Route::get("profile",[LoginController::class,"profile"]);   
Route::get("logout",[LoginController::class,"logout"]);


//Questionaire
Route::get("question",[QuestionaireController::class,"index"]);
Route::post("question",[QuestionaireController::class,"create"]);
Route::put("question/{id}",[QuestionaireController::class,"update"]);
Route::delete("question/{id}",[QuestionaireController::class,"delete"]);


//Department
Route::get("department",[DepartmentController::class,"index"]);
Route::post("department",[DepartmentController::class,"create"]);
Route::put("department/{id}",[DepartmentController::class,"update"]);
Route::delete("department/{id}",[DepartmentController::class,"delete"]);

//Subject
Route::get("subject",[SubjectController::class,"index"]);
Route::post("subject",[SubjectController::class,"create"]);
Route::put("subject/{id}",[SubjectController::class,"update"]);
Route::delete("subject/{id}",[SubjectController::class,"delete"]);

//User
Route::get("user",[UserController::class,"index"]);
Route::post("user",[UserController::class,"create"]);
Route::put("user/{id}",[UserController::class,"update"]);
Route::delete("user/{id}",[UserController::class,"delete"]);
Route::get("user/teachers",[UserController::class,'getTeachers']);
Route::get("user/students",[UserController::class,'getStudents']);

// Assigned Schedule
Route::get("assigned/schedule",[AssignedScheduleController::class,"index"]);
Route::get("assigned/schedule/student",[AssignedScheduleController::class,"assignedScheduleByUserId"]);
Route::post("assigned/schedule",[AssignedScheduleController::class,"create"]);
Route::put("assigned/schedule/{id}",[AssignedScheduleController::class,"update"]);
Route::delete("assigned/schedule/{id}",[AssignedScheduleController::class,"delete"]);

//Schedule
Route::get("schedule",[ScheduleController::class,"index"]);
Route::post("schedule",[ScheduleController::class,"create"]);
Route::put("schedule/{id}",[ScheduleController::class,"update"]);
Route::delete("schedule/{id}",[ScheduleController::class,"delete"]);

//Table System

Route::get("system/table",[SystemTableController::class,"index"]);
Route::post("system/table",[SystemTableController::class,"create"]);
Route::put("system/table/{id}",[SystemTableController::class,"update"]);
Route::delete("system/table/{id}",[SystemTableController::class,"delete"]);
Route::get("system/table/{category}",[SystemTableController::class,"system_table_by_category"]);

//Evaluation Result
Route::get("evaluation/result",[EvaluationResultController::class,"index"]);
Route::get("evaluation/result/{teacherId}",[EvaluationResultController::class,"EvaluationChartResult"]);
Route::get("evaluation/result/table/{id}",[EvaluationResultController::class,"EvaluationResult"]);
Route::post("evaluation/result",[EvaluationResultController::class,"create"]);
});




