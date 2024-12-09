<div class="root">

    <div class="headder">
        <div class="head w3-display-container w3-teal">
            <div class="w3-display-left">
                <h1>PLC 動作状況確認ページ</h1>
            </div>
            <div class="w3-display-right">
                    <a href="/" style="text-decoration:none;">
                        <p class="w3-sans-serif">LOGO&emsp;</p>
                    </a>
            </div>
        </div>
    </div>

    <div class="main">

            <h2>--データ--</h2>


        @if($data == "ON") 
            <div class="content1" style="background-image: url('../images/app/ON.jpg');">
            </div>
        @else
            <div class="content1" style="background-image: url('../images/app/OFF.jpg');">

            </div>
        @endif
    </div>

    <div class="footer">
        <div class="content2 w3-display-container">
            <div class="w3-display-bottomright">
                <p>作成日　2024/12/4(水)&emsp;</p>
            </div>
        </div>
    </div>


    @script
    <script>
        setInterval(() => {
            //Livewire内部で動作しているオブジェクトのメソッドを1000msごとに実行
            $wire.increment()
        }, 500)
    </script>
    @endscript
</div>