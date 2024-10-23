@extends('layouts.base')

@section('title',"画像表示")

@section('heading',"画像表示")

@section('content1')
<h4>画像を表示</h4>
<p>題名：{{$title}}</p>
<img src="data:image/jpeg;base64,{{$image}}" alt="画像" width="50%" height="50%">
@endsection
