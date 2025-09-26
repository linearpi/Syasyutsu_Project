<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Log;

class PLCMonitor extends Component
{
    public $countA = 0;
    public $countB = 0;
    public $countC = 0;

    public $is_connection_ok = "";

    /*成形機　データ */
    public $seikeiki_data = "";
    public $seikeiki_error = "";

    /*アームロボット　データ */
    public $arm_data = "";
    public $arm_error = "";

    /*ゲートカット　データ */
    public $gate_data = "";
    public $gate_error = "";

    /*画像処理用端末　データ */
    public $CVA_data = "";
    public $CVB_data = "";
    public $seikeihin_good = "";
    public $seikeihin_error = "";


    /*成形品データ */
    public $date_today = "";
    public $amo_today = 0;
    public $amo_good = 0;
    public $amo_bad = 0;

    public function monitoring()
    {
        // $this->count++;

        // $output = [];
		// $result = [];
		// $fixed = [];

		// exec("python3 ./python/kvhostlink.py",$output);   //PLCとの通信		
		// //exec("python3 ./python/hello2.py",$output);   //PLCとの通信		
				

		// $result = str_replace(["\\r", "\\n"], '', $output);
		// // キャリッジリターン(\r)やラインフィード(\n)を空文字に置換
		
        // //受信した文字列を返還する
		// foreach ($result as $key ) {
		// 	if($key == "b'00001'"){
		// 		$fixed[] = "ON";
		// 	}elseif ($key == "b'00000'") {
		// 		$fixed[] = "OFF";
		// 	}else{
		// 		$fixed[] = "NULL";
		// 	}
		// }

        // $this->data = $fixed[1];
    }



    public function test_monitoring(){
        $this->countA++;
        $output = [];

        exec("python3 ./python/connection_check.py",$output);   //Pythonからテストメッセージを取得

        /*接続確認*/
        $this->is_connection_ok = $output[0];

        /* 動作状況の更新 */
        $this->countB++;
        if($this->is_connection_ok != "OK"){
            $this->seikeiki_data = $output[1];
            return;
        }else if($this->is_connection_ok == "OK"){

            /*成形機　データ */
            $this->seikeiki_data = $output[1];
            $this->seikeiki_error = "test-data";

            /*アームロボット　データ */
            $this->arm_data = "test-data";
            $this->arm_error = "test-data";

            /*ゲートカット　データ */
            $this->gate_data = "test-data";
            $this->gate_error = "test-data";

            /*画像処理用端末　データ */
            $this->CVA_data = "test-data";
            $this->CVB_data = "test-data";
            $this->seikeihin_good = "test-data";
            $this->seikeihin_error = "test-data";            
        }

    /*******************************************************/
        /*今日保存したデータから成形品の良品と不良品の個数を取得 */
        //date_default_timezone_set("Asia/Tokyo");
        $year = date("Y");
        $month = date("m");
        $date = date("d");

        $query = $year."-".$month."-".$date;

        $this->amo_today = Log::whereDate("created_at",$query)->count();

        $this->amo_good = Log::whereDate("created_at",$query)->where("judgment","=","1")->count();
        $this->amo_bad = Log::whereDate("created_at",$query)->where("judgment","=","0")->count();

    /*******************************************************/

        $this->countC++;
    
    }

    public function render()
    {
        return view('livewire.p-l-c-monitor');
    }
}
