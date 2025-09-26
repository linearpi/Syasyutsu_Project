<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;
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

		//$logs = Log::all();
		$logs = Log::orderBy("id","desc")->paginate(10);


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


		$logs = Log::orWhere('paraName','like','%'.$request->q.'%')
		->orderBy("id","desc")->paginate(10);



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

		$logs = Log::whereDate('created_at',$request->q)
			->orderBy("id","desc")->paginate(10);


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
		$logs = Log::whereBetween('created_at',[$old_period,$new_period])
			->orderBy("id","desc")->paginate(10);


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
		
		if($request->q === "1"){
			$parameta = 1;
		}else{
			$parameta = 0;
		}

		// ログ検索結果の番号順序(asc: 昇順 desc: 降順)
		$logs = Log::where('judgment',$parameta)
			->orderBy("id","asc")->paginate(10);


		$data = array(
			"method" 	=> 	$request->method,
			"q"		=>	$request->q,
			"logs"		=>	$logs,
		);

		return view('app/result',$data);
	}
	
    public function test(){
        date_default_timezone_set("Asia/Tokyo");
        $year = date("Y");
        $month = date("m");
        $date = date("d");

		$q = $year."_".$month."_".$date;

        $today = Log::whereDate("created_at",$q)->count();

		$good = Log::whereDate("created_at",$q)->where("judgment","=","1")->count();
		$bad = Log::whereDate("created_at",$q)->where("judgment","=","0")->count();

		return [
			"q" => $q,
			"today"=>$today,
			"good" => $good,
			"bad" => $bad,
		];
    }

}
