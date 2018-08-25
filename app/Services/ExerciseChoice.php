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
     
         
    }

    public function checkAuto($choiceTrue,$choiceStudent){
        $score = 0;
        for($i=0;$i< count($choiceTrue);$i++){
            if($choiceTrue[$i] == $choiceStudent[$i]){
                $score++;
            }
        }
        return $score;
       
         
    }
 

}