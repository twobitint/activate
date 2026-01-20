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
        Schema::create('matchups', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('game_id')
                ->constrained('games')
                ->onDelete('cascade');

            $table->string('season');
            $table->integer('week');
            $table->integer('level');

            $table->string('opponent_location')->nullable();
            $table->string('opponent')->nullable();
            $table->boolean('is_global')->default(false);
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
