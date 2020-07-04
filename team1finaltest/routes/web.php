<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('content');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/show/{id}', 'TestController@show')->name('show');


Route::get('/create', 'ApartmentController@create')->name('create');

Route::post('/store/{id}', 'ApartmentController@store')->name('store');
