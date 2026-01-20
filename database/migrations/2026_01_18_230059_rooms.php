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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name')->unique();
            $table->text('description')->nullable();

            $table->string('hero_title')->nullable();
            $table->string('display_image')->nullable();
            $table->string('illustration')->nullable();
            $table->string('icon')->nullable();
            $table->string('background')->nullable();
            $table->string('background_poster')->nullable();
            $table->string('preview')->nullable();
            $table->string('youtube_id')->nullable();
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
