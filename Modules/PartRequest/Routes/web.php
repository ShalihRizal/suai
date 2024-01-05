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


Route::prefix('partrequest')->group(function () {
    Route::get('/', 'PartRequestController@index');
    Route::get('/create', 'PartRequestController@create');
    Route::get('/show/{id}', 'PartRequestController@show');
    Route::get('/edit/{id}', 'PartRequestController@edit');
    Route::post('/store', 'PartRequestController@store');
    Route::post('/update/{id}', 'PartRequestController@update');
    Route::get('/delete/{id}', 'PartRequestController@destroy');
    Route::get('/getdata/{id}', 'PartRequestController@getdata');
    Route::post('/sendwa', 'PartRequestController@SendWA');
    Route::get('/gambar/{id}', 'PartRequestController@gambar');

    Route::get('/sp', 'PartRequestController@spindex');
    Route::get('/sp/create', 'PartRequestController@spcreate');
    Route::get('/sp/show/{id}', 'PartRequestController@spshow');
    Route::get('/sp/edit/{id}', 'PartRequestController@spedit');
    Route::post('/sp/store', 'PartRequestController@spstore');
    Route::post('/sp/update/{id}', 'PartRequestController@spupdate');
    Route::get('/sp/delete/{id}', 'PartRequestController@spdestroy');
    Route::get('/sp/getdata/{id}', 'PartRequestController@getdata');

    Route::get('/cd', 'PartRequestController@cdindex');
    Route::get('/cd/create', 'PartRequestController@cdcreate');
    Route::get('/cd/show/{id}', 'PartRequestController@cdshow');
    Route::get('/cd/edit/{id}', 'PartRequestController@cdedit');
    Route::post('/cd/store', 'PartRequestController@cdstore');
    Route::post('/cd/update/{id}', 'PartRequestController@cdupdate');
    Route::get('/cd/delete/{id}', 'PartRequestController@cddestroy');
    Route::get('/cd/getdata/{id}', 'PartRequestController@getdata');

    Route::get('/af', 'PartRequestController@afindex');
    Route::get('/af/create', 'PartRequestController@afcreate');
    Route::get('/af/show/{id}', 'PartRequestController@afshow');
    Route::get('/af/edit/{id}', 'PartRequestController@afedit');
    Route::post('/af/store', 'PartRequestController@afstore');
    Route::post('/af/update/{id}', 'PartRequestController@afupdate');
    Route::get('/af/delete/{id}', 'PartRequestController@afdestroy');
    Route::get('/af/getdata/{id}', 'PartRequestController@getdata');

    Route::get('/cf', 'PartRequestController@cfindex');
    Route::get('/cf/create', 'PartRequestController@cfcreate');
    Route::get('/cf/show/{id}', 'PartRequestController@cfshow');
    Route::get('/cf/edit/{id}', 'PartRequestController@cfedit');
    Route::post('/cf/store', 'PartRequestController@cfstore');
    Route::post('/cf/update/{id}', 'PartRequestController@cfupdate');
    Route::get('/cf/delete/{id}', 'PartRequestController@cfdestroy');
    Route::get('/cf/getdata/{id}', 'PartRequestController@getdata');
});

