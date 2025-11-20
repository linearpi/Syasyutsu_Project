<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('logs', function (Blueprint $table) {
        $table->id();
		$table->text("name_upper");
        $table->text("name_side");
		$table->text("paraName");
		$table->float("width");
        $table->float("length");
        $table->float("height");
		$table->boolean("judgment");
        $table->timestamp('created_at');
        $table->integer("year");
        $table->integer("month");
        $table->integer("day");
        $table->integer("time");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
