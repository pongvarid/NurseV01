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
Route::resource('/logs','Logs\LogsController');
Route::resource('/exercise','Course\ExerciseController');
Route::resource('/logs','Logs\LogsController'); 

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


