<?php

namespace App\Services;

use App\Models\Course;
use App\Models\CourseIn;
use App\Models\Student;
use App\Models\Logs;

class LogsService{

  
    public static function save($user,$type,$event){

        if($type == 1){
            $type = "teacher";
        }else{
            $type = "student";
        }

        $logs = new Logs();
        $logs->user = $user;
        $logs->type = $type; 
        $logs->event = $event;
         $logs->save();
 
    }


}