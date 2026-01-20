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
        Schema::create('standings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('team');
            $table->integer('standing')->default(0);
            $table->integer('wins')->default(0);
            $table->integer('losses')->default(0);
            $table->integer('ties')->default(0);
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
