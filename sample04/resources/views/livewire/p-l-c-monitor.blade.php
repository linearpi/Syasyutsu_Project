<div>
    <h1>PLC 動作状況確認ページ</h1>
    <hr>

    <h3>ページ更新回数：{{ $count }}</h3>
    <br>

@if(!isset($datas[0]))
    <h3>データを読み込んでいます。。。。</h3>
@else
    <h2>--データ--</h2>
    @foreach($datas as $data)
        <h3> >>{{ $data }}</h3>
    @endforeach
@endif

</div>
@script
<script>
    setInterval(() => {
        //Livewire内部で動作しているオブジェクトのメソッドを1000msごとに実行
        $wire.increment()
    }, 1000)
</script>
@endscript