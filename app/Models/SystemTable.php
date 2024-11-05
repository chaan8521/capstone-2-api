<?php

namespace App\Models;

use illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemTable extends Model
{
    use HasFactory;
    protected $fillable = ['category','description'];
}
