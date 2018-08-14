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

Route::get('/student/profile', function () {
    return view('student.profile');
});

Route::get('/test2', function () {
    return view('teacher.test2');
});

Route::get('/test','Account\LoginController@studentLogin');