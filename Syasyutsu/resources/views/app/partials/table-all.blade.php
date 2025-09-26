<div id="tab-all" class="tab-content active">
    <h4 style="display:flex; align-items:center;">
        詳細比較モード
        <div class="toggle">
            <div class="toggle-button" id="detailToggle"></div>
            <span id="detailStatus">オフ</span>
        </div>
    </h4>
    <div class="scroll-area">
        @if((isset($logs) && count($logs)) || (isset($parametas) && count($parametas)))
            <table border="1" style="width:100%; min-width:900px; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>種別</th><th>番号</th><th>名称</th><th>横幅</th><th>縦幅</th><th>高さ</th><th>作成日</th>
                        <th class="detail-col">詳細1</th><th class="detail-col">詳細2</th>
                    </tr>
                </thead>
                <tbody>
                    @includeWhen(isset($logs), 'app.partials.table-all-logs')
                    @includeWhen(isset($parametas), 'app.partials.table-all-params')
                </tbody>
            </table>
        @else
            <p>該当する結果はありません。</p>
        @endif
    </div>
</div>
