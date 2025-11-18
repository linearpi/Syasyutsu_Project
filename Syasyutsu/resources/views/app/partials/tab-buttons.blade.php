<div class="tab-buttons">
    <button class="tab-btn active" data-tab="all">全体結果</button>
    @if(isset($logs))
        <button class="tab-btn" data-tab="logs">ログ結果</button>
    @endif
    @if(isset($params) && count($params) > 0)
        <button class="tab-btn" data-tab="params">パラメータ結果</button>
    @endif
</div>
