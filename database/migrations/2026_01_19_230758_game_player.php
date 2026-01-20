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
        Schema::create('game_player', function (Blueprint $table) {
            $table->id();

            $table->foreignId('player_id')
                ->constrained('players')
                ->onDelete('cascade');

            $table->foreignId('game_id')
                ->constrained('games')
                ->onDelete('cascade');

            $table->integer('skill')->default(0)->nullable();

            $table->integer('level_1_score')->default(0);
            $table->integer('level_2_score')->default(0);
            $table->integer('level_3_score')->default(0);
            $table->integer('level_4_score')->default(0);
            $table->integer('level_5_score')->default(0);
            $table->integer('level_6_score')->default(0);
            $table->integer('level_7_score')->default(0);
            $table->integer('level_8_score')->default(0);
            $table->integer('level_9_score')->default(0);
            $table->integer('level_10_score')->default(0);
            $table->integer('best_level')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
