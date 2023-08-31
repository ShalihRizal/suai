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


Route::prefix('part')->group(function () {
    Route::get('/', 'PartController@index');
    Route::get('/create', 'PartController@create');
    Route::get('/show/{id}', 'PartController@show');
    Route::get('/edit/{id}', 'PartController@edit');
    Route::post('/store', 'PartController@store');
    Route::post('/update/{id}', 'PartController@update');
    Route::get('/delete/{id}', 'PartController@destroy');
    Route::get('/getdata/{id}', 'PartController@getdata');
});

