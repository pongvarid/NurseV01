<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = "document";
    protected $fillable = [
        "name",
        "link",
        "course",
        "remark"

    ];
}
