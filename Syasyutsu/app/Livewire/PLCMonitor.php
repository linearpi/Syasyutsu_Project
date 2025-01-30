<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Log;

class PLCMonitor extends Component
{
    public $count = 1;

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
        $output = [];

        exec("python3 ./python/hello2.py",$output);   //Pythonからテストメッセージを取得

            /*成形機　データ */
        $this->seikeiki_data = $output[0];
        $this->seikeiki_error = $output[1];

        /*アームロボット　データ */
        $this->arm_data = $output[2];
        $this->arm_error = $output[3];

        /*ゲートカット　データ */
        $this->gate_data = $output[4];
        $this->gate_error = $output[5];

        /*画像処理用端末　データ */
        $this->CVA_data = $output[6];
        $this->CVB_data = $output[7];
        $this->seikeihin_good = $output[8];
        $this->seikeihin_error = $output[9];

/*******************************************************/
        /*今日保存したデータから成形品の良品と不良品の個数を取得 */
        date_default_timezone_set("Asia/Tokyo");
        $year = date("Y");
        $month = date("m");
        $date = date("d");

        $q = $year."_".$month."_".$date;

        $this->amo_today = Log::whereDate("created_at",$q)->count();

        $this->amo_good = Log::whereDate("created_at",$q)->where("judgment","=","1")->count();
        $this->amo_bad = Log::whereDate("created_at",$q)->where("judgment","=","0")->count();

/*******************************************************/
    
    }

    public function exec_python(){
        $output = exec("python3 ./python/hello.py");
    }

    public function render()
    {
        return view('livewire.p-l-c-monitor');
    }
}
