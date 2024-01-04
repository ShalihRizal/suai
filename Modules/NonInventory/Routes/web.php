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


Route::prefix('noninventory')->group(function () {
    Route::get('/', 'NonInventoryController@index');
    Route::get('/create', 'NonInventoryController@create');
    Route::get('/show/{id}', 'NonInventoryController@show');
    Route::get('/edit/{id}', 'NonInventoryController@edit');
    Route::post('/store', 'NonInventoryController@store');
    Route::post('/update/{id}', 'NonInventoryController@update');
    Route::get('/delete/{id}', 'NonInventoryController@destroy');
    Route::get('/getdata/{id}', 'NonInventoryController@getdata');
});

