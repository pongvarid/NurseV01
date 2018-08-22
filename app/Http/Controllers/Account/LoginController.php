<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\Student;
use App\Soap\UniversityOfPhayao;

class LoginController extends Controller
{
    /****ตรวจสอบชื่อผู้ใช้ (นักเรียน) ใน ดาต้าเบส  *****/
    public function checkStudent($username,$type){
    
       $student =  Student::where('username',$username)->first();
       if($type == '1'){
        return $this->checkNull($student);}
        else{
            return $student;
        }
    }

    /****ตรวจสอบชื่อผู้ใช้ (อาจารย์) ใน ดาต้าเบส  *****/
    public function checkTeacher($username){
        $teacher = Teacher::where('username',$username)->first();
        return $this->checkNull($teacher);
    }

    /****เช็คค่าว่างของข้อมูล*****/
    public function checkNull($param){
        if($param != null){
            return 1;
        }else{
            return 0;
        }
    }

    /****เข้าสู่ระบบอาจารย์*****/
    public function teacherLogin(Request $request){
        //ค้นหาชื่อผู้ใช้รหัสผ่านอาจารย์ในดาต้าเบส 
        $teacher = Teacher::where('username',$request->username)->where('password',$request->password)->first();
        $i_user =  $this->checkNull($teacher);
        if($i_user != 0){
            //เปิด session
          session_start(); 
            $_SESSION["user"] =  $teacher->id; 
            $_SESSION["admin"] = $teacher->permission; //admin เป็น 1 
            $_SESSION["user_type"] = "teacher"; //ประเภท user
            return 1;
        }else{
            return 0;
        }

    }

    
    /****เข้าสู่ระบบนิสิต*****/
    public function studentLogin(Request $request){ 
        //เรียกใช้ soap service ม.พะเยา
        $up = new UniversityOfPhayao(); 

        //โยน username password เข้าไปเพื่อให้รีเทริ์นกลับเป็น session_id
        $session_id = $up->getSID($request->username,$request->password);
        $check_session_id = isset($session_id);
        //ตรวจสอบว่ามีนิสิติอยู่มั้ยถ้าไม่มี session_id จะเป็น null 
        if( $check_session_id &&   $session_id != null){
            // ค้นหานิสิตใน database ว่ามีมั้ยถ้าไม่มีบันทึกรหัสลง database 
           if($this->checkStudent($request->username,'1') == 0){
               $student = new Student();
               $student->username = $request->username;
               $student->data = $this->getStudentData($session_id);
               $student->save();
           }else{
               $this->updateStudentData(  $request->username ,$this->getStudentData($session_id));
           }
           //เปิด session
           session_start();
           $_SESSION["user"] =  $session_id;
           $_SESSION["student"] = $request->username;
           $_SESSION["user_type"] = "student"; //ประเภท user
           return 1;
        }else{
            return 0;
        }
     

    }

    public function updateStudentData($username,$data){
        $student_items = $this->checkStudent($username,0);
       if( isset( $student_items )  ){ 
        $student = Student::find($student_items->id);
        $student->data = $data;
        $student->save();
       }
    }

    /****เรียกใช้ข้อมูลนิสิตเป็น json*****/
    public function getStudentData($session_id){
         //เรียกใช้ soap service ม.พะเยา
        $up = new UniversityOfPhayao(); 
        //แปลง stdclass to json
        $jsonStudent = json_encode((array)  $up->getStudentInfo($session_id), JSON_UNESCAPED_UNICODE);
        return $jsonStudent ;
    }

  /****ออกจากระบบ*****/
    public function logout(){
        session_start();
        //หากเป็นนักเรียนให้ ส่ง service ไป logoff บนมอน้อย
        if($_SESSION["user_type"] == "student"){
            //เรียกใช้ soap service ม.พะเยา
            $up = new UniversityOfPhayao(); 
            $up->getLogOff($_SESSION["user"]);
        }
        //เคลียค่า session และปิด session
        session_unset();
        session_destroy(); 
        //กลับไปหน้า login
        return redirect('/');
        
    }
}
