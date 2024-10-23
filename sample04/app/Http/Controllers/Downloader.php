<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

}
