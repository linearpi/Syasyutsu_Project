<div class="root">

    <div class="headder">
        <div class="head w3-display-container w3-teal">
            <div class="w3-display-left">
                <h1>PLC 動作状況確認ページ</h1>
            </div>
            <div class="w3-display-right">
                    <a href="/" style="text-decoration:none;">
                        <p class="w3-sans-serif">LOGO</p>
                    </a>
            </div>
        </div>
    </div>

    <div class="main">
        <div class="base-content w3-display-container">
            <div class="w3-display-middle">
                <table border="1" class="base-table">
                    <tr>
                        <th class="base-table-headder">成形機</th>
                        <th class="base-table-headder">アームロボット</th>
                        <th class="base-table-headder">ゲートカット装置</th>
                        <th class="base-table-headder">寸法測定システム</th>
                    </tr>
                    <tr>
                        <td class="base-table-data">
                            <table border="1" class="monitor-table">
                                <tr class="monitor-table-row">
                                    <th class="monitor-table-headder">状態</th>
                                    <td class="monitor-table-data">{{ $seikeiki_data }}</td>
                                </tr>
                                <tr class="monitor-table-row">
                                    <th class="monitor-table-headder">エラー数</th>
                                    <td class="monitor-table-data">{{ $seikeiki_error }}</td>
                                </tr>
                            </table>
                        </td>
                        <td class="base-table-data">
                            <table border="1" class="monitor-table">
                                <tr class="monitor-table-row">
                                    <th class="monitor-table-headder">状態</th>
                                    <td class="monitor-table-data">{{ $arm_data }}</td>
                                </tr>
                                <tr class="monitor-table-row">
                                    <th class="monitor-table-headder">エラー数</th>
                                    <td class="monitor-table-data">{{ $arm_error }}</td>
                                </tr>
                            </table>
                        </td>
                        <td class="base-table-data">
                            <table border="1" class="monitor-table">
                                <tr class="monitor-table-row">
                                    <th class="monitor-table-headder">状態</th>
                                    <td class="monitor-table-data">{{ $gate_data }}</td>
                                </tr>
                                <tr class="monitor-table-row">
                                    <th class="monitor-table-headder">エラー数</th>
                                    <td class="monitor-table-data">{{ $gate_error }}</td>
                                </tr>
                            </table>
                        </td>
                        <td class="base-table-data">
                            <table border="1" class="monitor-table">
                                <tr class="monitor-table-row">
                                    <th class="monitor-table-headder">画像処理用端末A</th>
                                    <td class="monitor-table-data">{{ $CVA_data }}</td>
                                </tr>
                                <tr class="monitor-table-row">
                                    <th class="monitor-table-headder">画像処理用端末B</th>
                                    <td class="monitor-table-data">{{ $CVB_data }}</td>
                                </tr>
                                <tr class="monitor-table-row">
                                    <th class="monitor-table-headder">良品数</th>
                                    <td class="monitor-table-data">{{ $amo_good }}</td>
                                </tr>
                                <tr class="monitor-table-row">
                                    <th class="monitor-table-headder">不良数</th>
                                    <td class="monitor-table-data">{{ $amo_bad }}</td>
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
                <p>作成日　2025/2/3(月)</p>
            </div>
        </div>
    </div>


    @script
    <script>
        setInterval(() => {
            //Livewire内部で動作しているオブジェクトのメソッドを500msごとに実行
            $wire.test_monitoring()
        }, 500)
    </script>
    @endscript
</div>