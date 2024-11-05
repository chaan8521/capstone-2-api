<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class AssignedSchedule extends Model
{
    use HasFactory;
    protected $fillable = ['user_Id','schedule_Id']; 

    public function user()
    {
        return $this->belongsTo(User::class, 'user_Id');
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_Id');
    }

}
