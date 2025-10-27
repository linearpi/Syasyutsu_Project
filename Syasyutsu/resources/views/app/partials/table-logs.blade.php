{{-- ログタブ --}}
<div id="tab-logs" class="tab-content">
    <div class="counts" data-tab="logs" style="display:none;">
        <p>ログ：{{ $logs->total() }}件中 {{ $logs->count() }}件表示</p>
    </div>

    <div style="overflow-x: auto; width: 100%; padding: 0; margin: 0;">
        <table border="1"
               style="width: 100%; min-width: 1200px; table-layout: fixed; border-collapse: collapse; margin: 0; padding: 0;">
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
                @forelse($logs as $log)
                    @include('app.partials.table-logs-row', ['log' => $log])
                @empty
                    <tr><td colspan="13">テーブルデータが存在しません。</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $logs->appends(request()->query())->links() }}

    @include('app.partials.table-logs-script')
</div>
