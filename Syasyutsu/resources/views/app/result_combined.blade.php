@extends('layouts.base_result')

@section('title','統合検索結果ページ')

@section('header')
    
@endsection

@section('main')
    @include('app.partials.search-summary')
    @include('app.partials.csv-download')
    @include('app.partials.tab-buttons')
    @include('app.partials.table-all')
    @includeWhen(isset($logs), 'app.partials.table-logs')
    @includeWhen(isset($parametas) && count($parametas) > 0, 'app.partials.table-params')
@include('app.partials.tab-scripts')
@endsection

@section('bottom-links')
    <hr>
    <a href="{{ url('/search/combined') }}" class="back-link">🏠 統合検索ページへ戻る</a>
    <br>
    <a href="{{ url('/index') }}" class="back-link">🏠 トップページへ戻る</a>
@endsection
