@extends('layouts.base')

@section('title','検索結果ページ')

@section('heading','検索結果')


@section('head-links')
<a href='/search'>検索ページへ戻る</a>
<br>
<a href='/index'>インデックスページへ戻る</a>
@endsection

@section('content1')

<p>method：{{$method}}</p>
@if($method == "range")
	<p>query：{{$q1}} ~ {{$q2}}</p>
@else
	<p>query：{{$q}}</p>
@endif


<form action="{{ route('export/csv') }}" method="get">
@csrf
	<fieldset>
	<input type="hidden" name="method" value="{{ $method }}" >
@if($method == "range")
	<input type="hidden" name="q1" value="{{ $q1 }}" >
	<input type="hidden" name="q2" value="{{ $q2 }}" >
@else
	<input type="hidden" name="q" value="{{ $q }}" >
@endif
	<label>検索結果をダウンロード
	<input type="submit" value="ダウンロード">
	</label>
	</fieldset>
</form>


<table border="1">
	<thead>
	<tr>
		<th>番号</th>
		<th>画像名</th>
		<th>パラメータ名</th>
		<th>ヨコ幅</th>
		<th>タテ幅</th>
		<th>判定</th>
		<th>作成日</th>
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
		<td>{{$log["parameta_name"]}}</td>
		<td>{{$log["width"]}}</td>
		<td>{{$log["height"]}}</td>
		<td>{{$log["judgment"]}}</td>
		<td>{{$log["created_at"]}}</td>
		<td>
			<form method="get" action="{{ route('export/image') }}">
				<input type="hidden" name="log" value="{{ $log }}" />
				<input type="submit"  value="画像ダウンロード" />
			</form>
		</td>
	</tr>
@endforeach
@endif
	</tbody>
</table>

@endsection


@section('bottom-links')
<hr>
<a href='/search'>検索ページへ戻る</a>
<br>
<a href='/index'>インデックスページへ戻る</a>
@endsection
