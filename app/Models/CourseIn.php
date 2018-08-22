<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseIn extends Model
{

    protected $table = "course_in"; 
    protected $fillable = [
        "student",
        "course",
        "permission",
    ];
}
