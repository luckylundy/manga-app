<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manga extends Model
{
    public function bookmarks() {
        return $this->hasMany(Bookmark::class);
    }
}
