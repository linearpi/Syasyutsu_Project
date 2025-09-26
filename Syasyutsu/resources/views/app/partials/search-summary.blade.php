<div class="result-msg">
    @switch($method)
        @case("all")       <p>検索：全期間検索</p> @break
        @case("paraName")  <p>検索：パラメータ名検索</p><p>内容：{{ $q }}</p> @break
        @case("date")      <p>検索：日付検索</p><p>内容：{{ $q }}</p> @break
        @case("range")     <p>検索：期間検索</p><p>内容：{{ $q1 }} ~ {{ $q2 }}</p> @break
        @case("judgment")  <p>検索：良品・不良品検索</p><p>内容：{{ $q }}</p> @break
        @case("active")    <p>検索：ACTIVE検索</p><p>内容：{{ $q }}</p> @break
    @endswitch

    @if(isset($logs))
        <p>{{ $logs->total() }}件中 {{ count($logs) }}件表示</p>
    @endif
</div>
