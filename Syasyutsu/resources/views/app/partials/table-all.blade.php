<div id="tab-all" class="tab-content active">
    <div class="counts" data-tab="all" style="display:none;">
        @if(isset($logs))
            <p>ログ：{{ $logs->total() }}件中 {{ $logs->count() }}件表示</p>
        @endif
        @if(isset($params))
            <p>パラメータ：{{ $params->total() }}件中 {{ $params->count() }}件表示</p>
        @endif
    </div>

    <h4 style="display:flex; align-items:center;">
        詳細比較モード
        <div class="toggle">
            <div class="toggle-button" id="detailToggle"></div>
            <span id="detailStatus">オフ</span>
        </div>
    </h4>

    <div class="scroll-area">
        @if((isset($logs) && $logs->count()) || (isset($params) && $params->count()))
            <table border="1" style="width:100%; min-width:900px; border-collapse: collapse; table-layout: fixed;">
                <thead>
                    <tr>
                        <th>種別</th>
                        <th>番号</th>
                        <th>名称</th>
                        <th>横幅</th>
                        <th>縦幅</th>
                        <th>高さ</th>
                        <th>作成日</th>
                        <th class="detail-col">詳細1</th>
                        <th class="detail-col">詳細2</th>
                    </tr>
                </thead>
                <tbody>
                    @includeWhen(isset($logs) && $logs->count(), 'app.partials.table-all-logs')
                    @includeWhen(isset($params) && $params->count(), 'app.partials.table-all-params')
                </tbody>
            </table>
        @else
            <p>該当する結果はありません。</p>
        @endif
    </div>
</div>
