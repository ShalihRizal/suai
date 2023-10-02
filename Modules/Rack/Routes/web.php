<?php


Route::prefix('rack')->group(function () {
    Route::get('/', 'RackController@index');
    Route::get('/create', 'RackController@create');
    Route::get('/show/{id}', 'RackController@show');
    Route::get('/edit/{id}', 'RackController@edit');
    Route::post('/store', 'RackController@store');
    Route::post('/update/{id}', 'RackController@update');
    Route::get('/delete/{id}', 'RackController@destroy');
    Route::get('/getdata/{id}', 'RackController@getdata');
});

