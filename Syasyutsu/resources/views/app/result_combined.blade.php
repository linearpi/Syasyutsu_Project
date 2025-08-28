@extends('layouts.base_result')

@section('title','統合検索結果ページ')

@section('headder')
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

<div class="result-msg">
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
    @case("active")
        <p>検索：ACTIVE検索</p>
        <p>内容：{{$q}}</p>
    @break
@endswitch
</div>

{{-- CSVダウンロード --}}
<div class="download-toolbar" style="padding: 10px; text-align: right;">
    <form action="{{ route('export/csv') }}" method="get">
        @csrf
        <input type="hidden" name="method" value="{{ $method }}">
        @if($method == "range")
            <input type="hidden" name="q1" value="{{ $q1 }}">
            <input type="hidden" name="q2" value="{{ $q2 }}">
        @else
            <input type="hidden" name="q" value="{{ $q }}">
        @endif
        <input class="download-btn" type="submit" value="CSVダウンロード">
    </form>
</div>

{{-- ログテーブル --}}
@if(isset($logs) && count($logs) > 0)
<div class="content1 w3-display-container">
    <div style="overflow-x: auto; width: 100%; padding: 0; margin: 0;">
        <table border="1" style="width: 100%; min-width: 1200px; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>番号</th><th>画像名(上)</th><th>画像名(横)</th><th>パラメータ名</th>
                    <th>横幅</th><th>縦幅</th><th>高さ</th><th>判定</th><th>作成日</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                    <tr>
                        <td>{{ $log["id"] }}</td>
                        <td>{{ $log["name_upper"] }}</td>
                        <td>{{ $log["name_side"] }}</td>
                        <td>{{ $log["paraName"] }}</td>
                        <td>{{ round($log["width"], 2) }}</td>
                        <td>{{ round($log["length"], 2) }}</td>
                        <td>{{ round($log["height"], 2) }}</td>
                        <td style="background-color: {{ $log["judgment"] == 1 ? 'blue' : 'red' }};">
                            {{ $log["judgment"] == 1 ? '良' : '不' }}
                        </td>
                        <td>{{ $log["created_at"] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $logs->appends(request()->query())->links() }}
</div>
@endif

{{-- パラメータテーブル --}}
@if(isset($parametas) && count($parametas) > 0)
<div class="content1 w3-display-container">
    <div style="overflow-x: auto; width: 100%; padding: 0; margin: 0;">
        <table border="1" style="width: 100%; min-width: 900px; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>番号</th><th>パラメータ名</th><th>二値化閾値</th><th>横幅</th>
                    <th>縦幅</th><th>高さ</th><th>作成日</th><th>ACTIVE</th>
                </tr>
            </thead>
            <tbody>
                @foreach($parametas as $parameta)
                <tr>
                    <td>{{ $parameta["id"] }}</td>
                    <td>{{ $parameta["name"] }}</td>
                    <td>{{ $parameta["thresh"] }}</td>
                    <td>{{ $parameta["width"] }}</td>
                    <td>{{ $parameta["length"] }}</td>
                    <td>{{ $parameta["height"] }}</td>
                    <td>{{ $parameta["created_at"] }}</td>
                    <td>{{ $parameta["active"] ? 'ACTIVE' : 'INACTIVE' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $parametas->appends(request()->query())->links() }}
</div>
@endif

@endsection

@section('bottom-links')
<hr>
<a href='/search/combined'>統合検索ページへ戻る</a>
<br>
<a href='/index'>トップページへ戻る</a>
@endsection

