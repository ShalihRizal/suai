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



Route::prefix('supervisornotification')->group(function () {
    Route::get('/', 'SupervisorNotificationController@index');
    Route::get('/create', 'SupervisorNotificationController@create');
    Route::get('/show/{id}', 'SupervisorNotificationController@show');
    Route::get('/edit/{id}', 'SupervisorNotificationController@edit');
    Route::post('/store', 'SupervisorNotificationController@store');
    Route::post('/update/{id}', 'SupervisorNotificationController@update');
    Route::get('/delete/{id}', 'SupervisorNotificationController@destroy');
    Route::get('/getdata/{id}', 'SupervisorNotificationController@getdata');
});
// Route::prefix('partrequest')->group(function () {
//     Route::get('/getdata/{id}', 'PartRequestController@getdata');
// });
