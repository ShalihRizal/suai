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

Route::prefix('subrack')->group(function () {
    Route::get('/', 'SubRackController@index');
    Route::get('/create', 'SubRackController@create');
    Route::get('/show/{id}', 'SubRackController@show');
    Route::get('/edit/{id}', 'SubRackController@edit');
    Route::post('/store', 'SubRackController@store');
    Route::post('/update/{id}', 'SubRackController@update');
    Route::get('/delete/{id}', 'SubRackController@destroy');
    Route::get('/getdata/{id}', 'SubRackController@getdata');
});

