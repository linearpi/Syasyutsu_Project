@extends('layouts.base_result')

@section('title','パラメータ　検索ページ')

@section('heading','パラメータ　検索結果')


@section('headder')
<div class="head w3-display-container w3-teal">
	<div class="w3-display-right">
		<h1>ログ検索ページ</h1>
	</div>
	<div class="w3-display-left">
		<a href="/" style="text-decoration:none;">
			<p class="w3-sans-serif">LOGO&emsp;</p>
		</a>
	</div>
</div>
@endsection

@section('main')

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



<div class="content1 w3-display-container">
	<div class="content3 w3-display-middle w3-display-container">

	<table border="1" class="w3-display-middle">
		<thead>
		<tr>
			<th>番号</th>
			<th>パラメータ名</th>
			<th>二値化閾値</th>
			<th>横幅</th>
			<th>縦幅</th>
			<th>高さ</th>
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
				<td>{{$parameta["width"]}}</td>
				<td>{{$parameta["length"]}}</td>
				<td>{{$parameta["height"]}}</td>
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

	</div>
</div>


{{ $parametas->appends(request()->query())->links()}}
@endsection


@section('bottom-links')
<hr>
<a href='/search/parameta'>検索ページへ戻る</a>
<br>
<a href='/index'>トップページへ戻る</a>
@endsection
