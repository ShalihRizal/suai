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

Route::prefix('machine')->group(function() {
    Route::get('/', 'MachineController@index');
});


Route::prefix('machine')->group(function () {
    Route::get('/', 'MachineController@index');
    Route::get('/create', 'MachineController@create');
    Route::get('/show/{id}', 'MachineController@show');
    Route::get('/edit/{id}', 'MachineController@edit');
    Route::post('/store', 'MachineController@store');
    Route::post('/update/{id}', 'MachineController@update');
    Route::get('/delete/{id}', 'MachineController@destroy');
    Route::get('/getdata/{id}', 'MachineController@getdata');
});

