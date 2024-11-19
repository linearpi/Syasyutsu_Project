<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Downloader;
/*
Route::get('/', function () {
    return view('welcome');
});
*/

/* インデックスページ */
Route::get('/','App\Http\Controllers\AppController@index');
Route::get('index','App\Http\Controllers\AppController@index');


/* 検索スページ */
Route::get('/search',function(){
	return view('app/search');
});


/* 検索結果ページ */
Route::post('search/all','App\Http\Controllers\AppController@search_all');
Route::post('search/paraName','App\Http\Controllers\AppController@search_paraName');
Route::post('search/date','App\Http\Controllers\AppController@search_date');
Route::post('search/range','App\Http\Controllers\AppController@search_range');
Route::post('search/judgment','App\Http\Controllers\AppController@search_judgment');


Route::get('/test','App\Http\Controllers\AppController@test');

/* システム監視ページ */
Route::get('/monitor','App\Http\Controllers\AppController@monitor');


//CSVダウンロード
Route::get('export-csv', [Downloader::class, 'exportCSV'])->name('export/csv');
//画像ダウンロード
Route::get('export-image', [Downloader::class, 'exportIMAGE'])->name('export/image');