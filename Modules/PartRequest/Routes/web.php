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


Route::prefix('partrequest')->group(function () {
    Route::get('/', 'PartRequestController@index');
    Route::get('/create', 'PartRequestController@create');
    Route::get('/show/{id}', 'PartRequestController@show');
    Route::get('/edit/{id}', 'PartRequestController@edit');
    Route::post('/store', 'PartRequestController@store');
    Route::post('/update/{id}', 'PartRequestController@update');
    Route::get('/delete/{id}', 'PartRequestController@destroy');
    Route::get('/getdata/{id}', 'PartRequestController@getdata');
});

