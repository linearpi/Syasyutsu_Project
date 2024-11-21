@extends('layouts.base')

@section('title','検索ページ')

@section('heading','検索ページ')


@section('errors')
	@if($errors->has('q'))
		<h3>error:条件が未定です</h3>
	@endif
	@if($errors->has('q1') || $errors->has('q2'))
		<h3>error:範囲が未定です</h3>
	@endif
@endsection

@section('content1')

<table border="1">
<tr>
	<th>全期間検索</th>
	<td>
	<form action="/search/parameta/all" method="GET">
	@csrf
		<input type="hidden" name="method" value="all" />
		<input type="hidden" name="q" value="all" />
		<input type="submit" value="送信" />
	</form>
	</td>
</tr>

<tr>
	<th>パラメータ名検索</th>
	<td>
	<form action="/search/parameta/name" method="GET">
	@csrf
		<input type="hidden" name="method" value="name" />
		<input type="text" value="" name="q"/>
		<input type="submit" value="送信" />
	</form>
	</td>
</tr>

<tr>
	<th>日付検索</th>
	<td>
	<form action="/search/parameta/date" method="POST">
	@csrf
		<input type="hidden" name="method" value="date" />
		<input type="date" value="" name="q"/>
		<input type="submit" value="送信" />
	</form>
	</td>
</tr>

</table>
@endsection


@section('content2')
<a href='/index'>インデックスページ</a>
@endsection
