<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Manga;
use App\Models\Bookmark;

class BookmarkController extends Controller
{
    // ブックマークを保存する
    public function store(Request $request) {
        // mangasテーブルからリクエストと同じmal_idの漫画を取得
        $manga = Manga::where('mal_id', $request->mal_id)->first();
        if (!$manga) {
            // もしテーブルに該当の漫画がなければ、Jikan APIで該当漫画の情報を取得
            $response = Http::get("https://api.jikan.moe/v4/manga/{$request->mal_id}");
            // オブジェクトをjsonデータに変換
            $data = $response->json()['data'];
            // $dataをもとに漫画情報をテーブルに登録
            $manga = Manga::create([
                'mal_id' => $data['mal_id'],
                'title' => $data['title'],
                'title_japanese' => $data['title_japanese'] ?? null,
                'image_url' => $data['images']['jpg']['image_url'] ?? null,
                'synopsis' => $data['synopsis'] ?? null,
                'score' => $data['score'] ?? null,
                'status' => $data['status'] ?? null,
                'chapters' => $data['chapters'] ?? null,
                'volumes' => $data['volumes'] ?? null,
                // 配列をコレクションに変換し、ジャンルの名前だけ取得
                'genres' => collect($data['genres'])->pluck('name')->implode(','),
                'authors' => collect($data['authors'])->pluck('name')->implode(','),
            ]);
        }
        // ブックマークがなければ新規作成
        Bookmark::firstOrCreate([
            // ログインユーザーのidを取得
            'user_id' => auth()->id(),
            'manga_id' => $manga->id,
            'type' => $request->type,
        ]);
        // 詳細ページにリダイレクト
        return redirect("/mangas/{$manga->mal_id}")->with('message', 'ブックマークしました！');
    }

    // ブックマークの削除
    public function destroy($id) {
        // リクエストのidと合致するidを持ち、ログインユーザーと一致するuser_idを持つブックマークを取得
        $bookmark = Bookmark::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        // 該当ブックマークを削除
        $bookmark->delete();
        // 詳細ページにリダイレクト
        return redirect("/mangas/{$bookmark->manga->mal_id}")->with('error', 'ブックマークを削除しました！');
    }
}
