<?php

namespace App\Services;

use App\Models\Course;
use App\Models\CourseIn;
use App\Models\Student;
use App\Services\CheckExercise;

class ExerciseAskAnswer implements  CheckExercise{
    
    private $exerciseData;

    public function ExerciseAskAnswer($data){
        $this->exerciseData = $data;
    }

    public function getAsk(){
        return  $this->exerciseData;
    }

    public function getChoice(){
        return "choice";
    }

    public function check(){

        return "check";
    }
 

}