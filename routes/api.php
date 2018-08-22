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
Route::post('/course_in','Course\CourseController@register'); //ลงทะเบียนเรียน
Route::get('/course_in/{id}','Course\CourseController@getCourseIn'); //ดึงวิชาที่ลงบะเบียนเรียน
Route::put('/close_course/{id}','Course\CourseController@closeCourse'); //ปิดรายวิชา
Route::get('/course_data/{id}','Course\CourseController@getCourse'); //ดึงข้อมูลรายวิชา
Route::get('/search_course/{course}','Course\CourseController@searchCourse');//search
Route::get('/view/coirse/{id}','Course\CourseController@viewCourse');
Route::resource('/logs','Logs\LogsController');
Route::resource('/exercise','Course\ExerciseController');
Route::get('/exercise_data/{id}','Course\ExerciseController@show'); //ดึงข้อมูลแบบฝึกหัด 

Route::resource('/logs','Logs\LogsController'); 

/*exercise*/
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


/* CourseIN */
Route::resource('/coursein','Course\CourseInController');   

/*exercise for doing and check */

Route::resource('/exercise/do/askanswer','Exercise\ExercisedAskAnswerController');   
