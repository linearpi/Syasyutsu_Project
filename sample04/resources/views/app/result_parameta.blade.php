@extends('layouts.base')

@section('title','パラメータ検索結果')

@section('heading','パラメータ　検索結果')


@section('head-links')
<a href='/search/parameta'>検索ページへ戻る</a>
<br>
<a href='/index'>トップページへ戻る</a>
@endsection

@section('content1')

@switch($method)
	@case("all")
		<p>検索：全期間検索</p>
	@break
	@case("paraName")
		<p>検索：パラメータ名検索</p>
		<p>内容：{{$q}}</p>
	@break
	@case("date")
		<p>検索：日付検索</p>
		<p>内容：{{$q}}</p>
	@break
	@case("judgment")
		<p>検索：ACTIVE検索</p>
		<p>内容：{{$q}}</p>
	@break
@endswitch


<p>{{ $parametas->total() }}件中
@php
	echo count($parametas) ."件表示</p>"
@endphp




<table border="1">
	<thead>
	<tr>
		<th>番号</th>
		<th>パラメータ名</th>
		<th>thresh</th>
		<th>max</th>
		<th>bs</th>
		<th>iteration</th>
		<th>作成日</th>
		<th>ACTIVE</th>
		<th>ログ検索</th>
	</tr>
	</thead>

	<tbody>
@if(!isset($parametas[0]))
	<tr>
		<td colspan="9">NO DATA EXISTS!!</td>
	</tr>

@else
@foreach($parametas as $parameta)
	<tr>
		<td>{{$parameta["id"]}}</td>
		<td>{{$parameta["name"]}}</td>
		<td>{{$parameta["thresh"]}}</td>
		<td>{{$parameta["max"]}}</td>
		<td>{{$parameta["bs"]}}</td>
		<td>{{$parameta["iteration"]}}</td>
		<td>{{$parameta["created_at"]}}</td>
		<td>
			@if($parameta["active"] == null)
				<p style="color: blue">INACTIVE</p>
			@else
				<p style="color: red">ACTIVE</p>
			@endif
		</td>
		<td>
			<form method="get" action="/search/paraName">
				<input type="hidden" name="method" value="paraName" />
				<input type="hidden" name="q" value="{{ $parameta['name'] }}" />
				<input type="submit"  value="この値で検索" />
			</form>
		</td>
	</tr>
@endforeach
@endif
	</tbody>
</table>
{{ $parametas->appends(request()->query())->links()}}
@endsection


@section('bottom-links')
<hr>
<a href='/search/parameta'>検索ページへ戻る</a>
<br>
<a href='/index'>トップページへ戻る</a>
@endsection
