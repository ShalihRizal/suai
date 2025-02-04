<?php

use Modules\MonthlyReport\Http\Controllers\MonthlyReportController;
use Maatwebsite\Excel\Excel;


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
    Route::get('/', 'StockOpnameController@index')->name('index');
    Route::get('/af', 'StockOpnameController@afindex')->name('af');
    Route::get('/cf', 'StockOpnameController@cfindex')->name('cf');
    Route::get('/cd', 'StockOpnameController@cdindex')->name('cd');
    Route::get('/sp', 'StockOpnameController@spindex')->name('sp');
    Route::get('/create', 'StockOpnameController@create');
    Route::get('/show/{id}', 'StockOpnameController@show');
    Route::get('/edit/{id}', 'StockOpnameController@edit');
    Route::post('/store', 'StockOpnameController@store');
    Route::post('/update/sp/{id}', 'StockOpnameController@spupdate');
    Route::post('/update/cd/{id}', 'StockOpnameController@cdupdate');
    Route::post('/update/cf/{id}', 'StockOpnameController@cfupdate');
    Route::post('/update/af/{id}', 'StockOpnameController@afupdate');
    Route::get('/delete/{id}', 'StockOpnameController@destroy');
    Route::get('/getdata/{id}', 'StockOpnameController@getdata');
    Route::get('/getdatabypartno/{part_no}', 'StockOpnameController@getdataByPartNo');
    Route::get('/getdatabyparam/{param}', 'StockOpnameController@getdataByParam')
        ->where('param', '.*');
    Route::get('/scan', 'StockOpnameController@scan');
    Route::get('/hassto', 'StockOpnameController@hassto')->name('hassto');
    Route::get('/nosto', 'StockOpnameController@nosto')->name('nosto');
    Route::get('/updateall', 'StockOpnameController@updateall')->name('updateall');
    Route::get('/stockopname/hassto/adjusting', 'StockOpnameController@adjusting')->name('adjusting');
    Route::get('/export-hassto', 'StockOpnameController@hasstoexport')->name('exporthassto');
    Route::get('/export-nosto', 'StockOpnameController@nostoexport')->name('exportnosto');
});
