<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Manga extends Model
{
    use HasFactory;

    public function bookmarks() {
        return $this->hasMany(Bookmark::class);
    }

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
