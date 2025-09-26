{{-- ログタブ --}}
@if(isset($logs))
<div id="tab-logs" class="tab-content">
    <div style="overflow-x:auto;">
        <table border="1" style="width: 100%; min-width: 1200px; border-collapse: collapse;">
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
