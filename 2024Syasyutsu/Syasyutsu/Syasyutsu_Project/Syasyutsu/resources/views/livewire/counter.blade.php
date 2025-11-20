<div>
    <h1>{{ $count }}</h1>


@if(!isset($datas[0]))
    <h1>データを読み込んでいます。。。。</h1>
@else
    @foreach($datas as $data)
        <h1>{{ $data }}</h1>
    @endforeach
@endif

    <!-- Livewire内部で動作しているオブジェクトのメソッドを実行 -->
    <button wire:click="increment">+</button>

    <!-- Livewire内部で動作しているオブジェクトのメソッドを実行 -->
    <button wire:click="decrement">-</button>
</div>
@script
<script>
    setInterval(() => {
        //Livewire内部で動作しているオブジェクトのメソッドを1000msごとに実行
        $wire.increment()
    }, 1000)
</script>
@endscript