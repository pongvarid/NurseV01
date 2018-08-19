<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercised extends Model
{
    protected $table = "exercised";
    protected $fillable = [
        "course",
        "type",
        "student",
        "score",
        "answer"
    ];
}
