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
   return view('welcome');
});

Auth::routes();

// Route::get('/', 'HomeController@index')->name('home');
Route::get('/', 'UserController@index')->name('home');
Route::get('/users/create', 'UserController@create')->name('users.create');
Route::get('/users/{user}/edit', 'UserController@edit')->name('users.edit');
Route::post('/users/store', 'UserController@store')->name('users.store');
Route::put('/users/{user}', 'UserController@update')->name('users.update');
Route::delete('/users/{user}/delete', 'UserController@destroy')->name('users.destroy');

Route::get('/api/users', 'UserController@getUsers')->name('users.getUsers');
Route::get('/api/emailExist/{email}', 'UserController@emailExist')->name('email.exist');

