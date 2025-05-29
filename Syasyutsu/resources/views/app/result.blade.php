@extends('layouts.base_result')

@section('title','ログ　検索結果ページ')

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
@endswitch

        <p>{{ $logs->total() }}件中
        @php
                echo count($logs) ."件表示</p>"
        @endphp
</div>

<div class="content1">

    {{-- ダウンロードフォーム --}}
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
            <label class="downlaod-label">検索結果をダウンロード
                <input class="download-btn" type="submit" value="CSVダウンロード">
            </label>
        </form>
    </div>

    {{-- テーブル表示 --}}
<div class="content1 w3-display-container">

    <!-- 横スクロールをつける親コンテナ -->
    <div style="overflow-x: auto; width: 100%; padding: 0; margin: 0;">

        <!-- テーブル -->
	<table border="1"
        	style="
        	width: 100%;
         	min-width: 1200px;
         	table-layout: fixed;
         	border-collapse: collapse;
         	margin: 0;
         	padding: 0;
       ">

            <thead>
                <tr>
                    <th>番号</th>
                    <th>画像名(上)</th>
                    <th>画像名(横)</th>
                    <th>パラメータ名</th>
                    <th>パラメータ検索</th>
                    <th>横幅</th>
                    <th>縦幅</th>
                    <th>高さ</th>
                    <th>判定</th>
                    <th>作成日</th>
                    <th>上部の画像</th>
                    <th>横側の画像</th>
                    <th>画像DL</th>
                </tr>
            </thead>
            <tbody>
                @if(!isset($logs[0]))
                    <tr><td colspan="13">NO DATA EXISTS!!</td></tr>
                @else
                    @foreach($logs as $log)
                    <tr>
                        <td>{{ $log["id"] }}</td>

                        <td>{!! str_replace('_', '_<wbr>', e($log["name_upper"])) !!}</td>
                        <td>{!! str_replace('_', '_<wbr>', e($log["name_side"])) !!}</td>
                        <td>{!! str_replace('_', '_<wbr>', e($log["paraName"])) !!}</td>
                        <td>
                            <form action="/search/parameta/name" method="GET">
                                @csrf
                                <input type="hidden" name="q" value="{{ $log['paraName'] }}">
                                <input type="hidden" name="method" value="name" />
                                <input type="submit" value="この値で検索">
                            </form>
                        </td>
                        <td>{{ $log["width"] }}</td>
                        <td>{{ $log["length"] }}</td>
                        <td>{{ $log["height"] }}</td>
                        <td style="background-color: {{ $log["judgment"] == 1 ? 'blue' : 'red' }};">
                            {{ $log["judgment"] == 1 ? '良' : '不' }}
                        </td>

<td>{{ $log["created_at"] }}</td> {{-- ここ追加！ --}}

@php
    $dateStr = $log["year"] . '_' . $log["month"] . '_' . $log["day"] . '_' . $log["time"];
    $escaped = e($dateStr);
    $withWbr = str_replace('_', '_<wbr>', $escaped);
    // NASルーティング用
    // 日付は1桁月日でハイフン区切り（ルーティングのdateパラメタ）
    $datePath = $log['year'].'-'.$log['month'].'-'.$log['day'];
    $imageUrlUpper = route('image.serve', ['date' => $datePath, 'filename' => $log['name_upper']]);
    $imageUrlSide = route('image.serve', ['date' => $datePath, 'filename' => $log['name_side']]);
@endphp

<td>
    <div id="{{ $log["id"] }}_img_upper">
        <a href="{{ $imageUrlUpper }}" data-lightbox="abc" data-title="{{ $log['name'] }}">
            <img src="{{ $imageUrlUpper }}" width="60px" alt="none">
        </a>
    </div>
</td>
<td>
    <div id="{{ $log["id"] }}_img_side">
        <a href="{{ $imageUrlSide }}" data-lightbox="abc" data-title="{{ $log['name'] }}">
            <img src="{{ $imageUrlSide }}" width="60px" alt="none">
        </a>
    </div>
</td>
                        <td>
                            <form method="get" action="{{ route('export/image') }}">
                                <input type="hidden" name="log" value="{{ $log }}" />
                                <div id="{{ $log["id"] }}">
                                    <input type="submit" value="画像ダウンロード" />
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


{{-- チェック用スクリプト：tableの外にまとめる --}}
<script>
    function chk(url) {
        return new Promise((resolve, reject) => {
            const img = new Image();
            const timer = setTimeout(() => reject(new Error("Timeout")), 1000);
            img.onload = () => {
                clearTimeout(timer);
                resolve(url);
            };
            img.onerror = () => {
                clearTimeout(timer);
                reject(url);
            };
            img.src = url;
        });
    }

    @foreach($logs as $log)
        chk("{{ $imageUrlUpper }}")
            .catch(() => {
                document.getElementById('{{ $log["id"] }}_img_upper').innerHTML = "none";
                document.getElementById('{{ $log["id"] }}').innerHTML = "ダウン ロード不可";
            });

        chk("{{ $imageUrlSide }}")
            .catch(() => {
                document.getElementById('{{ $log["id"] }}_img_side').innerHTML = "none";
                document.getElementById('{{ $log["id"] }}').innerHTML = "ダウン ロード不可";
            });
    @endforeach
</script>

{{ $logs->appends(request()->query())->links()}}

@endsection


@section('bottom-links')
<hr>
<a href='/search'>検索ページへ戻る</a>
<br>
<a href='/index'>トップページへ戻る</a>
@endsection
