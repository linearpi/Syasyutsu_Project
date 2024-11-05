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
		//テーブル内のデータを取得
		$sample_logs = Sample_log::all();

        $filename = 'sample_log-data.csv';
    
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];
    
        return response()->stream(function () use ($request) {
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
    
            // Close CSV file handle
            fclose($handle);
        }, 200, $headers);
    }	


}
