@extends('layouts.base_search')

@section('title','パラメータ　検索ページ')

@section('header')
<div class="head w3-display-container w3-teal">
	<div class="w3-display-right">
		<h1>パラメータ検索ページ</h1>
	</div>
	<div class="w3-display-left">
		<a href="/" style="text-decoration:none;">
			<p class="w3-sans-serif">LOGO&emsp;</p>
		</a>
	</div>
</div>
@endsection

@section('main')
<div class="content1 w3-display-container">

</div>
<table class="search-box w3-display-middle w3-display-container" border="1">
<tr class="search-row">
	<th class="search-headder">全期間検索</th>
	<td class="search-cell w3-display-container">
	<form action="/search/parameta/all" method="GET">
	@csrf
		<input type="hidden" name="method" value="all" />
		<input type="hidden" name="q" value="all" />
		<input class="w3-display-right search-button" type="submit" value="送信" />
	</form>
	</td>
</tr>

<tr class="search-row">
	<th class="search-headder">パラメータ名検索</th>
	<td class="search-cell w3-display-container">
	<form action="/search/parameta/name" method="GET">
	@csrf
		<input type="hidden" name="method" value="name" />
		<input class="search-text" type="text" value="" name="q"/>
		<input class="w3-display-right search-button" type="submit" value="送信" />
	</form>
	</td>
</tr>

<tr class="search-row">
	<th class="search-headder">日付検索</th>
	<td class="search-cell w3-display-container">
	<form action="/search/parameta/date" method="GET">
	@csrf
		<input type="hidden" name="method" value="date" />
		<input type="date" name="q"/>
		<input class="w3-display-right search-button" type="submit" value="送信" />
	</form>
	</td>
</tr>

<tr class="search-row">
	<th class="search-headder">ACTIVE検索</th>
	<td class="search-cell w3-display-container">
	<form action="/search/parameta/active" method="GET">
	@csrf
		<input type="hidden" name="method" value="judgement" />

		<label for="active"> ACTIVE</label>
		<input type="radio" name="q" id="active" value="1"/>
		
		<label for="inactive"> INACTIVE</label>
		<input type="radio" name="q" id="inactive" value="0"/>
		
		<input class="w3-display-right search-button" type="submit" value="送信" />
	</form>
	</td>
</tr>

</table>
@endsection


@section('content2')
<a href='/index'>インデックスページ</a>
@endsection
