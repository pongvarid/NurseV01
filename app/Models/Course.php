<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = "course"; 
    protected $fillable = [
        "code",
        "name",
        "year",
        "teacher",
        "state",
    ];
}
