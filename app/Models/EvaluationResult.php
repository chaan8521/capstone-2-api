<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationResult extends Model
{
    use HasFactory;
    protected $fillable = ['assigned_schedule_Id','question_Id','score']; 

    public function question()
    {
        return $this->belongsTo(Questionaire::class, 'question_Id');
    }

    public function assigned_schedule()
    {
        return $this->belongsTo(AssignedSchedule::class, 'assigned_schedule_Id');
    }


}
