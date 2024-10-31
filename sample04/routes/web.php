<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/','App\Http\Controllers\AppController@index');
Route::get('index','App\Http\Controllers\AppController@index');


Route::get('post',function(){
	return view('app/post');
});
Route::post('post','App\Http\Controllers\AppController@post');



Route::get('search',function(){
	return view('app/search');
});
Route::post('search/all','App\Http\Controllers\AppController@search_all');
Route::post('search/date','App\Http\Controllers\AppController@search_date');
Route::post('search/range','App\Http\Controllers\AppController@search_range');
Route::post('search/judgment','App\Http\Controllers\AppController@search_judgment');


Route::post('/download','App\Http\Controllers\Downloader@download');
Route::post('/response','App\Http\Controllers\Downloader@response');



//Route::post('/test','App\Http\Controllers\Downloader@test');

/********************CSVサンプル*********************/
Route::resource('employee', EmployeeController::class);
Route::get('employee2','App\Http\Controllers\EmployeeController@index2');
Route::get('export-csv', [EmployeeController::class, 'exportCSV'])->name('export');
Route::post('import-csv', [EmployeeController::class, 'importCSV'])->name('import');