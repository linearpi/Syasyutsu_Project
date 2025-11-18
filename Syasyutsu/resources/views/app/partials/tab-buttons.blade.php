<div class="tab-buttons">
    <button class="tab-btn active" data-tab="all">全体結果</button>
    @if(isset($logs))
        <button class="tab-btn" data-tab="logs">ログ結果</button>
    @endif

    {{-- ★常にパラメータタブを表示 --}}
    @if(isset($params))
        <button class="tab-btn" data-tab="params">パラメータ結果</button>
    @endif
</div>
