<?php
use Modules\MonthlyReport\Http\Controllers\MonthlyReportController;


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


Route::prefix('stockopname')->group(function () {
    Route::get('/', 'StockOpnameController@index');
    Route::get('/create', 'StockOpnameController@create');
    Route::get('/show/{id}', 'StockOpnameController@show');
    Route::get('/edit/{id}', 'StockOpnameController@edit');
    Route::post('/store', 'StockOpnameController@store');
    Route::post('/update/{id}', 'StockOpnameController@update');
    Route::get('/delete/{id}', 'StockOpnameController@destroy');
    Route::get('/getdata/{id}', 'StockOpnameController@getdata');
    Route::get('/scan', 'StockOpnameController@scan');
    Route::get('/hassto', 'StockOpnameController@hassto');
    Route::get('/nosto', 'StockOpnameController@nosto');
    Route::get('/updateall', 'StockOpnameController@updateall');
});

