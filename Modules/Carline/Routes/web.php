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


Route::prefix('carline')->group(function () {
    Route::get('/', 'CarlineController@index');
    Route::get('/create', 'CarlineController@create');
    Route::get('/show/{id}', 'CarlineController@show');
    Route::get('/edit/{id}', 'CarlineController@edit');
    Route::post('/store', 'CarlineController@store');
    Route::post('/update/{id}', 'CarlineController@update');
    Route::get('/delete/{id}', 'CarlineController@destroy');
    Route::get('/getdata/{id}', 'CarlineController@getdata');
});

