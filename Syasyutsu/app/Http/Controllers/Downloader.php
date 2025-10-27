<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Log;
use ZipArchive;

class Downloader extends Controller
{
	//csvファイルをエクスポート
    public function exportCSV(Request $request)
{
    $filename = 'log-data.csv';

    $headers = [
        'Content-Type'        => 'text/csv',
        'Content-Disposition' => "attachment; filename=\"$filename\"",
        'Pragma'              => 'no-cache',
        'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
        'Expires'             => '0',
    ];

    $callback = function () use ($request) {
        $handle = fopen('php://output', 'w');

        // CSV ヘッダ行（従来通り）
        fputcsv($handle, [
            'id',
            'name_upper',
            'name_side',
            'paraName',
            'width',
            'length',
            'height',
            'judgment',
            'created_at',
            'updated_at',
        ]);

        // 共通処理: created_at から分解して name/paraName を生成
        $writeLogs = function ($logs) use ($handle) {
            foreach ($logs as $log) {
                [$datePart, $timePart] = explode(' ', (string)$log->created_at);
                $year  = substr($datePart, 0, 4);
                $month = substr($datePart, 5, 2);
                $day   = substr($datePart, 8, 2);
                $time  = str_replace(':', '', $timePart);

                $paraName  = "{$year}_{$month}_{$day}_{$time}";
                $nameUpper = $paraName . '_a';
                $nameSide  = $paraName . '_b';

                $data = [
                    $log->id,
                    $nameUpper,
                    $nameSide,
                    $paraName,
                    $log->width,
                    $log->length,
                    $log->height,
                    $log->judgment,
                    $log->created_at,
                    $log->updated_at,
                ];
                fputcsv($handle, $data);
            }
        };

        // 条件ごとに分岐
        if ($request->method === "all") {
            Log::chunk(25, $writeLogs);
        } elseif ($request->method === "date") {
            Log::whereDate('created_at', $request->q)->chunk(25, $writeLogs);
        } elseif ($request->method === "range") {
            $old_period = $request->q1 . " 00:00:00";
            $new_period = $request->q2 . " 23:59:59";
            Log::whereBetween('created_at', [$old_period, $new_period])->chunk(25, $writeLogs);
        } elseif ($request->method === "judgment") {
            Log::where('judgment', $request->q)->chunk(25, $writeLogs);
        }

        fclose($handle);
    };

    return response()->stream($callback, 200, $headers);
}

public function exportParamCSV(Request $request)
{
    $filename = 'param-data.csv';

    $headers = [
        'Content-Type'        => 'text/csv',
        'Content-Disposition' => "attachment; filename=\"$filename\"",
        'Pragma'              => 'no-cache',
        'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
        'Expires'             => '0',
    ];

    $callback = function () use ($request) {
        $handle = fopen('php://output', 'w');

        // CSV ヘッダ
        fputcsv($handle, [
            'id',
            'paraName',
            'thresh',
            'width',
            'length',
            'height',
            'created_at',
            'active',
        ]);

        // データ出力
        DB::table('parameta')->orderBy('id')->chunk(25, function ($params) use ($handle) {
            foreach ($params as $param) {
                // active を文字列に変換
                $active = $param->active ? 'ACTIVE' : 'INACTIVE';

                // paraName は name をそのまま利用
                $data = [
                    $param->id,
                    $param->name,
                    $param->thresh,
                    $param->width,
                    $param->length,
                    $param->height,
                    $param->created_at,
                    $active,
                ];
                fputcsv($handle, $data);
            }
        });

        fclose($handle);
    };

    return response()->stream($callback, 200, $headers);
}
	



public function exportIMAGE(Request $request)
{
    // log_id で再取得
    $log = \App\Models\Log::find($request->log_id);

    if (!$log) {
        abort(404, 'ログが見つかりません');
    }

    // 画像名を取得・Zip名を作成
    $image_name_upper = ($log->name_upper ?? 'no_name') . ".png";
    $image_name_side  = ($log->name_side  ?? 'no_name') . ".png";
    $zip_name = "download.zip";

    // created_at から年・月・日を抽出（ゼロ埋めなし）
    $createdAt = (string)$log->created_at;
    [$datePart, $timePart] = explode(' ', $createdAt);

    $year  = (int)substr($datePart, 0, 4); // 例: '2025' → 12025
    $month = (int)substr($datePart, 5, 2); // 例: '10' → 10
    $day   = (int)substr($datePart, 8, 2); // 例: '07' → 7
    
// 時刻（コロンを除去して "135649" にする）
$time  = str_replace(':', '', $timePart);

$paraName   = sprintf("%04d_%02d_%02d_%s", $year, $month, $day, $time);
$nameUpper  = $paraName . '_a';
$nameSide   = $paraName . '_b';

    $folder = "{$year}-{$month}-{$day}"; // → '12025-10-7'

    $imageUrlUpper = route('image.serve', ['date' => $folder, 'filename' => $nameUpper]);
    $imageUrlSide  = route('image.serve', ['date' => $folder, 'filename' => $nameSide]);

    // 保存先ディレクトリ
    $savePath = storage_path('app/tmp/');
    if (!file_exists($savePath)) {
        mkdir($savePath, 0755, true);
    }

    $savePath_zip   = $savePath . $zip_name;
    $savePath_upper = $savePath . "image_upper.png";
    $savePath_side  = $savePath . "image_side.png";

    // 画像取得
    $raw_image_upper = file_get_contents($imageUrlUpper);
    $raw_image_side  = file_get_contents($imageUrlSide);

    // 一時保存
    file_put_contents($savePath_upper, $raw_image_upper);
    file_put_contents($savePath_side, $raw_image_side);

        // ZipArchive を使って圧縮
// created_at から生成したファイル名を使う
$nameUpper  = $paraName . '_a.png';
$nameSide   = $paraName . '_b.png';

// ZipArchive を使って圧縮
$zip = new ZipArchive;
if ($zip->open($savePath_zip, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
    $zip->addFile($savePath_upper, $nameUpper);
    $zip->addFile($savePath_side, $nameSide);
    $zip->close();
} else {
    abort(500, 'Zipファイルの作成に失敗しました');
}
    return response()->download($savePath_zip, basename($savePath_zip)) 
                     ->deleteFileAfterSend(true);
}

}
