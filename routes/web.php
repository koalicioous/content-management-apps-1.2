<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('home');

//Role
Route::resource('/role', 'RoleController');

//User
Route::get('/user/unverified', 'UserController@unverified');
Route::post('/user/{user}/role', 'UserController@updateRole');
Route::get('/user/active', 'UserController@activeUsers');

Route::get('/{vue_capture?}', function () {
    return view('layouts.master');
  })->where('vue_capture', '[\/\w\.-]*');
