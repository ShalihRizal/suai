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


Route::prefix('partconsumptionlist')->group(function () {
    Route::get('/', 'PartConsumptionListController@index');
    Route::get('/create', 'PartConsumptionListController@create');
    Route::get('/show/{id}', 'PartConsumptionListController@show');
    Route::get('/edit/{id}', 'PartConsumptionListController@edit');
    Route::post('/store', 'PartConsumptionListController@store');
    Route::post('/update/{id}', 'PartConsumptionListController@update');
    Route::get('/delete/{id}', 'PartConsumptionListController@destroy');
    Route::get('/getdata/{id}', 'PartConsumptionListController@getdata');
});
