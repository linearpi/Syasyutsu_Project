<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LogsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('logs')->insert([
            'name_upper' => 'image_upper_001.jpg',
            'name_side' => 'image_side_001.jpg',
            'paraName' => 'temperature',
            'width' => 12.34,
            'length' => 56.78,
            'height' => 90.12,
            'judgment' => 1,
            'year' => '2025',
            'month' => '07',
            'day' => '27',
            'time' => '12-34-56',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
