@extends('layouts.base_top')

@section('title','トップページ')


@section('header')
<div class="head w3-display-container w3-teal">
	<div class="w3-display-right">
		<h1>トップページ</h1>
	</div>
	<div class="w3-display-left">
		<a href="/" style="text-decoration:none;">
			<p class="w3-sans-serif">LOGO&emsp;</p>
		</a>
	</div>
</div>
@endsection


@section('main')
    <!-- Main contents -->
	<div class="content1 w3-display-container">
		<div class="content1-clear">
			<div class="content1-headder">
				<div class="w3-display-middle" style="white-space:nowrap;">
					<div class="w3-center w3-padding-small w3-gray w3-xlarge w3-wide w3-animate-opacity">
						<p class="title w3-monospace">ログ表示・作業監視システム</p>
					</div>
				</div>
			</div>
		</div>    
	</div>
	<div class="content2 w3-display-container">
		<div class="w3-display-bottommiddle w3-display-container" style="width: 50%; min-width: 500px; background-color: red;">
			<button class="w3-display-bottomright w3-button w3-black" onclick="location.href='/search'" style="width: 30%; min-width: 100px;">
				<p class="btn-msg">ログ検索</p>
			</button>
			<button class="w3-display-bottomleft w3-button w3-black" onclick="location.href='/monitor'" style="width: 30%; min-width: 100px;">
				<p class="btn-msg">作業監視</p>
			</button>
			<button class="w3-display-bottommiddle w3-button w3-black" onclick="location.href='/search/parameta'" style="width: 30%; min-width: 100px;">
				<p class="btn-msg">パラメータ検索</p>
			</button>
			<button class="w3-display-bottommiddle w3-button w3-black" 
        onclick="location.href='/search/combined'" 
        style="width: 30%; min-width: 100px; left: 125%; transform: translateX(-50%);">
    <p class="btn-msg">統合横断検索</p>
</button>

		</div>
	</div>   
@endsection


@section("footer")
	<div class="content3 w3-display-container">
		<div class="w3-display-bottomright">
			<p>作成日　2024/12/4(水)&emsp;</p>
		</div>
	</div>
@endsection

@section('script')
<script>
window.addEventListener('error', (e) => {
  if (e.message.includes("Mixed Content")) {
    console.warn('Mixed Content warning suppressed:', e.message);
  }
});
</script>
@endsection
