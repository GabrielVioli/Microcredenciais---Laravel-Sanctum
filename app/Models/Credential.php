<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Credential extends Model
{
    protected $fillable = [
        'token',
        'student_id',
        'user_id',
        'course_id'
    ];


}
