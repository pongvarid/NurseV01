<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/check/student/{username}','Account\LoginController@checkStudent');
Route::get('/check/teacher/{username}','Account\LoginController@checkTeacher');
Route::post('/check/teacher/login','Account\LoginController@teacherLogin'); 
Route::post('/check/student/login','Account\LoginController@studentLogin');

Route::get('/student/data/{session_id}','Account\LoginController@getStudentData');

Route::put('/course_in/addTA/{id}','Course\CourseInController@updatePermissionTA'); // add TA

Route::resource('/teacher','Teacher\TeacherController');
Route::resource('/course','Course\CourseController'); 
Route::post('/course/{id}','Course\CourseController@update');
Route::get('/check','Course\CourseController@check'); //ตรวจว่าลงเรียนยัง
Route::get('/check_closeCourse/{id}','Course\CourseController@check_closeCourse'); //ตรวจว่าวิชานี้ ปิดยัง
Route::post('/course_in','Course\CourseController@register'); //ลงทะเบียนเรียน
Route::get('/course_in/{id}','Course\CourseController@getCourseIn'); //ดึงวิชาที่ลงบะเบียนเรียน
Route::put('/close_course/{id}','Course\CourseController@closeCourse'); //ปิดรายวิชา
Route::put('/open_course/{id}','Course\CourseController@openCourse'); //เปิดรายวิชา
Route::get('/course_data/{id}','Course\CourseController@getCourse'); //ดึงข้อมูลรายวิชา
Route::get('/course_id/{id}','Course\CourseController@getCourseId'); //ดึงข้อมูลรายวิชาid โยนid แบบฝึกหัด
Route::get('/search_course/{course}','Course\CourseController@searchCourse');//search
Route::get('/view/coirse/{id}','Course\CourseController@viewCourse');
Route::resource('/logs','Logs\LogsController');
Route::resource('/exercise','Course\ExerciseController');
Route::get('/exercise_data/{id}','Course\ExerciseController@show'); //ดึงข้อมูลแบบฝึกหัด 
Route::get('/exercise_datatest/{id}&{student}','Course\ExerciseController@showTest');

Route::get('/check_exercised/{id}','Course\ExercisedController@checkExercised'); //เช็คว่าส่งการบ้าน?

Route::get('/check_date/{id}','Course\ExercisedController@checkDate'); //เช็ควัน? 

Route::resource('/logs','Logs\LogsController'); 

/*exercise*/
Route::resource('/exercised','Course\ExercisedController');
Route::resource('/exercise/askanswer','Exercise\AskAnswerController');

Route::resource('/exercise/choice','Exercise\ChoiceController');
Route::get('/exercise/choice/edit/ask/{id}','Exercise\ChoiceController@searchCourse');
/* admin */
Route::resource('/admin/teacher','Admin\TeacherController'); 
Route::resource('/admin/student','Admin\StudentController');  
Route::resource('/admin/course','Admin\CourseController');   
Route::resource('/admin/document','Admin\DocumentController');   
Route::resource('/admin/exercise','Admin\ExerciseController');   
Route::resource('/admin/exercised','Admin\ExercisedController');   
Route::resource('/admin/logs','Admin\LogsController');   

/* Document */
Route::resource('/document','Document\DocumentController');   
Route::get('/document_data/{id}','Document\DocumentController@getDocument');


/* CourseIN */
Route::resource('/coursein','Course\CourseInController');

Route::resource('/exercise/do/askanswer','Exercise\ExercisedAskAnswerController');  

Route::resource('/exercise/do/choice','Exercise\ExercisedChoiceController');  

/* Log */
Route::get('/log_data','Logs\LogsController@getLogs');

/* score */
Route::resource('/score','Course\ScoreController');  
Route::get('/show_score/{id}&{student}','Course\ScoreController@showScore');
Route::get('/score/{id}','Course\ScoreController@show');  

