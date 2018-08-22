<?php

namespace App\Services;

use App\Models\Course;
use App\Models\CourseIn;
use App\Models\Student;

class StudentService{

    private $studentData;

    public function studentGetData($data){
        $this->studentData = $data;
     
    }   

    public function feathData(){
        $turn_student = array();
        $i=0;
        foreach( $this->studentData as $students){ 
            $tmp = Student::where('username',$students->student)->first();
            $this->studentData[$i]->studentIn =   (array) json_decode( $tmp);
            $i++;
        }
        return  $this->studentData;
    }


}