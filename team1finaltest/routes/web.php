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

Route::get('/home', 'HomeController@index')->name('home');
<<<<<<< Updated upstream
Route::get('/show/{id}', 'TestController@show')->name('show');
=======

Route::get('/create', 'ApartmentController@create')->name('create');

Route::post('/store/{id}', 'ApartmentController@store')->name('store');
>>>>>>> Stashed changes
