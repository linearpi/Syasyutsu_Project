@extends('layouts.base')

@section('title','検索結果ページ')

@section('heading','検索結果')




@section('content1')

<p>method：{{$method}}</p>
<p>query：{{$q}}</p>


<table border="1">
	<thead>
	<tr>
		<th>番号</th>
		<th>名前</th>
		<th>画像</th>
		<th>判定</th>
		<th>説明</th>
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
		<td>
			<img src='{{ asset($log->path) }}' alt='{{ $log["path"] }}' width="640" height="480" />
		</td>
		<td>{{$log["judgment"]}}</td>
		<td>{{$log["description"]}}</td>
		<td>
		<form action="/response" method="post">
		@csrf
			<input type="hidden" name="path" value="{{$log->path}}" />
			<input type="submit" value="レスポンス" />
		</form>
		</td>

		<td>
		<form action="/download" method="post">
		@csrf
			<input type="hidden" name="path" value="{{$log->path}}" />
			<input type="submit" value="ダウンロード" />
		</form>
		</td>
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
