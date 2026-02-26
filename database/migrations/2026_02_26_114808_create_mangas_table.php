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
        Schema::create('mangas', function (Blueprint $table) {
            $table->id();
            $table->integer('mal_id')->unique();
            $table->string('title');
            $table->string('title_japanese')->nullable();
            $table->string('image_url')->nullable();
            $table->text('synopsis')->nullable();
            $table->decimal('score', 4, 2)->nullable();
            $table->string('status')->nullable();
            $table->integer('chapters')->nullable();
            $table->integer('volumes')->nullable();
            $table->string('genres')->nullable();
            $table->string('authors')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mangas');
    }
};
