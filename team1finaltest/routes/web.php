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
Route::any('/store/{id}', 'ApartmentController@store')->name('store')->middleware('auth');
//Edit
Route::get('/edit/{id}', 'ApartmentController@edit')->name('edit')->middleware('auth');
// Update
Route::any('/update/{id}', 'ApartmentController@update')->name('update')->middleware('auth');
//SEARCH
Route::any('/search', 'ApartmentController@search')->name('search');
//Sent (Message)
Route::any('/sent/{id}', 'MessageController@sent')->name('sent');
//Casella messaggi
Route::get('/inbox', 'MessageController@inbox')->name('inbox')->middleware('auth');
//Pagina statistiche appartamento
Route::get('/stats/{id}', 'ApartmentController@stats')->name('stats')->middleware('auth');
//Pagina API statistiche
Route::get('/getStats/{id}', 'ApartmentController@getStats')->name('getStats')->middleware('auth');
//Pagina pagamenti
Route::get('/pay/{id}', 'PaymentController@pay')->name('pay')->middleware('auth');
//Pagina pagamenti
Route::any('/checkout/{id}', 'PaymentController@checkout')->name('checkout')->middleware('auth');
//Delete appartamenti
Route::match(['get', 'delete'], '/delete/{id}', 'ApartmentController@delete')->name('delete')->middleware('auth');
