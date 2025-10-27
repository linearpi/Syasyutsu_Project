@extends('layouts.base_search')

@section('title','日付設定ページ')

@section('header')
<div class="head w3-display-container w3-teal">
    <div class="w3-display-right">
        <h1>グラフ生成ページ</h1>
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
    <form action="{{ url('/app/generate-graph') }}" method="POST">
    @csrf
    <table class="search-box w3-display-middle" border="1" style="border-collapse:collapse; text-align:center;">
        <tr class="search-row">
            <th class="search-headder" style="width:120px;">日付設定</th>
            <td class="search-cell">
                <div style="display:flex; gap:15px; align-items:center; flex-wrap:wrap;">
                    <label>年:
                        <input type="number" name="year" value="{{ date('Y') }}" class="search-text" style="width:90px;">
                    </label>
                    <label>月:
                        <input type="number" name="month" value="{{ date('m') }}" class="search-text" style="width:60px;">
                    </label>
                    <label>日:
                        <input type="number" name="day" value="{{ date('d') }}" class="search-text" style="width:60px;">
                    </label>
                </div>
            </td>
        </tr>

        <tr class="search-row">
            <th class="search-headder">時間設定</th>
            <td class="search-cell">
                <div style="display:flex; gap:15px; align-items:center; flex-wrap:wrap;">
                    <label>開始:
                        <input type="time" name="start_time" value="00:00" class="search-text">
                    </label>
                    <label>終了:
                        <input type="time" name="end_time" value="23:59" class="search-text">
                    </label>
                </div>
            </td>
        </tr>

        <tr>
            <td colspan="2" style="text-align:center; padding:10px;">
                <button type="submit"
                        class="search-button"
                        style="min-width:120px; padding:6px 15px; white-space:nowrap;">
                    グラフ生成
                </button>
            </td>
        </tr>
    </table>
    </form>
</div>

@if($errors->any())
    <h1>error: 条件を正しく入力してください</h1>
@endif

@endsection

@section('content2')
<a href='/index'>トップページへ戻る</a>
@endsection
