{{-- resources/views/app/result_combined.blade.php --}}
@extends('layouts.base_result')

@section('title', '統合検索結果ページ')

@section('header')
<div class="head w3-display-container w3-teal">
    <div class="w3-display-right">
        <h1>統合検索結果ページ</h1>
    </div>
    <div class="w3-display-left">
        <a href="/" style="text-decoration:none;">
            <p class="w3-sans-serif">LOGO&emsp;</p>
        </a>
    </div>
</div>
@endsection

@section('main')
    @include('app.partials.search-summary')
    @include('app.partials.csv-download')
    @include('app.partials.tab-styles')
    @include('app.partials.tab-buttons')
    @include('app.partials.table-all')
    @includeWhen(isset($logs), 'app.partials.table-logs')
    @includeWhen(isset($parametas) && count($parametas) > 0, 'app.partials.table-params')
    @include('app.partials.tab-scripts')
@endsection

@section('bottom-links')
    <hr>
    <a href="{{ url('/search/combined') }}" class="back-link">🔍 検索ページへ戻る</a>
    <br>
    <a href="{{ url('/index') }}" class="back-link">🏠 トップページへ戻る</a>
@endsection
