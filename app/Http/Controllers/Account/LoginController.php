<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\Student;

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
            return 1;
        }else{
            return 0;
        }

    }

    public function logout(){
        session_start();
        session_unset();
        session_destroy(); 
        
    }
}
