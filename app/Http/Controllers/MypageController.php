<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;

class MypageController extends Controller
{
    // マイページ表示
    public function index() {
        // ログインユーザーのfavoriteとそれに紐づく漫画情報も取得
        $favorites = Bookmark::where('user_id', auth()->id())
            ->where('type', 'favorite')->with('manga')->get();

        $wantToReads = Bookmark::where('user_id', auth()->id())
            ->where('type', 'want_to_read')->with('manga')->get();
        // お気に入り情報を表示
        return view('mypage.index', compact('favorites', 'wantToReads'));
    }

}
