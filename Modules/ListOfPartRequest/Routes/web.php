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

Route::prefix('listofpartrequest')->group(function () {
    Route::get('/', 'ListOfPartRequestController@index');
    Route::get('/create', 'ListOfPartRequestController@create');
    Route::get('/show/{id}', 'ListOfPartRequestController@show');
    Route::get('/edit/{id}', 'ListOfPartRequestController@edit');
    Route::post('/store', 'ListOfPartRequestController@store');
    Route::post('/update/{id}', 'ListOfPartRequestController@update');
    Route::get('/delete/{id}', 'ListOfPartRequestController@destroy');
    Route::get('/getdata/{id}', 'ListOfPartRequestController@getdata');
});
