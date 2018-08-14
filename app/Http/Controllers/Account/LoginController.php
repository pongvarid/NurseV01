<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\Student;
use App\Soap\UniversityOfPhayao;

class LoginController extends Controller
{
    public function checkStudent($username){
       $student =  Student::where('username',$username)->first();
        return $this->checkNull($student);
    }

    public function checkTeacher($username){
        $teacher = Teacher::where('username',$username)->first();
        return $this->checkNull($teacher);
    }

    public function checkNull($param){
        if($param != null){
            return 1;
        }else{
            return 0;
        }
    }

    public function teacherLogin(Request $request){ 
        $teacher = Teacher::where('username',$request->username)->where('password',$request->password)->first();
        $i_user =  $this->checkNull($teacher);
        if($i_user != 0){
          session_start();
            $_SESSION["user"] =  $teacher->id; 
            $_SESSION["user_type"] = "teacher";
            return 1;
        }else{
            return 0;
        }

    }

    public function studentLogin(Request $request){ 
        
        $up = new UniversityOfPhayao(); 
        $session_id = $up->getSID($request->username,$request->password);
        if(isset($session_id)){
           if($this->checkStudent($request->username) == 0){
               $student = new Student();
               $student->username = $request->username;
               $student->save;
           }
           session_start();
           $_SESSION["user"] =  $session_id;
           $_SESSION["student"] = $request->username;
           $_SESSION["user_type"] = "student"; 
           return 1;
        }else{
            return 0;
        }
     

    }

    public function getStudentData($session_id){
        $up = new UniversityOfPhayao(); 
        $jsonStudent = json_encode((array)  $up->getStudentInfo($session_id), JSON_UNESCAPED_UNICODE);
        return $jsonStudent ;
    }


    public function logout(){
        session_start();
        if($_SESSION["user_type"] == "student"){
            $up = new UniversityOfPhayao(); 
            $up->getLogOff($_SESSION["user"]);
        }
        session_unset();
        session_destroy(); 
        return redirect('/');
        
    }
}
