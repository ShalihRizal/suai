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


Route::prefix('forecast')->group(function () {
    Route::get('/', 'ForecastController@index');
    Route::get('/create', 'ForecastController@create');
    Route::get('/show/{id}', 'ForecastController@show');
    Route::get('/edit/{id}', 'ForecastController@edit');
    Route::post('/store', 'ForecastController@store');
    Route::post('/update/{id}', 'ForecastController@update');
    Route::get('/delete/{id}', 'ForecastController@destroy');
    Route::get('/getdata/{id}', 'ForecastController@getdata');
});

