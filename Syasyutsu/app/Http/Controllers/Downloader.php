<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log as LaravelLog;
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
                $nameUpper = $paraName . '_cam_id0';
                $nameSide  = $paraName . '_cam_id1';

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
    $logId = $request->query('log_id');
    if (!$logId) {
        abort(400, 'log_id が指定されていません');
    }

    LaravelLog::info('exportIMAGE called', ['log_id' => $logId]);

    // DB から log_id に対応する作成日時を取得
    $logTimestamp = \DB::table('logs')->where('id', $logId)->value('created_at');
    if (!$logTimestamp) {
        abort(404, '指定された log_id は存在しません');
    }

    $logDate = date('Y_m_d', strtotime($logTimestamp));
    $dir = "/mnt/nas/pictures/{$logDate}";

    if (!is_dir($dir)) {
        LaravelLog::warning('Directory not found', ['dir' => $dir]);
        abort(404, '画像ディレクトリが存在しません');
    }

    $upperFiles = glob($dir . '/*_cam_id0.*');
    $sideFiles  = glob($dir . '/*_cam_id1.*');

    LaravelLog::info('file listing', [
        'logTimestamp' => $logTimestamp,
        'dir' => $dir,
        'upper_count' => count($upperFiles),
        'side_count' => count($sideFiles)
    ]);

    if (empty($upperFiles) || empty($sideFiles)) {
        abort(404, '画像が見つかりません');
    }

    $logTs = strtotime($logTimestamp);
    $thresholdSec = 10;

    // upper 選択
    $closestUpper = null;
    $minDiffUpper = PHP_INT_MAX;
    foreach ($upperFiles as $f) {
        $ts = $this->extractTimestamp($f);
        if ($ts === 0) {
            LaravelLog::warning('timestamp extraction failed (upper)', ['file' => $f]);
            continue;
        }
        $diff = abs($logTs - $ts);
        LaravelLog::debug('upper candidate', [
            'file' => $f,
            'file_ts' => $ts,
            'diff_sec' => $diff,
        ]);
        if ($diff < $minDiffUpper) {
            $minDiffUpper = $diff;
            $closestUpper = $f;
        }
    }

    // side 選択
    $closestSide = null;
    $minDiffSide = PHP_INT_MAX;
    foreach ($sideFiles as $f) {
        $ts = $this->extractTimestamp($f);
        if ($ts === 0) {
            LaravelLog::warning('timestamp extraction failed (side)', ['file' => $f]);
            continue;
        }
        $diff = abs($logTs - $ts);
        LaravelLog::debug('side candidate', [
            'file' => $f,
            'file_ts' => $ts,
            'diff_sec' => $diff,
        ]);
        if ($diff < $minDiffSide) {
            $minDiffSide = $diff;
            $closestSide = $f;
        }
    }

    if (!$closestUpper || !$closestSide) {
        LaravelLog::warning('No image pair found', ['log_id' => $logId]);
        abort(404, '画像ペアが見つかりません');
    }

    // しきい値超過の警告
    if ($minDiffUpper > $thresholdSec) {
        LaravelLog::warning('upper image exceeds threshold', [
            'selected' => basename($closestUpper),
            'minDiff_sec' => $minDiffUpper,
            'threshold_sec' => $thresholdSec
        ]);
    }
    if ($minDiffSide > $thresholdSec) {
        LaravelLog::warning('side image exceeds threshold', [
            'selected' => basename($closestSide),
            'minDiff_sec' => $minDiffSide,
            'threshold_sec' => $thresholdSec
        ]);
    }

    LaravelLog::info('nearest selection', [
        'closest_upper' => basename($closestUpper),
        'closest_side' => basename($closestSide),
        'minDiff_upper_sec' => $minDiffUpper,
        'minDiff_side_sec' => $minDiffSide,
    ]);

\DB::table('logs')->where('id', $logId)->update([
    'name_upper' => basename($closestUpper),
    'name_side'  => basename($closestSide),
    'updated_at' => now(), // 任意：更新日時も記録
]);

    // ZIP ダウンロード
    if ($request->query('download') === 'zip') {
        $zipFile = storage_path("app/tmp/pairs_{$logId}.zip");
        if (!is_dir(dirname($zipFile))) {
            mkdir(dirname($zipFile), 0777, true);
        }

        $zip = new ZipArchive;
        if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            $zip->addFile($closestUpper, basename($closestUpper));
            $zip->addFile($closestSide, basename($closestSide));
            $zip->close();
        } else {
            LaravelLog::error('ZIP could not be created', ['zipFile' => $zipFile]);
            abort(500, 'ZIPファイルの作成に失敗しました');
        }

        return response()->download($zipFile)->deleteFileAfterSend(true);
    }

    // HTML 表示用
    return view('export_image', [
        'upper' => basename($closestUpper),
        'side'  => basename($closestSide),
        'logId' => $logId,
        'createdAt' => $logTimestamp,
    ]);
}

private function extractTimestamp(string $filename): int
{
    $base = basename($filename);
    if (preg_match('/_(\d{6})_cam_id\d\.(jpg|png)$/', $base, $matches)) {
        $timeStr = $matches[1]; // 093012
        $h = substr($timeStr, 0, 2);
        $m = substr($timeStr, 2, 2);
        $s = substr($timeStr, 4, 2);

        // 日付部分は固定ディレクトリ名から取得
        if (preg_match('/(\d{4}_\d{2}_\d{2})/', $filename, $dateMatches)) {
            $dateStr = str_replace('_', '-', $dateMatches[1]); // 2025_10_30 → 2025-10-30
            return strtotime("$dateStr $h:$m:$s");
        }
    }
    return 0;
}

}
