@extends('layouts.base')

@section('title','検索ページ')

@section('heading','検索ページ')

@section('content1')

<table border="1">
<tr>
	<th>全部取得</th>
	<td>
	<form action="/search/all" method="POST">
	@csrf
		<input type="hidden" name="method" value="all" />
		<input type="hidden" name="q" value="all" />
		<input type="submit" value="送信" />
	</form>
	</td>
</tr>

<tr>
	<th>日付選択</th>
	<td>
	<form action="/search/date" method="POST">
	@csrf
		<input type="hidden" name="method" value="date" />
		<input type="date" name="q"/>
		<input type="submit" value="送信" />
	</form>
	</td>
</tr>

<tr>
	<th>日付範囲選択</th>
	<td>
	<form action="/search/range" method="POST">
	@csrf
		<input type="hidden" name="method" value="range" />
		<input type="date" name="q1" />
		<input type="date" name="q2" />
		<input type="submit" value="送信" />
	</form>
	</td>
</tr>

<tr>
	<th>良品・不良品選択</th>
	<td>
	<form action="/search/judgment" method="POST">
	@csrf
		<input type="hidden" name="method" value="judgment" />
		<label for="good"> 良品</label>
		<input type="radio" name="q" id="good" value="good"/>

		<label for="bad"> 不良品</label>
		<input type="radio" name="q" id="bad" value="bad"/>
		<input type="submit" value="送信" />
	</form>
</tr>
</table>
@endsection


@section('content2')
<a href='/index'>インデックスページ</a>
@endsection
