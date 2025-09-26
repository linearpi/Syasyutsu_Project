{{-- パラメータタブ --}}
@if(isset($parametas) && count($parametas) > 0)
<div id="tab-params" class="tab-content">
    <div style="overflow-x:auto;">
        <table border="1" style="width: 100%; min-width: 900px; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>番号</th><th>パラメータ名</th><th>二値化閾値</th><th>横 幅</th>
                    <th>縦幅</th><th>高さ</th><th>作成日</th><th>ACTIVE</th><th>ログ検索</th>
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
                        <td>
    <form method="get" action="/search/paraName">
        <input type="hidden" name="method" value="param" />
        <input type="hidden" name="q" value="{{ $parameta['name'] }}" />
        <input type="submit" value="ログを見る" />
    </form>
</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $parametas->appends(request()->query())->links() }}
</div>
@endif
