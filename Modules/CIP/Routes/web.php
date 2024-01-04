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

Route::prefix('cip')->group(function () {
    Route::get('/', 'CIPController@index');
});

Route::prefix('cip')->group(function () {
    Route::get('/', 'CIPController@index');
    Route::get('/create', 'CIPController@create');
    Route::get('/show/{id}', 'CIPController@show');
    Route::get('/edit/{id}', 'CIPController@edit');
    Route::post('/store', 'CIPController@store');
    Route::post('/update/{id}', 'CIPController@update');
    Route::get('/delete/{id}', 'CIPController@destroy');
    Route::get('/getdata/{id}', 'CIPController@getdata');
});


