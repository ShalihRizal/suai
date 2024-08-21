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
    Route::get('/', 'StockOpnameController@index');
    Route::get('/af', 'StockOpnameController@afindex');
    Route::get('/cf', 'StockOpnameController@cfindex');
    Route::get('/cd', 'StockOpnameController@cdindex');
    Route::get('/sp', 'StockOpnameController@spindex');
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
    Route::get('/getdatabyparam/{param}', 'StockOpnameController@getdataByParam');
    Route::get('/scan', 'StockOpnameController@scan');
    Route::get('/hassto', 'StockOpnameController@hassto');
    Route::get('/nosto', 'StockOpnameController@nosto');
    Route::get('/updateall', 'StockOpnameController@updateall');
    Route::get('/adjusting', 'StockOpnameController@adjusting');
    Route::get('/export-hassto', 'StockOpnameController@hasstoexport');
    Route::get('/export-nosto', 'StockOpnameController@nostoexport');
});
