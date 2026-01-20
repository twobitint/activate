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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->integer('player_rank')->default(0);
            $table->integer('stars')->default(0);
            $table->integer('coins')->default(0);

            $table->integer('rank')->default(0);
            $table->integer('standing')->default(0);
            $table->integer('total_score')->default(0);
            $table->integer('yearly_rank')->default(0);
            $table->integer('yearly_score')->default(0);
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
