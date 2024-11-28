<?php

namespace App\Livewire;

use Livewire\Component;

class PLCMonitor extends Component
{
    public $count = 1;
    public $datas = [];

    public function increment()
    {
        $this->count++;

        $output = [];
        //exec("python3 ./python/kvhostlink.py",$output);   //PLCとの通信
        exec("python3 ./python/hello.py",$output);          //サンプル
        $this->datas = $output;
    }

    public function exec_python(){
        $output = exec("python3 ./python/hello.py");
    }

    public function render()
    {
        return view('livewire.p-l-c-monitor');
    }
}
