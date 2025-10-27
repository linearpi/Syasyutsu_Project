{{-- パラメータタブ --}}
<div id="tab-params" class="tab-content">
    <div class="counts" data-tab="params" style="display:none;">
        <p>パラメータ：{{ $parametas->total() }}件中 {{ $parametas->count() }}件表示</p>
    </div>
    <div style="overflow-x:auto;">
        <table border="1" style="width: 100%; min-width: 900px; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>番号</th>
                    <th>パラメータ名</th>
                    <th>二値化閾値</th>
                    <th>横幅</th>
                    <th>縦幅</th>
                    <th>高さ</th>
                    <th>作成日</th>
                    <th>ACTIVE</th>
                    <th>ログ検索</th>
                </tr>
            </thead>
            <tbody>
                @forelse($parametas as $parameta)
                    <tr>
                        <td>{{ $parameta["id"] }}</td>
                        <td>{{ $parameta["name"] }}</td>
                        <td>{{ $parameta["thresh"] }}</td>
                        <td>{{ $parameta["width"] }}</td>
                        <td>{{ $parameta["length"] }}</td>
                        <td>{{ $parameta["height"] }}</td>
                        <td>{{ $parameta["created_at"] }}</td>
                        <td>{{ $parameta["active"] ? 'ACTIVE' : 'INACTIVE' }}</td>
                        <td>
                            <form method="get" action="/search/paraName">
                                <input type="hidden" name="method" value="param" />
                                <input type="hidden" name="q" value="{{ $parameta['name'] }}" />
                                <input type="submit" value="この値で検索" />
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">テーブルデータが存在しません。</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $parametas->appends(request()->query())->links() }}
</div>
