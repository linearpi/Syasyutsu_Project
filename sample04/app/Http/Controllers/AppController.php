<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sample_log;
use App\Models\Folder;

class AppController extends Controller
{
    //
	public function index(){
		return view('app/index');
	}
	
	public function post(Request $request)
	{
		//バリデーションチェックを行う		
		$request->validate(Sample_log::$rules);

		//画像名を決める
		date_default_timezone_set("Asia/Tokyo");
		$date	=	date("Y_m_d");
		$time	=	date("_His");
		$imageName =	$date.$time.'.'.$request->image->extension();

		//フォルダの有無を調べる
		//$folder_is_exist	=	Folder::where('name',$date)->exists();
		$folder_path 	=	'images/'.$date;
		$folder_is_exist	=	file_exists(public_path().'/'.$folder_path);
		if($folder_is_exist == false){
			mkdir(
				public_path().'/'.$folder_path,
				0777,
			);
			//$folder = new Folder;
			//$folder->name = $folder_path;
			//$folder->amount = 0; 
		}

		//画像を保存する
		$request->image->move($folder_path,$imageName);

		//リクエストから各データを取り出し、インスタンスに追加する。
		$log = new Sample_log;	
    		$log->name = $imageName;
		$log->path = $folder_path.'/'.$imageName;
    		$log->description = $request->description;
    		$log->judgment = $request->judgment;
    		$log->save();

		$datas = array(
			'isSent'	=>	true,
			'data1'		=>	$imageName,
			'data2'		=>	$folder_path.'/'.$imageName,
			'data3'		=>	$request->description,
			'data4'		=>	$request->judgment,
			'data5'		=>	$folder_is_exist,
		);


		return view('app/post',$datas);
	}

	public function search_all(Request $request)
	{

		$logs = Sample_log::all();


		$data = array(
			"method" 	=> 	$request->method,
			"q"		=>	$request->q,
			"logs"		=>	$logs,
		);

		return view('app/result',$data);
	}

	public function search_date(Request $request)
	{
		$logs = Sample_log::whereDate('created_at',$request->q)->get();


		$data = array(
			"method" 	=> 	$request->method,
			"q"		=>	$request->q,
			"logs"		=>	$logs,
		);

		return view('app/result',$data);
	}

	public function search_range(Request $request)
	{
		//期間を設定
		$old_period = $request->q1." 00:00:00";
        $new_period = $request->q2." 23:59:59";
		
		//データを検索
		$logs = Sample_log::whereBetween('created_at',[$old_period,$new_period])->get();


		//クライアントへ送信するデータをまとめる
		$data = array(
			"method" 	=> 	$request->method,
			"q"		=>	$request->q1." | ".$request->q2,
			"logs"		=>	$logs,
		);

		//クライアントへ送信する＆検索結果へリダイレクトする
		return view('app/result',$data);

	}

	public function search_judgment(Request $request)
	{
		$logs = Sample_log::where('judgment',$request->q)->get();


		$data = array(
			"method" 	=> 	$request->method,
			"q"		=>	$request->q,
			"logs"		=>	$logs,
		);

		return view('app/result',$data);
	}
	
	public function test(Request $request) 
	{
		return $request;
	}

}
