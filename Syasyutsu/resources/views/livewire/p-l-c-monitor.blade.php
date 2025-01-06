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
        <div class="base-content w3-display-container">
            <div class="w3-display-middle">
                <table border="1" class="monitor">
                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <th colspan="2">成形機</th>
                                </tr>
                                <tr>
                                    <th>状態：</th>
                                    <td>生成中</td>
                                </tr>
                            </table>
                        </td>

                        <td>
                            <table>
                                <tr>
                                    <th colspan="2">ゲートカット</th>
                                </tr>
                                <tr>
                                    <th>状態：</th>
                                    <td>カット中</td>
                                </tr>
                            </table>
                        </td>

                        <td>
                        <table>
                                <tr>
                                    <th colspan="2">寸法測定システム</th>
                                </tr>
                                <tr>
                                    <th>画像処理用端末A：</th>
                                    <td>測定中</td>
                                </tr>
                                <tr>
                                    <th>画像処理用端末B：</th>
                                    <td>待機中</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
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
            //Livewire内部で動作しているオブジェクトのメソッドを50000msごとに実行
            $wire.increment()
        }, 50000)
    </script>
    @endscript
</div>