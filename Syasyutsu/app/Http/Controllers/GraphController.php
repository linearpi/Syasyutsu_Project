<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class GraphController extends Controller
{
    public function generateGraph(Request $request)
    {
        $year = str_pad($request->input('year'), 4, '0', STR_PAD_LEFT);
        $month = str_pad($request->input('month'), 2, '0', STR_PAD_LEFT);
        $day = str_pad($request->input('day'), 2, '0', STR_PAD_LEFT);
        $startTime = $request->input('start_time', '00:00');
        $endTime   = $request->input('end_time', '23:59');

        Log::info("GraphController: 入力日付 => {$year}-{$month}-{$day} {$startTime}-{$endTime}");

        // Python 実行コマンド（仮想環境を有効化してスクリプト実行）
        $command = "bash -c 'export MPLCONFIGDIR=/tmp/mplconfig && source /home/j2321304/myenv/bin/activate && python3 /home/j2321304/gurahu_laravel.py $year $month $day $startTime $endTime'";
        Log::info("Python 実行コマンド: {$command}");

        $process = Process::fromShellCommandline($command);
        $process->run();

        if (!$process->isSuccessful()) {
            Log::error("Python 実行失敗: " . $process->getErrorOutput());
            return back()->withErrors(['error' => 'Python スクリプトの実行に失敗しました。']);
        }

        Log::info("Python 実行結果: " . $process->getOutput());

        // 画像取得元ディレクトリ（Pythonが生成した画像）
        $remoteDir = "/home/j2321304/output_images/{$year}_{$month}_{$day}";
        $localDir = public_path('output_images');

        if (!File::exists($localDir)) {
            File::makeDirectory($localDir, 0777, true);
        }

        $imageNames = ['height_graph.png', 'length_graph.png', 'width_graph.png'];
        $imageUrls = [];

        foreach ($imageNames as $name) {
            $remotePath = "{$remoteDir}/{$name}";
            $localFileName = "{$year}_{$month}_{$day}_{$name}";
            $localPath = "{$localDir}/{$localFileName}";

            if (!File::exists($remotePath)) {
                Log::error("ファイルが存在しません: {$remotePath}");
                return back()->withErrors(['error' => "{$name} が見つかりません。"]);
            }

            File::copy($remotePath, $localPath);
            $imageUrls[] = asset("output_images/{$localFileName}");
        }

        return view('app.result_graphdisplay', [
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'imageUrls' => $imageUrls
        ]);
    }
}
