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

Route::prefix('transaksiout')->group(function () {
    Route::get('/', 'TransaksiOutController@index');
    Route::get('/create', 'TransaksiOutController@create');
    Route::get('/show/{id}', 'TransaksiOutController@show');
    Route::get('/edit/{id}', 'TransaksiOutController@edit');
    Route::post('/store', 'TransaksiOutController@store');
    Route::post('/update/{id}', 'TransaksiOutController@update');
    Route::get('/delete/{id}', 'TransaksiOutController@destroy');
    Route::get('/getdata/{id}', 'TransaksiOutController@getdata');
});
