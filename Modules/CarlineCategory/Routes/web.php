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

Route::prefix('carlinecategory')->group(function () {
    Route::get('/', 'CarlineCategoryController@index');
    Route::get('/create', 'CarlineCategoryController@create');
    Route::get('/show/{id}', 'CarlineCategoryController@show');
    Route::get('/edit/{id}', 'CarlineCategoryController@edit');
    Route::post('/store', 'CarlineCategoryController@store');
    Route::post('/update/{id}', 'CarlineCategoryController@update');
    Route::get('/delete/{id}', 'CarlineCategoryController@destroy');
    Route::get('/getdata/{id}', 'CarlineCategoryController@getdata');
});

