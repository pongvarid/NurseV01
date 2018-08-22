<?php

namespace App\Services;

use App\Models\Course;
use App\Models\CourseIn;
use App\Models\Student;
use App\Services\CheckExercise;

class ExerciseChoice implements  CheckExercise{
    
    private $exerciseData;
 
    public function getData($data){
        $this->exerciseData = $data;
    }

    public function getAsk(){
     
        return $this->exerciseData;
    }

    public function getChoice(){
        $tmp_choice = explode("<answer>",$this->exerciseData->answer);
        $choice =  explode("<choice>",$tmp_choice[0]);

        return $choice;
    }

    public function check(){

        return "check";
    }
 

}