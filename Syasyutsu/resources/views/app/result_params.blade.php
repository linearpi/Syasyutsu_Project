@extends('layouts.base_result')

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

<p>{{ $params->total() }}件中
@php
    echo count($params) ."件表示</p>"
@endphp

<div class="content1 w3-display-container">
<!-- 横スクロールをつける親コンテナ -->
<div style="overflow-x: auto; width: 100%; padding: 0; margin: 0;">
    <table border="1" style="width: 100%; min-width: 900px; border-collapse: collapse; margin: 0; padding: 0;">
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
        @if(!isset($params[0]))
            <tr>
                <td colspan="9">NO DATA EXISTS!!</td>
            </tr>
        @else
            @foreach($params as $param)
                <tr>
                    <td>{{$param["id"]}}</td>
                    <td>{{$param["name"]}}</td>
                    <td>{{$param["thresh"]}}</td>
                    <td>{{$param["width"]}}</td>
                    <td>{{$param["length"]}}</td>
                    <td>{{$param["height"]}}</td>
                    <td>{{$param["created_at"]}}</td>
                    <td>
                        @if($param["active"] == null)
                            <p style="color: blue">INACTIVE</p>
                        @else
                            <p style="color: red">ACTIVE</p>
                        @endif
                    </td>
                    <td>
                        <form method="get" action="/search/paraName">
                            <input type="hidden" name="method" value="paraName" />
                            <input type="hidden" name="q" value="{{ $parameta['name'] }}" />
                            <input type="submit"  value="こ の値で検索" />
                        </form>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>
</div>

{{ $params->appends(request()->query())->links()}}

@endsection


@section('bottom-links')
<hr>
<a href='/search/parameta'>検索ページへ戻る</a>
<br>
<a href='/index'>トップページへ戻る</a>
@endsection
