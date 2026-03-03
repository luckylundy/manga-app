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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            // 外部制約キー(mangas→review←users)
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('manga_id')->constrained('mangas')->cascadeOnDelete();
            // 評価は1~5を想定
            $table->tinyInteger('rating');
            // 感想は任意
            $table->text('comment')->nullable();
            $table->timestamps();

            // 同じユーザーが同じ漫画に二重レビューしないようにする
            $table->unique(['user_id', 'manga_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
