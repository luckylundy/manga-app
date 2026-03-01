<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function manga() {
        return $this->belongsTo(Manga::class);
    }

    protected $fillable = [
        'user_id',
        'manga_id',
        'type',
    ];
}
