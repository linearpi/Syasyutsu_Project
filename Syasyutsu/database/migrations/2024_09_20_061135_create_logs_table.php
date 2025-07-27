<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id(); // 番号

            $table->string('name_upper'); // 画像名(上)
            $table->string('name_side');  // 画像名(横)

            $table->string('paraName');   // パラメータ名

            $table->float('width', 8, 2);   // 横幅（小数第2位まで）
            $table->float('length', 8, 2);  // 縦幅
            $table->float('height', 8, 2);  // 高さ

            $table->boolean('judgment');   // 判定（1:良品, 0:不良品）

//            $table->timestamp('created_at')->nullable(); // 作成日

            // 画像ルーティング用の補助情報
            $table->string('year');
            $table->string('month');
            $table->string('day');
            $table->string('time');

            $table->timestamps(); // Laravel標準の created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
