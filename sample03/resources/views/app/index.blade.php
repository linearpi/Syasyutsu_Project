@extends('layouts.base')

@section('title','トップページ')

@section('heading','ようこそ')

@section('content1')
<h4>前回のログイン:</h4>
<h4>今回のログイン:</h4>
@endsection




@section('content2')
<table border='1'>
	<thead>
		<th>ページ一覧</th>
	</thead>
	<tbody>
		<tr><td><a href='/search'>検索ページ</a></td></tr>
		<tr><td><a href='/post'>投稿ページ</a></td></tr>
	</tbody>
</table>
@endsection
