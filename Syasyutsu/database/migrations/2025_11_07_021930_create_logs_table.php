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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();

            // NULL 許容 カラム (ご要望に基づき、nullable() を適用)
            $table->string('name_upper', 255)->nullable();
            $table->string('name_side', 255)->nullable();
            $table->string('paraName', 255)->nullable();

            // NOT NULL (必須) カラム
            $table->double('width', 8, 3); // width
            $table->double('length', 8, 3); // length
            $table->double('height', 8, 3); // height

            // NULL 許容 カラム (ご要望に基づき、nullable() を適用)
            $table->unsignedTinyInteger('judgment')->nullable(); // judgment
            $table->unsignedSmallInteger('year')->nullable();
            $table->unsignedTinyInteger('month')->nullable();
            $table->unsignedTinyInteger('day')->nullable();
            $table->unsignedInteger('time')->nullable();

            // created_at と updated_at (LaravelのデフォルトはNULL許容)
            $table->timestamps();
        });
    }

    /**
     * マイグレーションを元に戻します。
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
