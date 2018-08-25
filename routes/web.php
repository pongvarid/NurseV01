<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('user.index');
});
Route::get('/logout','Account\LoginController@logout');

Route::get('/teacher/profile', function () {
    return view('teacher.profile');
});
/* Updated upstream*/

Route::get('/student/profile', function () {
    return view('student.profile');
});

Route::get('/test2', function () {
    return view('teacher.test');
});

Route::get('/test','Account\LoginController@studentLogin');

//admin -----------------------------------------------------------//
Route::get('/admin', function () {
    return view('adminn.course');
});
Route::get('/admin/course', function () {
    return view('adminn.course');
});
Route::get('/admin/document', function () {
    return view('adminn.document');
});
Route::get('/admin/exercise', function () {
    return view('adminn.exercise');
});
Route::get('/admin/exercised', function () {
    return view('adminn.exercised');
});
Route::get('/admin/logs', function () {
    return view('adminn.logs');
});
Route::get('/admin/student', function () {
    return view('adminn.student');
});
Route::get('/admin/teacher', function () {
    return view('adminn.teacher');
});
//--------------------- end admin --------------------------------//
Route::get('/search', function () {
    return view('course.search');
});
/* Stashed changes*/

Route::get('/course/create', function () {
    return view('course.create');
});


Route::get('/course/profile/{id}', function () {
    return view('course.profile');
});
Route::get('/course/search', function () {
    return view('course.search');
});
Route::get('/crud', function () {
    return view('crud.crud');
});
Route::get('/c', function () {
    return view('crud.test');
});
Route::get('/course/edit_course/{id}', function () {
    return view('course.edit');
});

//Exercise---------------------------------------------------------------------------------------//
Route::get('/course/exercise/ask_exercise/{id}', function () {
    return view('exercise.ask_exercise.exercise');
});

Route::get('/course/exercise/edit_ask/{id}', function () {
    return view('exercise.ask_exercise.edit');
});

Route::get('/course/exercise/choice/{id}', function () {
    return view('exercise.choice.exercise');
});

Route::get('/course/exercise/choice_edit/{id}', function () {
    return view('exercise.choice.edit');
});
Route::get('/course/exercise/file/{id}', function () {
    return view('exercise.ask_file.exercise');
});
Route::get('/course/exercise/file_edit/{id}', function () {
    return view('exercise.ask_file.edit');
});
 
//(END)--Exercise---------------------------------------------------------------------------------------//

Route::get('/course/register/{id}', function () { //ลงทะเบียน
    return view('course.course_view.register_course');
});

Route::get('/student/course/{id}', function () { //course ของ นิสิต
    return view('student.student_view.course');
});

Route::get('/student/course/exercise/ask_exercise/{id}', function () { //นิสิต ทำ แบบฝึกหัดถามตอบ
    return view('student.student_view.ask_exercise');
});

Route::get('/student/course/exercise/choice_exercise/{id}', function () { //นิสิต ทำ choice
    return view('student.student_view.choice_exercise');
});

Route::get('/student/course/exercise/file_exercise/{id}', function () { //นิสิต ทำ file
    return view('student.student_view.file_exercise');
});

Route::get('/course/document/{id}', function () { //จัดการ document
    return view('document.index');
});

Route::get('/teacher/logs', function () { //จัดการ document
    return view('teacher.logs');
});

Route::get('/student/logs', function () { //จัดการ document
    return view('student.logs');
});


Route::get('/exercise/check/{id}', function () { //จัดการ document
    return view('exercise.check.menu');
});

Route::get('/exercise/check/askanswer/{id}', function () { //จัดการ document
    return view('exercise.check.ask_exercise');
});
Route::get('/exercise/check/askfile/{id}', function () { //จัดการ document
    return view('exercise.check.ask_file');
});
Route::get('/exercise/check/choice/{id}', function () { //จัดการ document
    return view('exercise.check.choice');
});