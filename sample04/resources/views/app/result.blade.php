@extends('layouts.base_result')

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
	@case("range")
		<p>検索：期間検索</p>
		<p>内容：{{$q1}} ~ {{$q2}}</p>
	@break
	@case("judgment")
		<p>検索：良品・不良品検索</p>
		<p>内容：{{$q}}</p>
	@break
@endswitch

<p>{{ $logs->total() }}件中
@php
	echo count($logs) ."件表示</p>"
@endphp
	

<div class="content1 w3-display-container">
	<div class="content2 w3-display-topright">
		<form action="{{ route('export/csv') }}" method="get">
		@csrf
			<input type="hidden" name="method" value="{{ $method }}" >
		@if($method == "range")
			<input type="hidden" name="q1" value="{{ $q1 }}" >
			<input type="hidden" name="q2" value="{{ $q2 }}" >
		@else
			<input type="hidden" name="q" value="{{ $q }}" >
		@endif
			<label>検索結果をダウンロード
			<input class="download-btn" type="submit" value="CSVダウンロード">
			</label>
		</form>
	</div>
	<div class="content3 w3-display-middle w3-display-container">
		<table border="1" class="w3-display-middle">
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
					<div id='{{ $log["id"] }}_img'>
						<a href="http://192.168.11.13/pictures/{{ $log['year'] }}_{{ $log['month'] }}_{{ $log['day'] }}/{{ $log['name'] }}.png" data-lightbox="abc" data-title="{{ $log['name'] }}">
							<img src="http://192.168.11.13/pictures/{{ $log['year'] }}_{{ $log['month'] }}_{{ $log['day'] }}/{{ $log['name'] }}.png" width="60px" alt="none">
						</a>
					</div>
				</td>
				<div>
					<script>
						function chk(url){
							return new Promise(function (resolve, reject) {
								const img = new Image();
								img.src = url;
								img.onload = function () { return resolve(url) };
								img.onerror = function () { return reject(url) };
							});
						};

						chk("http://192.168.11.13/pictures/{{ $log['year'] }}_{{ $log['month'] }}_{{ $log['day'] }}/{{ $log['name'] }}.png")
							.catch((url) => {
								document.getElementById('{{ $log["id"] }}_img').innerHTML = "none";
								document.getElementById('{{ $log["id"] }}').innerHTML = "ダウンロード不可";
							});
					</script>
				</div>
				<td>
					<form method="get" action="{{ route('export/image') }}">
						<input type="hidden" name="log" value="{{ $log }}" />
						<div id='{{ $log["id"] }}'>
							<input type="submit"  value="画像ダウンロード" />
						</div>
						
					</form>
				</td>
			</tr>
		@endforeach
		@endif
			</tbody>
		</table>
		
	</div>
</div>
{{ $logs->appends(request()->query())->links()}}
@endsection


@section('bottom-links')
<hr>
<a href='/search'>検索ページへ戻る</a>
<br>
<a href='/index'>トップページへ戻る</a>
@endsection
