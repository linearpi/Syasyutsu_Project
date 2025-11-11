<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Param;
use App\Models\Sample_log;
use App\Models\Folder;

use Illuminate\Support\Facades\DB;

class ParamController extends Controller
{

	public function search_all(Request $request){
		$params = Param::paginate(10);

		$data = array(
			"method" 	=> 	$request->method,
			"q"		=>	$request->q,
			"params"		=>	$params,
		);

		//return $data;

		return view("app/result_param",$data);
	}

	public function search_name(Request $request){
		$request->validate([
			'q' => 'required',
			'method' => 'required',
		]);


		$params = Param::orWhere('name','like','%'.$request->q.'%')
		->paginate(10);  ;

		$data = array(
			"method" 	=> 	$request->method,
			"q"		=>	$request->q,
			"params"		=>	$params,
		);

		return view('app/result_params',$data);
	}


	public function search_date(Request $request)
	{
		

		$request->validate([
			'q' => 'required',
			'method' => 'required',
		]);

		$params = Param::whereDate('created_at',$request->q)->paginate(10);


		$data = array(
			"method" 	=> 	$request->method,
			"q"		=>	$request->q,
			"params"		=>	$params,
		);

		//return $data;
		return view('app/result_param',$data);
	}

	public function search_active(Request $request){
		$request->validate([
			'q' => 'required',
			'method' => 'required',
		]);


		$params = Param::where('active',$request->q)->paginate(10);

		// if($request->q == 'active'){
		// 	$parametas = Parameta::whereNotNull('active')->paginate(10);
		// 	$parametas = Sample_log::where('judgment',$request->q)->paginate(10);
		// }else if($request->q == 'inactive'){
		// 	$parametas = Parameta::whereNull('active')->paginate(10);
		// }

		$data = array(
			"method" 	=> 	$request->method,
			"q"		=>	$request->q,
			"params"		=>	$params,
		);

		return view('app/result_param',$data);
	}

}
