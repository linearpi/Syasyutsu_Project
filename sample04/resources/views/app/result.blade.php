@extends('layouts.base')

@section('title','検索結果ページ')

@section('heading','検索結果')




@section('content1')

<p>method：{{$method}}</p>
<p>query：{{$q}}</p>


<form action="/test" method="post">
@csrf
	<fieldset>
	<input type="hidden" name="test" value="test-message">
	<label>検索結果をダウンロード
	<input type="submit" value="ダウンロード">
	</label>
	</fieldset>
</form>


<table border="1">
	<thead>
	<tr>
		<th>番号</th>
		<th>名前</th>
		<th>ヨコ幅</th>
		<th>タテ幅</th>
		<th>判定</th>
	</tr>
	</thead>

	<tbody>
@if(!isset($logs[0]))
	<tr>
		<td colspan="5">NO DATA EXISTS!!</td>
	</tr>

@else
@foreach($logs as $log)
	<tr>
		<td>{{$log["id"]}}</td>
		<td>{{$log["name"]}}</td>
		<td>{{$log["width"]}}</td>
		<td>{{$log["height"]}}</td>
		<td>{{$log["judgment"]}}</td>
		<td>{{$log["created_at"]}}</td>
	</tr>
@endforeach
@endif
	</tbody>
</table>

@endsection


@section('content2')
<a href='/search'>検索ページ</a>
<a href='/index'>インデックスページ</a>
@endsection
