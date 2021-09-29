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

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function() {
    
    // ADMIN
    Route::get('/admin/users', 'admin\UserController@index')->name('admin.users');
    Route::post('/admin/users/getlist', 'admin\UserController@getsearchlist')->name('admin.users.list');
    Route::get('/admin/users/add', 'admin\UserController@create')->name('admin.users.create');

});