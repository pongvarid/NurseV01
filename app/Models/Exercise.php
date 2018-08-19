<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{

    protected $table = "exercise";
    protected $fillable = [
        "course",
        "type",
        "name",
        "score",
        "ask",
        "answer",
        "remark",
        "time",

    ];
}
