<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('index','App\Http\Controllers\ProductController@index');
Route::post('store','App\Http\Controllers\ProductController@store');

Route::get('img_index','App\Http\Controllers\ImgController@index');	//画像投稿
Route::post('img_store','App\Http\Controllers\ImgController@store');	//画像表示のみ
Route::post('img_create','App\Http\Controllers\ImgController@create');	//画像をＤＢに保存してindexにもどす
Route::get('img_show','App\Http\Controllers\ImgController@show');	//DBから画像を取得して表示
