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
    return view('adminn.index');
});
/* Stashed changes*/

Route::get('/course/create', function () {
    return view('course.create');
});

Route::get('/course/profile/{id}', function () {
    return view('course.profile');
});

 
