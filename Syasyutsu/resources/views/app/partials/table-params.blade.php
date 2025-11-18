{{-- パラメータタブ --}}
<div id="tab-params" class="tab-content">
    <div class="counts" data-tab="params" style="display:none;">
        <p>パラメータ：{{ $params->total() }}件中 {{ $params->count() }}件表示</p>
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
                    <th>状態</th>
                    <th>ログ検索</th>
                </tr>
            </thead>
            <tbody>
                @forelse($params as $param)
                    <tr>
                        <td>{{ $param["id"] }}</td>
                        <td>{{ $param["name"] }}</td>
                        <td>{{ $param["thresh"] }}</td>
                        <td>{{ $param["width"] }}</td>
                        <td>{{ $param["length"] }}</td>
                        <td>{{ $param["height"] }}</td>
                        <td>{{ $param["created_at"] }}</td>
                        <td>{{ $param["is_active"] ? '有効' : '無効' }}</td>
                        <td>
                            <form method="get" action="/search/paraName">
                                <input type="hidden" name="method" value="param" />
                                <input type="hidden" name="q" value="{{ $param['name'] }}" />
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
    {{ $params->appends(request()->query())->links() }}
</div>
