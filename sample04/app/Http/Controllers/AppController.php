<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sample_log;
use App\Models\Folder;

use Illuminate\Support\Facades\DB;

class AppController extends Controller
{

    //
	public function index(){	
		return view('app/index');
	}
	


	public function search_all(Request $request)
	{

		//$logs = Sample_log::all();
		$logs = Sample_log::paginate(10);


		$data = array(
			"method" 	=> 	$request->method,
			"q"		=>	$request->q,
			"logs"		=>	$logs,
		);

		return view('app/result',$data);
	}

	public function search_paraName(Request $request)
	{
		$request->validate([
			'q' => 'required',
			'method' => 'required',
		]);


		$logs = Sample_log::orWhere('parameta_name','like','%'.$request->q.'%')
		->paginate(10);



		$data = array(
			"method" 	=> 	$request->method,
			"q"		=>	$request->q,
			"logs"		=>	$logs,
		);

		return view('app/result',$data);
	}

	public function search_date(Request $request)
	{
		$request->validate([
			'q' => 'required',
			'method' => 'required',
		]);

		$logs = Sample_log::whereDate('created_at',$request->q)->paginate(10);


		$data = array(
			"method" 	=> 	$request->method,
			"q"		=>	$request->q,
			"logs"		=>	$logs,
		);

		return view('app/result',$data);
	}

	public function search_range(Request $request)
	{
		$request->validate([
			'q1' => 'required',
			'q2' => 'required',
			'method' => 'required',
		]);

		//期間を設定
		$old_period = $request->q1." 00:00:00";
        $new_period = $request->q2." 23:59:59";
		
		//データを検索
		$logs = Sample_log::whereBetween('created_at',[$old_period,$new_period])->paginate(10);


		//クライアントへ送信するデータをまとめる
		$data = array(
			"method" 	=> 	$request->method,
			"q1"		=>	$request->q1,
			"q2"		=>	$request->q2,
			"logs"		=>	$logs,
		);

		//クライアントへ送信する＆検索結果へリダイレクトする
		return view('app/result',$data);

	}

	public function search_judgment(Request $request)
	{
		$request->validate([
			'q' => 'required',
			'method' => 'required',
		]);
		
		$logs = Sample_log::where('judgment',$request->q)->paginate(10);


		$data = array(
			"method" 	=> 	$request->method,
			"q"		=>	$request->q,
			"logs"		=>	$logs,
		);

		return view('app/result',$data);
	}
	
	public function test(){

	}

}
