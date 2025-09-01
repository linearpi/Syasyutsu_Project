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
        @case("all")       <p>検索：全期間検索</p> @break
        @case("paraName")  <p>検索：パラメータ名検索</p><p>内容：{{ $q }}</p> @break
        @case("date")      <p>検索：日付検索</p><p>内容：{{ $q }}</p> @break
        @case("range")     <p>検索：期間検索</p><p>内容：{{ $q1 }} ~ {{ $q2 }}</p> @break
        @case("judgment")  <p>検索：良品・不良品検索</p><p>内容：{{ $q }}</p> @break
        @case("active")    <p>検索：ACTIVE検索</p><p>内容：{{ $q }}</p> @break
    @endswitch

    @if(isset($logs))
        <p>{{ $logs->total() }}件中 {{ count($logs) }}件表示</p>
    @endif
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

{{-- タブ切り替え用CSS --}}
<style>
.tab-buttons {
    display: flex;
    border-bottom: 2px solid #ccc;
    margin-bottom: 10px;
}
.tab-buttons button {
    flex: 1;
    padding: 10px;
    cursor: pointer;
    background: #f1f1f1;
    border: none;
    outline: none;
    transition: background 0.3s;
}
.tab-buttons button.active {
    background: #ccc;
    font-weight: bold;
}
.tab-content { display: none; }
.tab-content.active { display: block; }
</style>

{{-- タブボタン --}}
<div class="tab-buttons">
    <button class="tab-btn active" data-tab="all">全体結果</button>
    @if(isset($logs))
        <button class="tab-btn" data-tab="logs">ログ結果</button>
    @endif
    @if(isset($parametas) && count($parametas) > 0)
        <button class="tab-btn" data-tab="params">パラメータ結果</button>
    @endif
</div>

{{-- 全体タブ --}}
<div id="tab-all" class="tab-content active">
    <h4>全体結果</h4>
    @if((isset($logs) && count($logs)) || (isset($parametas) && count($parametas)))
        <table border="1" style="width:100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>種別</th><th>番号</th><th>名称</th><th>横幅</th><th>縦幅</th><th>高さ</th><th>作成日</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($logs))
                    @foreach($logs as $log)
                        <tr>
                            <td>ログ</td>
                            <td>{{ $log["id"] }}</td>
                            <td>{{ $log["paraName"] }}</td>
                            <td>{{ round($log["width"], 2) }}</td>
                            <td>{{ round($log["length"], 2) }}</td>
                            <td>{{ round($log["height"], 2) }}</td>
                            <td>{{ $log["created_at"] }}</td>
                        </tr>
                    @endforeach
                @endif
                @if(isset($parametas))
                    @foreach($parametas as $p)
                        <tr>
                            <td>パラメータ</td>
                            <td>{{ $p["id"] }}</td>
                            <td>{{ $p["name"] }}</td>
                            <td>{{ $p["width"] }}</td>
                            <td>{{ $p["length"] }}</td>
                            <td>{{ $p["height"] }}</td>
                            <td>{{ $p["created_at"] }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    @else
        <p>該当する結果はありません。</p>
    @endif
</div>

{{-- ログタブ --}}
@if(isset($logs))
<div id="tab-logs" class="tab-content">
    <div style="overflow-x:auto;">
        <table border="1" style="width: 100%; min-width: 1200px; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>番号</th><th>画像名(上)</th><th>画像名(横)</th><th>パラメータ名</th>
                    <th>横幅</th><th>縦幅</th><th>高さ</th><th>判定</th><th>作成日</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
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
                @empty
                    <tr><td colspan="9">テーブルデータが存在しません。</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $logs->appends(request()->query())->links() }}
</div>
@endif

{{-- パラメータタブ --}}
@if(isset($parametas) && count($parametas) > 0)
<div id="tab-params" class="tab-content">
    <div style="overflow-x:auto;">
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

{{-- タブ切り替え用JS --}}
<script>
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        // ボタンのアクティブ状態をリセット
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        // コンテンツの表示切替
        document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
        const target = document.getElementById('tab-' + btn.dataset.tab);
        if (target) {
            target.classList.add('active');
        }
    });
});
</script>

@endsection

@section('bottom-links')
<hr>
<a href='/search/combined'>統合検索ページへ戻る</a>
<br>
<a href='/index'>トップページへ戻る</a>
@endsection
