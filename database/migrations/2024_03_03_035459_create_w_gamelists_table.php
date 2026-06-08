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
        Schema::create('w_gamelists', function (Blueprint $table) {
            $table->id();
            $table->string('provider')->nullable();
            $table->string('game_name')->nullable();
            $table->string('game_code')->nullable();
            $table->integer('status')->length(11)->nullable();
            $table->integer('free_rounds_status')->length(11)->nullable();
            $table->integer('desktop')->length(11)->nullable();
            $table->integer('mobile')->length(11)->nullable();
            $table->string('images')->length(11)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('w_gamelists');
    }
};
