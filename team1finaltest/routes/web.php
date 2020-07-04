<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('content');
});

Auth::routes();
//HomePage
Route::get('/home', 'HomeController@index')->name('home');
//show
Route::get('/show/{id}', 'TestController@show')->name('show');
//Create
Route::get('/create', 'ApartmentController@create')->name('create');
//Store
Route::post('/store/{id}', 'ApartmentController@store')->name('store');
