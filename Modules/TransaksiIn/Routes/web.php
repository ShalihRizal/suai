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

Route::prefix('transaksiin')->group(function () {
    Route::get('/', 'TransaksiInController@index');
    Route::get('/create', 'TransaksiInController@create');
    Route::get('/show/{id}', 'TransaksiInController@show');
    Route::get('/edit/{id}', 'TransaksiInController@edit');
    Route::post('/store', 'TransaksiInController@store');
    Route::post('/update/{id}', 'TransaksiInController@update');
    Route::get('/delete/{id}', 'TransaksiInController@destroy');
    Route::get('/getdata/{id}', 'TransaksiInController@getdata');
    // Route::get('/filter-transactions', 'TransaksiInController@filterTransactions')->name('filter_transactions');


});
