{{-- CSVダウンロード --}}
<div class="download-toolbar" style="padding: 10px; text-align: right;">
    <form action="{{ route('export/csv') }}" method="get">
        @csrf
        <input type="hidden" name="method" value="{{ $method }}">
        @if($method == "range")
            <input type="hidden" name="q1" value="{{ $q1 }}">
            <input type="hidden" name="q2" value="{{ $q2 }}">
        @else
            <input type="hidden" name="q" value="{{ $q }}">
        @endif
        <input class="download-btn" type="submit" value="CSVダウンロード">
    </form>
</div>
