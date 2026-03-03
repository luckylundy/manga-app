<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Manga extends Model
{
    use HasFactory;

    // リレーション
    public function bookmarks() {
        return $this->hasMany(Bookmark::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    // 更新可能な属性
    protected $fillable = [
        'mal_id',
        'title',
        'title_japanese',
        'image_url',
        'synopsis',
        'score',
        'status',
        'chapters',
        'volumes',
        'genres',
        'authors',
    ];
}
