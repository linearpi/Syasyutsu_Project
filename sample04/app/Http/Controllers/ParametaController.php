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

	public function search_logs(Request $request){
		$request->validate([
			'q' => 'required',
			'method' => 'required',
		]);


		$logs = Sample_log::orWhere('parameta_name','like','%'.$request->q.'%')
		->get();

		$data = array(
			"method" 	=> 	$request->method,
			"q"		=>	$request->q,
			"logs"		=>	$logs,
		);

		return view('app/result',$data);
	}

}
