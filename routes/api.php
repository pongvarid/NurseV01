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

Route::resource('/teacher','Teacher\TeacherController');
Route::resource('/course','Course\CourseController'); 
Route::post('/course/{id}','Course\CourseController@update');
Route::get('/course_data/{id}','Course\CourseController@getCourse');
Route::resource('/logs','Logs\LogsController');
Route::resource('/exercise','Course\ExerciseController');
Route::resource('/logs','Logs\LogsController'); 

/* admin */
Route::resource('/admint','Admin\TeacherController'); 
Route::resource('/admins','Admin\StudentController');  
Route::resource('/adminc','Admin\CourseController');   
Route::resource('/admind','Admin\DocumentController');   
Route::resource('/admine','Admin\ExerciseController');   
Route::resource('/admined','Admin\ExercisedController');   
Route::resource('/adminel','Admin\LogsController');   
