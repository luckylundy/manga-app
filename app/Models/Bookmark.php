<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    // テストでダミーデータを使用できるようにする
    use HasFactory;

    // User,Mangaモデルとのリレーション
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function manga() {
        return $this->belongsTo(Manga::class);
    }

    // 更新可能な属性
    protected $fillable = [
        'user_id',
        'manga_id',
        'type',
    ];
}
