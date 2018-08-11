<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $table = "teacher";

    protected $fillable = [
        "username",
        "password",
        "name",
        "remark",
        "count",
        "permission"
    ];
}
