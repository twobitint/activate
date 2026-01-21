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

            // Keys
            $table->string('season');
            $table->integer('week');
            $table->string('opponent')->nullable();

            $table->foreignId('game_id')->nullable()
                ->constrained('games')
                ->nullOnDelete();

            $table->integer('level')->nullable();

            $table->string('opponent_location')->nullable();
            $table->boolean('is_global')->default(false);

            $table->integer('score')->default(0);
            $table->integer('opponent_score')->default(0);
            $table->string('result')->default('pending');
            $table->string('status')->default('upcoming');
            $table->string('score_type')->default('default');
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
