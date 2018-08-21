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

Route::get('/admin', function () {
    return view('document.index');
});
/* Stashed changes*/

Route::get('/course/create', function () {
    return view('course.create');
});


Route::get('/course/profile/{id}', function () {
    return view('course.profile');
});

Route::get('/crud', function () {
    return view('crud.crud');
});
Route::get('/c', function () {
    return view('crud.test');
});
Route::get('/course/exercise/ask_exercise/{id}', function () {
    return view('exercise.ask_exercise.exercise');
});

Route::get('/course/edit_course/{id}', function () {
    return view('course.edit');
});

Route::get('/course/exercise/edit_ask/{id}', function () {
    return view('exercise.ask_exercise.edit');
});

Route::get('/course/register/{id}', function () { //ลงทะเบียน
    return view('course.view_course.register_course');
});



