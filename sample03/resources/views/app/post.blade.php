@extends('layouts.base')

@section('title','投稿ページ')

@section('heading','投稿ページ')

@section('errors')

@foreach($errors->all() as $error)
	<li>{{$error}}</li>
@endforeach

@endsection

@section('content1')
<form action="post" method="POST" enctype="multipart/form-data">
@csrf
<table border="1">

	<tr><th><label for="description">画像(jpg形式)</label></th>
	<td><input type="file" id="image" name="image" /></td></tr>

	<tr><th><label for="description">ログに関する説明</label></th>
	<td><textarea id="description" name="description" rows="5" cols="30" style="resize:none;" ></textarea></td></tr>

	<tr><th>判定結果</th>
	<td><label>良品<input type="radio" name="judgment" value="good" /></label>
	<label>不良品<input type="radio" name="judgment" value="bad" /></label></td>




	<tr><th></th><td><input type="submit" value="送信" /></td></tr>
</table>
</form>


@isset($isSent)
<p>送信済み</p>
<p>{{$data1}}</p>
<p>{{$data2}}</p>
<p>{{$data3}}</p>
<p>{{$data4}}</p>
<p>{{$data5}}</p>
@endisset
@endsection


@section('content2')
<a href='/index'>インデックスページ</a>
@endsection
