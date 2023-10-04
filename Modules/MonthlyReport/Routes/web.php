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

Route::prefix('monthlyreport')->group(function() {
    Route::get('/', 'MonthlyReportController@index');
    Route::get('/export', 'MonthlyReportController@export')->name('export');
    Route::get('/exportExcel', 'MonthlyReportController@exportExcel')->name('exportExcel');
});

