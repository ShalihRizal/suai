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



Route::prefix('notification')->group(function () {
    Route::get('/', 'NotificationController@index');
    Route::get('/create', 'NotificationController@create');
    Route::get('/show/{id}', 'NotificationController@show');
    Route::get('/edit/{id}', 'NotificationController@edit');
    Route::post('/store', 'NotificationController@store');
    Route::post('/update/{id}', 'NotificationController@update');
    Route::get('/delete/{id}', 'NotificationController@destroy');
    Route::get('/getdata/{id}', 'NotificationController@getdata');
});

