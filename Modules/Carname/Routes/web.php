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


Route::prefix('carname')->group(function () {
    Route::get('/', 'CarnameController@index');
    Route::get('/create', 'CarnameController@create');
    Route::get('/show/{id}', 'CarnameController@show');
    Route::get('/edit/{id}', 'CarnameController@edit');
    Route::post('/store', 'CarnameController@store');
    Route::post('/update/{id}', 'CarnameController@update');
    Route::get('/delete/{id}', 'CarnameController@destroy');
    Route::get('/getdata/{id}', 'CarnameController@getdata');
});
