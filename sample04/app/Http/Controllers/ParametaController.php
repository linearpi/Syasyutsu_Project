<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parameta;
use App\Models\Sample_log;
use App\Models\Folder;

use Illuminate\Support\Facades\DB;

class ParametaController extends Controller
{

	public function search_all(Request $request){
		$parameta = Parameta::all();

		$data = array(
			"method" 	=> 	$request->method,
			"q"		=>	$request->q,
			"parametas"		=>	$parameta,
		);

		return view("app/result_parameta",$data);
	}

	public function search_name(Request $request){
		$request->validate([
			'q' => 'required',
			'method' => 'required',
		]);


		$parameta = Parameta::orWhere('name','like','%'.$request->q.'%')
		->get();  ;

		$data = array(
			"method" 	=> 	$request->method,
			"q"		=>	$request->q,
			"parametas"		=>	$parameta,
		);

		return view('app/result_parameta',$data);
	}


	public function search_date(Request $request)
	{
		

		$request->validate([
			'q' => 'required',
			'method' => 'required',
		]);

		$parametas = Parameta::whereDate('created_at',$request->q)->get();


		$data = array(
			"method" 	=> 	$request->method,
			"q"		=>	$request->q,
			"parametas"		=>	$parametas,
		);

		//return $data;
		return view('app/result_parameta',$data);
	}

	public function search_active(Request $request){
		$request->validate([
			'q' => 'required',
			'method' => 'required',
		]);

		if($request->q == 'active'){
			$parametas = Parameta::whereNotNull('active')->get();
		}else if($request->q == 'inactive'){
			$parametas = Parameta::whereNull('active')->get();
		}

		$data = array(
			"method" 	=> 	$request->method,
			"q"		=>	$request->q,
			"parametas"		=>	$parametas,
		);

		return view('app/result_parameta',$data);
	}

}
