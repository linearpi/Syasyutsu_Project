<h1>PNG 圧縮比較</h1>

<h2>10段階の事前圧縮画像</h2>
@foreach($precompressed as $rate => $url)
    <div style="margin:10px 0;">
        <strong>compression_level: {{ $rate }}</strong><br>
        <img src="{{ $url }}" style="max-width:300px;">
    </div>
@endforeach

<hr>

<h2>カスタム圧縮（0?9）</h2>
<form method="POST" action="/compare/custom">
    @csrf
    <label for="compression">圧縮レベル (0?9):</label>
    <input type="number" name="compression" id="compression" min="0" max="9" value="6">
    <button type="submit">圧縮する</button>
</form>

@if($custom)
    <h3>{{ $custom['rate'] }} のレベルで圧縮した PNG</h3>
    <img src="{{ $custom['url'] }}" style="max-width:300px;">
@endif
