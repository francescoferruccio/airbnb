<?php

use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('content');
// });

Auth::routes();
//HomePage
Route::get('/', 'ApartmentController@index')->name('home');
//Profilo Utente
Route::get('/home', 'HomeController@user')->name('user');
//show
Route::get('/show/{id}', 'ApartmentController@show')->name('show');
//Create
Route::get('/create', 'ApartmentController@create')->name('create');
//Store
Route::post('/store/{id}', 'ApartmentController@store')->name('store');
//Edit
Route::get('/edit/{id}', 'ApartmentController@edit')->name('edit');
// Update
Route::post('/update/{id}', 'ApartmentController@update')->name('update');
//SEARCH
Route::post('/search', 'ApartmentController@search')->name('search');
//Message
Route::get('/message/{id}', 'MessageController@message')->name('message');
//Sent
Route::post('/sent/{id}', 'MessageController@sent')->name('sent');
