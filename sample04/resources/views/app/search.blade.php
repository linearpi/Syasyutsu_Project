@extends('layouts.base_search')

@section('title','ログ　検索ページ')

@section('headder')
<div class="head w3-display-container w3-teal">
	<div class="w3-display-left">
		<h1>ログ検索ページ</h1>
	</div>
	<div class="w3-display-right">
		<a href="/" style="text-decoration:none;">
			<p class="w3-sans-serif">LOGO&emsp;</p>
		</a>
	</div>
</div>
@endsection


@section('main')

<div class="content1 w3-display-container">
	<table class="search-box w3-display-middle w3-display-container" border="1">
		<tr class="search-row">
			<th class="search-headder">全期間検索</th>
			<td class="search-cell w3-display-container"><form action="/search/all" method="GET">
			@csrf
				<input type="hidden" name="method" value="all" />
				<input type="hidden" name="q" value="all" />
				<input class="w3-display-right search-button" type="submit" value="送信" />
				
			</form></td>
		</tr>

		<tr class="search-row">
			<th class="search-headder">パラメータ名検索</th><td class="search-cell w3-display-container">
			<form action="/search/paraName" method="GET">
			@csrf
				<input type="hidden" name="method" value="paraName" />
				<input class="search-text" type="text" value="" name="q"/>
				<input class="w3-display-right search-button" type="submit" value="送信" />
			</form></td>
		</tr>

		<tr class="search-row">
			<th class="search-headder">日付検索</th><td class="search-cell w3-display-container">
			<form action="/search/date" method="GET">
			@csrf
				<input type="hidden" name="method" value="date" />
				<input type="date" value="" name="q"/>
				<input class="w3-display-right search-button" type="submit" value="送信" />
			</form></td>
		</tr>

		<tr class="search-row">
			<th class="search-headder">期間検索</th>
			<td class="search-cell w3-display-container"><form action="/search/range" method="GET">
			@csrf
				<input type="hidden" name="method" value="range" />
				<input type="date" name="q1" />
				<input type="date" name="q2" />
				<input class="w3-display-right search-button" type="submit" value="送信" />
			</form></td>
		</tr>
		<tr class="search-row">
			<th class="search-headder">良品・不良品検索</th>
			<td class="search-cell w3-display-container"><form action="/search/judgment" method="GET">
			@csrf
				<input type="hidden" name="method" value="judgment" />
				<label for="good"> 良品</label>
				<input type="radio" name="q" id="good" value="good"/>

				<label for="bad"> 不良品</label>
				<input type="radio" name="q" id="bad" value="bad"/>
				<input class="w3-display-right search-button" type="submit" value="送信" />
			</form></td>
		</tr>
	</table>
</div>
@if($errors->has('q'))
	<h1>error:条件が未定です</h1>
@endif
@if($errors->has('q1') || $errors->has('q2'))
	<h1>error:範囲が未定です</h1>
@endif

@endsection


@section('content2')
<a href='/index'>トップページへ戻る</a>
@endsection
