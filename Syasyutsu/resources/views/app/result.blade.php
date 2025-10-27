@extends('layouts.base_result')

@section('title','ログ　検索結果ページ')

@section('header')
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
                    <th class="image-dl">画像DL</th>
                </tr>
            </thead>
            <tbody>
                @if(!isset($logs[0]))
                    <tr><td colspan="13">NO DATA EXISTS!!</td></tr>
                @else
@foreach($logs as $log)
@php
    // created_at -> date/time からベース文字列を作る
    $dt = isset($log['created_at']) ? explode(' ', $log['created_at']) : [null, null];
    $datePart = $dt[0] ?? '';
    $timePart = $dt[1] ?? '';

    // YYYY-MM-DD を分解してゼロなしに
    $year = (int)substr($datePart, 0, 4);
    $month = (int)substr($datePart, 5, 2);
    $day = (int)substr($datePart, 8, 2);
    $datePath = "{$year}-{$month}-{$day}";  // ← ゼロを削除したルート用文字列

    // created_at を "_" 区切りに変換（画像名補完用）
    $dateStr = sprintf("%04d_%02d_%02d_%s",
        $year, $month, $day,
        str_replace(':', '', $timePart)
    );

    // 表示用の名前
    $displayParaName  = !empty($log['paraName']) ? $log['paraName'] : $dateStr;
    $displayNameUpper = !empty($log['name_upper']) ? $log['name_upper'] : ($dateStr ? $dateStr . '_a' : null);
    $displayNameSide  = !empty($log['name_side'])  ? $log['name_side']  : ($dateStr ? $dateStr . '_b' : null);

    // 画像URLを生成
    $imageUrlUpper = ($displayNameUpper && $datePath)
        ? route('image.serve', ['date' => $datePath, 'filename' => $displayNameUpper])
        : null;

    $imageUrlSide = ($displayNameSide && $datePath)
        ? route('image.serve', ['date' => $datePath, 'filename' => $displayNameSide])
        : null;
@endphp

    <tr>
        <td>{{ $log['id'] }}</td>

        <td>{!! $displayNameUpper ? str_replace('_','_<wbr>', e($displayNameUpper)) : '&nbsp;' !!}</td>
        <td>{!! $displayNameSide ? str_replace('_','_<wbr>', e($displayNameSide)) : '&nbsp;' !!}</td>
        <td>{!! $displayParaName ? str_replace('_','_<wbr>', e($displayParaName)) : '&nbsp;' !!}</td>

        <td>
            @if($displayParaName)
                <form action="/search/parameta/name" method="GET">
                    @csrf
                    <input type="hidden" name="q" value="{{ $displayParaName }}">
                    <input type="hidden" name="method" value="name" />
                    <input type="submit" value="この値で検索">
                </form>
            @else
                <span style="color: gray;">—</span>
            @endif
        </td>

        <td>{{ isset($log['width']) ? round($log['width'],2) : '' }}</td>
        <td>{{ isset($log['length']) ? round($log['length'],2) : '' }}</td>
        <td>{{ isset($log['height']) ? round($log['height'],2) : '' }}</td>

        <td style="background-color: {{ $log['judgment'] == 1 ? 'blue' : 'red' }};">
            {{ $log['judgment'] == 1 ? '良' : '不' }}
        </td>

        <td>{{ $log['created_at'] ?? '' }}</td>

        <td id="cell_upper_{{ $log['id'] }}">
            @if($imageUrlUpper)
                <a href="{{ $imageUrlUpper }}" data-lightbox="abc" data-title="{{ $displayNameUpper }}">
                    <img id="img_upper_{{ $log['id'] }}" src="{{ $imageUrlUpper }}" width="60px" alt="upper">
                </a>
            @else
                <span style="color: gray;">なし</span>
            @endif
        </td>

        <td id="cell_side_{{ $log['id'] }}">
            @if($imageUrlSide)
                <a href="{{ $imageUrlSide }}" data-lightbox="abc" data-title="{{ $displayNameSide }}">
                    <img id="img_side_{{ $log['id'] }}" src="{{ $imageUrlSide }}" width="60px" alt="side">
                </a>
            @else
                <span style="color: gray;">なし</span>
            @endif
        </td>

        <td class="image-dl">
            <form method="get" action="{{ route('export/image') }}">
                <input type="hidden" name="log_id" value="{{ $log['id'] }}" />
                <div style="max-width: 145px;">
                    <input type="submit" value="画像ダウンロード" style="width: 100%; padding: 5px;">
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
{{-- チェック用スクリプト --}}
<script>
    function chk(url, onError) {
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
        }).catch(onError);
    }
</script>

@foreach($logs as $log)
<script>
    chk("{{ $imageUrlUpper }}", () => {
        const el = document.getElementById('img_upper_{{ $log->id }}');
        if (el) {
            el.src = "/image/no_image.png";
        }
    });

    chk("{{ $imageUrlSide }}", () => {
        const el = document.getElementById('img_side_{{ $log->id }}');
        if (el) {
            el.src = "/image/no_image.png";
        }
    });
</script>
@endforeach

{{ $logs->appends(request()->query())->links()}}

@endsection


@section('bottom-links')
<hr>
<a href='/search'>検索ページへ戻る</a>
<br>
<a href='/index'>トップページへ戻る</a>
@endsection
