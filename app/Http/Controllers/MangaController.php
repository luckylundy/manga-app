<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MangaController extends Controller
{
    // Jikan APIを利用して検索した漫画の情報を取得する
    public function search(Request $request) {
        // リクエストから検索文字列を取得
        $query = $request->q;
        // 検索文字列でJikan APIにリクエストを送る
        $response = Http::get('https://api.jikan.moe/v4/manga', [
            'q' => $query,
            'limit' => 10,
        ]);
        // 返ってきたJSONから'data'を取り出す
        $mangas = $response->json()['data'];
        // ビューにcompact内の文字で変数を使用できるようにして、検索結果を表示する
        return view('mangas.search', compact('mangas', 'query'));
    }

    // 漫画詳細ページ
    public function show($mal_id) {
        // Jikan APIから特定の漫画の情報を取得する
        $response = Http::get("https://api.jikan.moe/v4/manga/{$mal_id}");
        // $responseから漫画のdataを取得する
        $manga = $response->json()['data'];
        // 詳細ページに遷移、該当ページで$mangaを使えるようにする
        return view('mangas.show', compact('manga'));
    }
}
