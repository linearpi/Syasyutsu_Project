<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Sample_log;

class Downloader extends Controller
{
	//csvファイルをエクスポート
    public function exportCSV(Request  $request)
    {

        $filename = 'sample_log-data.csv';
    
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];
    
        $callback = function () use ($request) {
            $handle = fopen('php://output', 'w');
    
            // Add CSV headers
            fputcsv($handle, [
				'id',
				'name',
				'width',
				'height',
				'judgment',
				'created_at',
				'updated_at',
            ]);
    
             // Fetch and process data in chunks
             //　日付検索を実施し、そのデータをCSVファイルに書き込んでいる
            if($request->method === "all"){
                Sample_log::chunk(25, function ($sample_logs) use ($handle) {
                    foreach ($sample_logs as $sample_log) {
                 // Extract data from each employee.
                        $data = [
                            isset($sample_log->id)? $sample_log->id : '',
                            isset($sample_log->name)? $sample_log->name : '',
                            isset($sample_log->width)? $sample_log->width : '',
                            isset($sample_log->height)? $sample_log->height : '',
                            isset($sample_log->judgment)? $sample_log->judgment : '',
                            isset($sample_log->created_at)? $sample_log->created_at : '',
                            isset($sample_log->updated_at)? $sample_log->updated_at : '',
                        ];
        
                 // Write data to a CSV file.
                        fputcsv($handle, $data);
                    }
                });
            }else if($request->method === "date"){
                Sample_log::whereDate('created_at',$request->q)->chunk(25, function ($sample_logs) use ($handle) {
                    foreach ($sample_logs as $sample_log) {
                 // Extract data from each employee.
                        $data = [
                            isset($sample_log->id)? $sample_log->id : '',
                            isset($sample_log->name)? $sample_log->name : '',
                            isset($sample_log->width)? $sample_log->width : '',
                            isset($sample_log->height)? $sample_log->height : '',
                            isset($sample_log->judgment)? $sample_log->judgment : '',
                            isset($sample_log->created_at)? $sample_log->created_at : '',
                            isset($sample_log->updated_at)? $sample_log->updated_at : '',
                        ];
        
                 // Write data to a CSV file.
                        fputcsv($handle, $data);
                    }
                });
            }else if($request->method === "range"){

                //期間を設定
                $old_period = $request->q1." 00:00:00";
                $new_period = $request->q2." 23:59:59";

                Sample_log::whereBetween('created_at',[$old_period,$new_period])->chunk(25, function ($sample_logs) use ($handle) {

                    foreach ($sample_logs as $sample_log) {
                        // Extract data from each employee.
                        $data = [
                            isset($sample_log->id)? $sample_log->id : '',
                            isset($sample_log->name)? $sample_log->name : '',
                            isset($sample_log->width)? $sample_log->width : '',
                            isset($sample_log->height)? $sample_log->height : '',
                            isset($sample_log->judgment)? $sample_log->judgment : '',
                            isset($sample_log->created_at)? $sample_log->created_at : '',
                            isset($sample_log->updated_at)? $sample_log->updated_at : '',
                        ];
        
                        // Write data to a CSV file.
                        fputcsv($handle, $data);
                    }
                });
            }else if($request->method === "judgment"){
                Sample_log::where('judgment',$request->q)->chunk(25, function ($sample_logs) use ($handle) {
                    foreach ($sample_logs as $sample_log) {
                 // Extract data from each employee.
                        $data = [
                            isset($sample_log->id)? $sample_log->id : '',
                            isset($sample_log->name)? $sample_log->name : '',
                            isset($sample_log->width)? $sample_log->width : '',
                            isset($sample_log->height)? $sample_log->height : '',
                            isset($sample_log->judgment)? $sample_log->judgment : '',
                            isset($sample_log->created_at)? $sample_log->created_at : '',
                            isset($sample_log->updated_at)? $sample_log->updated_at : '',
                        ];
        
                 // Write data to a CSV file.
                        fputcsv($handle, $data);
                    }
                });
            }else{
                fputcsv($handle, [
                    'id',
                    'name',
                    'width',
                    'height',
                    'judgment',
                    'created_at',
                    'updated_at',
                ]);
            }
    
            // Close CSV file handle
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }	



    public function exportIMAGE(Request $request){
        $log = json_decode($request->log);

        //画像名を取得
        $image_name_upper = $log->name_upper.".png";
        $image_name_side = $log->name_side.".png";

        //ヘッダーを作成
        $headers	=	['Content-Type' => 'image/png'];

        //画像が保存されているフォルダ
        $folder = $log->year."_".$log->month."_".$log->day;

        //
        $remoteURL = "http://192.168.11.13/nas/pictures/".$folder."/".$image_name_upper;  
        $savePath = "/home/syasyutsu_user/picture/image.png";

        $items = [
            "save-path" => $savePath,
            "remoteURL" => $remoteURL,
        ];

        //画像取得
        $image = file_get_contents($remoteURL);

        //画像一時保存
        file_put_contents($savePath,$image);

        return response()->download($savePath,$image_name);        
    }

}
