<?php

namespace App\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public $count = 1;
    public $datas = [];

    public function increment()
    {
        $this->count++;

        $output = [];
        //exec("python3 ./python/kvhostlink.py",$output);
        exec("python3 ./python/hello.py",$output);
        $this->datas = $output;
    }

    public function decrement()
    {
        $this->count--;
    }

    public function exec_python(){
        $output = exec("python3 ./python/hello.py");

    }

    public function render()
    {
        return view('livewire.counter');
    }
}
