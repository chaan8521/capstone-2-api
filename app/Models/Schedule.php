<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $fillable = ['edpCode','offeringCode','subject_Id','day','timeIn','timeOut','user_Id'];

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_Id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_Id');
    }


}
