<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Downloader;

//Livewire
use App\Livewire\Counter;
use App\Livewire\PLCMonitor;

// NASのルーティング用
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

// 圧縮用
use App\Http\Controllers\ImageCompareController;
// webp
use App\Http\Controllers\WebpCompareController;

// グラフ
use App\Http\Controllers\GraphController;

/*
Route::get('/', function () {
    return view('welcome');
});
*/

/* インデックスページ */
Route::get('/','App\Http\Controllers\AppController@index');
Route::get('index','App\Http\Controllers\AppController@index');


/* ログ検索 */
Route::get('/search',function(){
	return view('app/search');
});

/* パラメタ検索 */
Route::get('/search/params',function(){
	return view('app/search_params');
});

/*横断検索　 ※  暫定、不要なら削除すること*/
Route::get('/search/combined',function(){
	return view('app/search_combined');
});

/* ログ検索結果 */
Route::get('/search/all','App\Http\Controllers\AppController@search_all');
Route::get('/search/paraName','App\Http\Controllers\AppController@search_paraName');
Route::get('/search/date','App\Http\Controllers\AppController@search_date');
Route::get('/search/range','App\Http\Controllers\AppController@search_range');
Route::get('/search/judgment','App\Http\Controllers\AppController@search_judgment');

/* パラメタ検索結果 */
Route::get('/search/params/all','App\Http\Controllers\ParamController@search_all');
Route::get('/search/params/name','App\Http\Controllers\ParamController@search_name');
Route::get('/search/params/date','App\Http\Controllers\ParamController@search_date');
Route::get('/search/params/active','App\Http\Controllers\ParamController@search_active');

/*横断検索　 ※  暫定、不要なら削除すること*/
Route::get('/search/combined/all', 'App\Http\Controllers\CombinedController@search_all');
Route::get('/search/combined/paraName', 'App\Http\Controllers\CombinedController@search_paraName');
Route::get('/search/combined/date', 'App\Http\Controllers\CombinedController@search_date');
Route::get('/search/combined/range', 'App\Http\Controllers\CombinedController@search_range');
Route::get('/search/combined/judgment', 'App\Http\Controllers\CombinedController@search_judgment');
Route::get('/search/combined/active', 'App\Http\Controllers\CombinedController@search_active');


Route::get('/test','App\Http\Controllers\AppController@test');

/* システム監視ページ */
Route::get('/monitor', PLCMonitor::class);

Route::get('/counter', Counter::class);


//CSVダウンロード
Route::get('export-csv', [Downloader::class, 'exportCSV'])->name('export/csv');
//画像ダウンロード
Route::get('export-image', [Downloader::class, 'exportIMAGE'])->name('export.image');

// NASルーティング用
Route::get('/image/{date}/{filename}', function ($date, $filename) {
    // $date = '2025-2-21' の場合、そのままアンダースコアに置換
    $dateDir = str_replace('-', '_', $date); // '2025_2_21'

    $filePath = "/mnt/nas/pictures/{$dateDir}/{$filename}.png";

    if (!file_exists($filePath)) {
        abort(404, "File not found: {$filePath}");
    }

    return response()->file($filePath);
})->where('date', '[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}')
  ->name('image.serve');

// NASルーティング(日付なし)
// routes/web.php
Route::get('/image/{date}/{filename}', function (string $date, string $filename) {
    // URLの日付は 2025-10-30、NASは 2025_10_30 想定
    $dirDate = str_replace('-', '_', $date);
    $dir = "/mnt/nas/pictures/{$dirDate}";

    $path = "{$dir}/{$filename}";

    if (!is_file($path)) {
        // セキュリティのため、拡張子無しで来た場合は拒否 or 補助
        // 補助したい場合は以下のように補完（任意）
        // foreach (['png','jpg','jpeg','webp'] as $ext) {
        //     if (is_file("{$dir}/{$filename}.{$ext}")) {
        //         $path = "{$dir}/{$filename}.{$ext}";
        //         break;
        //     }
        // }
    }

    abort_unless(is_file($path), 404, '画像が見つかりません');

    // Content-Type を適切に設定
    $mime = match (strtolower(pathinfo($path, PATHINFO_EXTENSION))) {
        'png'  => 'image/png',
        'jpg', 'jpeg' => 'image/jpeg',
        'webp' => 'image/webp',
        default => mime_content_type($path) ?: 'application/octet-stream',
    };

    return response()->file($path, [
        'Content-Type' => $mime,
        // キャッシュを効かせたい場合は以下を設定（任意）
        // 'Cache-Control' => 'public, max-age=31536000',
    ]);
})->name('image.serve');

Route::get('/pictures/{filename}', function ($filename) {
    $path = "/mnt/nas/pictures/{$filename}";
    if (!file_exists($path)) abort(404);
    return response()->file($path);
});

// 圧縮用
Route::get('/compare', [ImageCompareController::class, 'show']);
Route::post('/compare/custom', [ImageCompareController::class, 'compressCustom']);
//webp
Route::get('/compare-webp', [WebpCompareController::class, 'show']);

// グラフ
Route::get('/app/date-input', function () {
    return view('app.date_input'); // resources/views/app/date_input.blade.phpを指します
});

Route::post('/app/generate-graph', [GraphController::class, 'generateGraph']);

Route::get('/show-image', [Downloader::class, 'showIMAGE'])->name('show.image');
