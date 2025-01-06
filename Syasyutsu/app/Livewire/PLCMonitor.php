<?php

namespace App\Livewire;

use Livewire\Component;

class PLCMonitor extends Component
{
    public $count = 1;
    public $data = "";

    public function increment()
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

    public function exec_python(){
        $output = exec("python3 ./python/hello.py");
    }

    public function render()
    {
        return view('livewire.p-l-c-monitor');
    }
}
