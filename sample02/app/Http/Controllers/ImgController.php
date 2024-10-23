<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Image;

class ImgController extends Controller
{
    //
	public function index(){
		return view("pages/index");
	}

	public function create(Request $request){
		$request->validate(Image::$rules);		//バリデーションチェック
		$image = new Image();				//インスタンスを作成
		$image_file = file_get_contents($request->file('image')->getPathname());	//画像を取得
		$image_title = $request->title;

		$image->picture = $image_file;
		$image->title = $image_title;
		$image->save();

		return redirect('/img_index');
	}

	public function store(Request $request) {
		$image = $request->file('image'); // 画像ファイルを取得
		$imageData = file_get_contents($image->getPathname()); // 画像データを取得
		$base64Image = base64_encode($imageData); // Base64エンコード

		$html =<<<EOF
		<img src="data:image/jpeg;base64,{$base64Image}" alt="画像" style="width: 60%; height: 45%;">
		EOF;

		return $html;
	}


	public function show(Request $request){
		$image = Image::select("picture")->latest()->first();	//DBからバイナリデータを取得する
		$title = Image::select("title")->latest()->first();	//DBからタイトルを取得する
		$imageData = base64_encode($image->picture);	//base64形式に変換する
	
		$params = [
			"image" => $imageData,
			"title" => $title->title
		];
	
		return view('pages/show_img',$params);
	}

}
