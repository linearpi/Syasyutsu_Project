@extends('layouts.base_search')

@section('title','統合検索ページ')

@section('header')
<div class="head w3-display-container w3-teal">
    <div class="w3-display-right">
        <h1>統合検索ページ</h1>
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
    <table class="search-box w3-display-middle w3-display-container" border="1">

        <!-- 成形品名検索 -->
        <tr class="search-row">
            <th class="search-headder">成形品名検索</th>
            <td class="search-cell w3-display-container">
                <form action="/search/combined/paraName" method="GET">
                    @csrf
                    <input class="search-text" type="text" name="q" value=""/>
                    <input class="w3-display-right search-button" type="submit" value="送信" />
                </form>
            </td>
        </tr>

        <!-- 全期間検索 -->
        <tr class="search-row">
            <th class="search-headder">全期間検索</th>
            <td class="search-cell w3-display-container">
                <form action="/search/combined/all" method="GET">
                    @csrf
                    <input type="hidden" name="q" value="all" />
                    <input class="w3-display-right search-button" type="submit" value="送信" />
                </form>
            </td>
        </tr>

        <!-- 日付検索 -->
        <tr class="search-row">
            <th class="search-headder">日付検索</th>
            <td class="search-cell w3-display-container">
                <form action="/search/combined/date" method="GET">
                    @csrf
                    <input type="date" name="q" />
                    <input class="w3-display-right search-button" type="submit" value="送信" />
                </form>
            </td>
        </tr>

        <!-- 期間検索 -->
        <tr class="search-row">
            <th class="search-headder">期間検索</th>
            <td class="search-cell w3-display-container">
                <form action="/search/combined/range" method="GET">
                    @csrf
                    <input type="date" name="q1" value="{{ old('q1') }}" />
                    <input type="date" name="q2" value="{{ old('q2') }}" />
                    <input class="w3-display-right search-button" type="submit" value="送信" />
                </form>
            </td>
        </tr>

        <!-- 良品・不良品検索 -->
        <tr class="search-row">
            <th class="search-headder">良品・不良品検索</th>
            <td class="search-cell w3-display-container">
                <form action="/search/combined/judgment" method="GET">
                    @csrf
                    <label for="good">良品</label>
                    <input type="radio" name="q" id="good" value="1"/>
                    <label for="bad">不良品</label>
                    <input type="radio" name="q" id="bad" value="0"/>
                    <input class="w3-display-right search-button" type="submit" value="送信" />
                </form>
            </td>
        </tr>

        <!-- ACTIVE検索 -->
        <tr class="search-row">
            <th class="search-headder">ACTIVE検索</th>
            <td class="search-cell w3-display-container">
                <form action="/search/combined/active" method="GET">
                    @csrf
                    <label for="active">ACTIVE</label>
                    <input type="radio" name="q" id="active" value="1"/>
                    <label for="inactive">INACTIVE</label>
                    <input type="radio" name="q" id="inactive" value="0"/>
                    <input class="w3-display-right search-button" type="submit" value="送信" />
                </form>
            </td>
        </tr>

    </table>
</div>

@if ($errors->any())
<div id="error-box" class="alert alert-danger" style="margin: 10px; padding: 10px; background: #fdd; color: #900;">
    <ul style="margin: 0; padding-left: 20px;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<script>
document.addEventListener("DOMContentLoaded", () => {
    const errorBox = document.getElementById("error-box");
    if (errorBox) {
        errorBox.scrollIntoView({ behavior: "smooth", block: "center" });
    }
});
</script>


@endsection

@section('content2')
<a href='/index'>インデックスページへ戻る</a>
@endsection
