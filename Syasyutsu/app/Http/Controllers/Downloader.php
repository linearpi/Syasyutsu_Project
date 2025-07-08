<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Log;
use Zip;

class Downloader extends Controller
{
	//csvファイルをエクスポート
    public function exportCSV(Request  $request)
    {

        $filename = 'log-data.csv';
    
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
    
             // Fetch and process data in chunks
             //　日付検索を実施し、そのデータをCSVファイルに書き込んでいる
            if($request->method === "all"){
                Log::chunk(25, function ($sample_logs) use ($handle) {
                    foreach ($sample_logs as $log) {
                 // Extract data from each employee.
                        $data = [
                            isset($log->id)? $log->id : '',
                            isset($log->name_upper)? $log->name_upper : '',
                            isset($log->name_side)? $log->name_side : '',
                            isset($log->paraName)? $log->paraName : '',
                            isset($log->width)? $log->width : '',
                            isset($log->length)? $log->length : '',
                            isset($log->height)? $log->height : '',
                            isset($log->judgment)? $log->judgment : '',
                            isset($log->created_at)? $log->created_at : '',
                        ];
        
                 // Write data to a CSV file.
                        fputcsv($handle, $data);
                    }
                });
            }else if($request->method === "date"){
                Log::whereDate('created_at',$request->q)->chunk(25, function ($sample_logs) use ($handle) {
                    foreach ($sample_logs as $log) {
                 // Extract data from each employee.
                        $data = [
                            isset($log->id)? $log->id : '',
                            isset($log->name_upper)? $log->name_upper : '',
                            isset($log->name_side)? $log->name_side : '',
                            isset($log->paraName)? $log->paraName : '',
                            isset($log->width)? $log->width : '',
                            isset($log->length)? $log->length : '',
                            isset($log->height)? $log->height : '',
                            isset($log->judgment)? $log->judgment : '',
                            isset($log->created_at)? $log->created_at : '',
                        ];
        
                 // Write data to a CSV file.
                        fputcsv($handle, $data);
                    }
                });
            }else if($request->method === "range"){

                //期間を設定
                $old_period = $request->q1." 00:00:00";
                $new_period = $request->q2." 23:59:59";

                Log::whereBetween('created_at',[$old_period,$new_period])->chunk(25, function ($sample_logs) use ($handle) {

                    foreach ($sample_logs as $log) {
                        // Extract data from each employee.
                        $data = [
                            isset($log->id)? $log->id : '',
                            isset($log->name_upper)? $log->name_upper : '',
                            isset($log->name_side)? $log->name_side : '',
                            isset($log->paraName)? $log->paraName : '',
                            isset($log->width)? $log->width : '',
                            isset($log->length)? $log->length : '',
                            isset($log->height)? $log->height : '',
                            isset($log->judgment)? $log->judgment : '',
                            isset($log->created_at)? $log->created_at : '',
                        ];
        
                        // Write data to a CSV file.
                        fputcsv($handle, $data);
                    }
                });
            }else if($request->method === "judgment"){
                Log::where('judgment',$request->q)->chunk(25, function ($sample_logs) use ($handle) {
                    foreach ($sample_logs as $log) {
                 // Extract data from each employee.
                 $data = [
                    isset($log->id)? $log->id : '',
                    isset($log->name_upper)? $log->name_upper : '',
                    isset($log->name_side)? $log->name_side : '',
                    isset($log->paraName)? $log->paraName : '',
                    isset($log->width)? $log->width : '',
                    isset($log->length)? $log->length : '',
                    isset($log->height)? $log->height : '',
                    isset($log->judgment)? $log->judgment : '',
                    isset($log->created_at)? $log->created_at : '',
                ];
        
                 // Write data to a CSV file.
                        fputcsv($handle, $data);
                    }
                });
            }else{
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
                ]);
            }
    
            // Close CSV file handle
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }	



public function exportIMAGE(Request $request){
    $log = json_decode($request->log);

    \Log::debug('raw log payload: ' . json_encode($log));

    //画像名を取得・Zip名を作成
    $image_name_upper = $log->name_upper.".png";
    $image_name_side = $log->name_side.".png";
    $zip_name = "download.zip";

    //画像が保存されているフォルダ
    $folder = $log->year . "-" . $log->month . "-" . $log->day; // ハイフン区切り

    $imageUrlUpper = route('image.serve', ['date' => $folder, 'filename' => $log->name_upper]);
    $imageUrlSide = route('image.serve', ['date' => $folder, 'filename' => $log->name_side]);

    \Log::debug('imageUrlUpper: ' . $imageUrlUpper);
    \Log::debug('imageUrlSide: ' . $imageUrlSide);

    $remoteURL_upper = $imageUrlUpper;
    $remoteURL_side = $imageUrlSide;

    // 保存先ディレクトリ（storage内）
    $savePath = storage_path('app/tmp/');
    if (!file_exists($savePath)) {
        mkdir($savePath, 0755, true);
    }

    $savePath_zip = $savePath . $zip_name;
    $savePath_upper = $savePath . "image_upper.png";
    $savePath_side = $savePath . "image_side.png";

    //画像取得
    $raw_image_upper = file_get_contents($remoteURL_upper);
    $raw_image_side = file_get_contents($remoteURL_side);

    //画像一時保存
    file_put_contents($savePath_upper, $raw_image_upper);
    file_put_contents($savePath_side, $raw_image_side);

    //Zipファイルを指定フォルダに作成
    Zip::create($zip_name, [$savePath_upper, $savePath_side])->saveTo($savePath);

    return response()->download($savePath_zip, basename($savePath_zip), [])->deleteFileAfterSend(true);
}


}
