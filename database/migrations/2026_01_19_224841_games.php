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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('room');
            $table->string('name')->unique();
            $table->boolean('cooperative')->default(false);
            $table->text('description')->nullable();
            $table->string('image')->nullable();

            $table->integer('min_players')->default(2);
            $table->integer('max_players')->default(5);
            $table->integer('optimal_players')->default(3);
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
