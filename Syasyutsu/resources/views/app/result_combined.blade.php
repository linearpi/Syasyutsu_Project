{{-- resources/views/app/result_combined.blade.php --}}
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

<style>
/* タブ切替 */
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

/* トグルスイッチ */
.toggle {
    display: flex;
    align-items: center;
    gap: 0.5em;
    margin-left: 1em;
}
.toggle-button {
    position: relative;
    width: 50px;
    height: 24px;
    background-color: #ccc;
    border-radius: 12px;
    cursor: pointer;
    transition: background-color 0.3s;
}
.toggle-button::before {
    content: '';
    position: absolute;
    top: 2px;
    left: 2px;
    width: 20px;
    height: 20px;
    background-color: white;
    border-radius: 50%;
    transition: transform 0.3s;
}
.toggle-button.active {
    background-color: #4CAF50;
}
.toggle-button.active::before {
    transform: translateX(26px);
}

/* セクション区切り線 */
.section-divider {
    border-bottom: 2px solid #ccc;
}

/* 横スクロール対応 */
.scroll-wrapper {
    overflow-x: auto;
    cursor: grab;
    margin-top: 8px;
}
.scroll-wrapper:active {
    cursor: grabbing;
}
table {
    border-collapse: collapse;
    min-width: 900px;
}
th, td {
    border: 1px solid #ccc;
    padding: 6px;
    white-space: nowrap;
}
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
    <h4 style="display:flex; align-items:center;">
        詳細比較モード
        <div class="toggle">
            <div class="toggle-button" id="detailToggle"></div>
            <span id="detailStatus">オフ</span>
        </div>
    </h4>
    <div class="scroll-wrapper">
        @if((isset($logs) && count($logs)) || (isset($parametas) && count($parametas)))
            <table>
                <thead>
                    <tr>
                        <th>種別</th><th>番号</th><th>名称</th><th>横幅</th><th>縦幅</th><th>高さ</th><th>作成日</th>
                        <th class="detail-col">詳細1</th><th class="detail-col">詳細2</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($logs))
                        @foreach($logs as $lIndex => $log)
                            <tr @if($lIndex === count($logs)-1 && count($logs) > 0) class="section-divider" @endif>
                                <td><span class="w3-tag w3-round w3-blue">📄 ログ</span></td>
                                <td>{{ $log["id"] }}</td>
                                <td>{{ $log["paraName"] }}</td>
                                <td>{{ round($log["width"], 2) }}</td>
                                <td>{{ round($log["length"], 2) }}</td>
                                <td>{{ round($log["height"], 2) }}</td>
                                <td>{{ $log["created_at"] }}</td>
                                <td class="detail-col">{{ $log["name_upper"] ?? '' }}</td>
                                <td class="detail-col">{{ $log["judgment"] == 1 ? '良' : '不' }}</td>
                            </tr>
                        @endforeach
                    @endif
                    @if(isset($parametas))
                        @foreach($parametas as $p)
                            <tr>
                                <td><span class="w3-tag w3-round w3-orange">⚙️ パラメータ</span></td>
                                <td>{{ $p["id"] }}</td>
                                <td>{{ $p["name"] }}</td>
                                <td>{{ $p["width"] }}</td>
                                <td>{{ $p["length"] }}</td>
                                <td>{{ $p["height"] }}</td>
                                <td>{{ $p["created_at"] }}</td>
                                <td class="detail-col">{{ $p["thresh"] ?? '' }}</td>
                                <td class="detail-col">{{ $p["active"] ? 'ACTIVE' : 'INACTIVE' }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        @else
            <p>該当する結果はありません。</p>
        @endif
    </div>
</div>

{{-- ログタブ --}}
@if(isset($logs))
<div id="tab-logs" class="tab-content">
    <div class="scroll-wrapper">
        <table>
            <thead>
                <tr>
                    <th>番号</th><th>画像名(上)</th><th>画像名(横)</th><th>パラ メータ名</th>
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
    <div class="scroll-wrapper">
        <table>
            <thead>
                <tr>
                    <th>番号</th><th>パラメータ名</th><th>二値化閾値</th><th>横 幅</th>
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

{{-- JS: タブ切替 & 詳細トグル & 横スクロールドラッグ --}}
<script>
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
        const target = document.getElementById('tab-' + btn.dataset.tab);
        if (target) target.classList.add('active');
    });
});

const detailToggle = document.getElementById('detailToggle');
const detailStatus = document.getElementById('detailStatus');
if (detailToggle) {
    detailToggle.addEventListener('click', () => {
        detailToggle.classList.toggle('active');
        const isActive = detailToggle.classList.contains('active');
        detailStatus.textContent = isActive ? 'オン' : 'オフ';
        document.querySelectorAll('.detail-col').forEach(col => {
            col.style.display = isActive ? '' : 'none';
        });
    });
    document.querySelectorAll('.detail-col').forEach(col => col.style.display = 'none');
}

// 横スクロール (ドラッグ操作)
document.querySelectorAll('.scroll-wrapper').forEach(wrapper => {
    let isDown = false;
    let startX, scrollLeft;
    wrapper.addEventListener('mousedown', (e) => {
        isDown = true;
        startX = e.pageX - wrapper.offsetLeft;
        scrollLeft = wrapper.scrollLeft;
    });
    wrapper.addEventListener('mouseleave', () => isDown = false);
    wrapper.addEventListener('mouseup', () => isDown = false);
    wrapper.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - wrapper.offsetLeft;
        const walk = (x - startX);
        wrapper.scrollLeft = scrollLeft - walk;
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
