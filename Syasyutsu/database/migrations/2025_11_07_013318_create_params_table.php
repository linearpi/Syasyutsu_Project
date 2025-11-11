<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * マイグレーションを実行します。
     */
    public function up(): void
    {
        Schema::create('params', function (Blueprint $table) {
            $table->id();

            // パラメータ名。一意な識別子として設定
            $table->string('name')->unique(); 

            // 二値化閾値 (0-255の整数)
            $table->unsignedSmallInteger('thresh');

            // 寸法データ（小数点以下3桁まで想定）
            $table->double('width', 8, 3);
            $table->double('length', 8, 3);
            $table->double('height', 8, 3);

            // ACTIVE/INACTIVE 判定。boolean型を使用し、デフォルトはACTIVE(true)
            $table->boolean('is_active')->default(true); 
            
            // 作成日と更新日
            $table->timestamps(); 
        });
    }

    /**
     * マイグレーションを元に戻します。
     */
    public function down(): void
    {
        Schema::dropIfExists('params');
    }
};
