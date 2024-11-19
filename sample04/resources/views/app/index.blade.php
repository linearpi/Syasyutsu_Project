@extends('layouts.base')

@section('title','トップページ')

@section('heading','ようこそ')

@section('content1')

@endsection




@section('content2')
<table border='1'>
	<thead>
		<th>ログ・画像検索</th>
		<th>パラメータ検索</th>
	</thead>
	<tbody>
		<tr>
			<td><a href='/search'>移動する</a></td>
			<td><a href='/search'>移動する</a></td>
		</tr>
	</tbody>
</table>
@endsection
