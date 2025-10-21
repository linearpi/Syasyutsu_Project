<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use phpseclib3\Net\SSH2;
use phpseclib3\Net\SFTP;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

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
　　　　　　//ここの値を使用するラズパイ
        $host = '192.168.50.154';　　
        $username = 'j2421312';
        $password = 'mUB72jL';
　　　　　　//
        $ssh = new SSH2($host);
        if (!$ssh->login($username, $password)) {
            Log::error("SSH接続失敗");
            return back()->withErrors(['error' => 'ラズパイへのSSH接続に失敗しました。']);
        }

        $remoteDir = "/home/j2421312/output_images/{$year}_{$month}_{$day}";
        $command = "source ~/myenv/bin/activate && python3 ~/gurahu_laravel.py $year $month $day $startTime $endTime";
        Log::info("Python 実行コマンド: {$command}");
        $output = $ssh->exec($command);
        Log::info("Python 実行結果: " . $output);

        $sftp = new SFTP($host);
        if (!$sftp->login($username, $password)) {
            Log::error("SFTP接続失敗");
            return back()->withErrors(['error' => 'SFTPログインに失敗しました。']);
        }

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

            $fileContent = $sftp->get($remotePath);
            if ($fileContent === false) {
                Log::error("取得失敗: {$remotePath}");
                return back()->withErrors(['error' => "{$name} の取得に失敗しました。"]);
            }

            file_put_contents($localPath, $fileContent);
            $imageUrls[] = asset("output_images/{$localFileName}");
        }

        return view('app.graph_display', [
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'imageUrls' => $imageUrls
        ]);
    }
}
