<?php

use Illuminate\Support\Facades\Route;

Auth::routes();
//HomePage
Route::get('/', 'ApartmentController@index')->name('home');
//Profilo Utente
Route::get('/home', 'HomeController@user')->name('user');
//show
Route::get('/show/{id}', 'ApartmentController@show')->name('show');
//Create
Route::get('/create', 'ApartmentController@create')->name('create')->middleware('auth');
//Store
Route::post('/store/{id}', 'ApartmentController@store')->name('store')->middleware('auth');
//Edit
Route::get('/edit/{id}', 'ApartmentController@edit')->name('edit')->middleware('auth');
// Update
Route::post('/update/{id}', 'ApartmentController@update')->name('update')->middleware('auth');
//SEARCH
Route::post('/search', 'ApartmentController@search')->name('search');
//Message
Route::get('/message/{id}', 'MessageController@message')->name('message');
//Sent
Route::post('/sent/{id}', 'MessageController@sent')->name('sent');
//Casella messaggi
Route::get('/inbox', 'MessageController@inbox')->name('inbox')->middleware('auth');
//Pagina statistiche appartamento
Route::get('/stats/{id}', 'ApartmentController@stats')->name('stats')->middleware('auth');
//Pagina pagamenti
Route::get('/pay/{id}', 'PaymentController@pay')->name('pay');
//Pagina pagamenti
Route::post('/checkout/{id}', 'PaymentController@checkout')->name('checkout');
