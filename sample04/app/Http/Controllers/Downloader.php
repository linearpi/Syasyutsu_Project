<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Sample_log;

class Downloader extends Controller
{
	public function download(Request $request){
		$file_path	=	$request->path;

		$name		=	"imageimage.jpg";

		$headers	=	['Content-Type' => 'image/jpeg'];


		//return response()->download($file_path,$name,$headers);
		return response()->download($file_path,$name);
	}

	public function response(Request $request){
		$file_path	=	$request->path;

		$headers	=	['Content-Type' => 'image/jpeg'];


		return response()->file($file_path,$headers);
		//return response()->file($file_path);

	}

	public function test(Request $request)
	{
		$data = $request->all();
		return ["msg"=>"hello world","data"=>$data];
	}

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


    // public function exportIMAGE(Request $request){
    //     //$image_name = $request->name;
    //     $image_name = "image.jpg";
    //     $headers	=	['Content-Type' => 'image/jpeg'];

    //     $callback = function() use($image_name){
            
    //         $remoteURL = "http://192.168.11.13/".$image_name;  
            
    //         $image = file_get_contents($remoteURL);

    //     };


    //     return response()->stream($callback,200,$headers);
        
    // }

    public function exportIMAGE(Request $request){
        $image_name = $request->name_sample.".jpg";
        //$image_name = $request->name.".jpg";
        $headers	=	['Content-Type' => 'image/jpeg'];

        $remoteURL = "http://192.168.11.13/".$image_name;  
        $localPath = "/home/j2321310/pictures/" . $image_name;
        
        //画像取得
        $image = file_get_contents($remoteURL);

        //画像保存
        file_put_contents($localPath.$image_name,$image);

        return response()->download($localPath,$image_name);
        //return response()->file($localPath.$image_name,$headers);
        
    }

}
