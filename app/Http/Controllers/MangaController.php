<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use \App\Models\Manga;
use \App\Models\Bookmark;
use \App\Models\Review;

class MangaController extends Controller
{
    // Jikan APIを利用して検索した漫画の情報を取得する
    public function search(Request $request) {
        // 空欄の場合、検索できないようにする
        if (!$request->q || trim($request->q) == "") {
            return back()->with('message', '検索キーワードを入力してください。');
        }
        // リクエストから検索文字列を取得
        $query = $request->q;
        // 最初の検索時は$pageがないので1ページ目として1を設定
        $page = $request->page ?? 1;
        // 検索文字列でJikan APIにリクエストを送る
        $response = Http::get('https://api.jikan.moe/v4/manga', [
            'q' => $query,
            'limit' => 10,
            'page' => $page,
        ]);
        // Jikan APIが正常に返ってこなかった場合
        // $responseが返ってこないか、$responseにdataがない場合
        if ($response->failed() || !isset($response->json()['data'])) {
            return back()->with('message', 'APIからデータを取得できませんでした。少し時間をおいて再度お試しください。');
        }
        // 返ってきたJSONから'data'を取り出す
        $mangas = $response->json()['data'];
        // 最終ページの番号を取得
        $lastPage = $response->json()['pagination']['last_visible_page'];
        // ビューにcompact内の文字で変数を使用できるようにして、検索結果を表示する
        return view('mangas.search', compact('mangas', 'query', 'page', 'lastPage'));
    }

    // 漫画詳細ページ
    public function show($mal_id) {
        // Jikan APIから特定の漫画の情報を取得する
        $response = Http::get("https://api.jikan.moe/v4/manga/{$mal_id}");
        // Jikan APIからのレスポンスがなかった場合
        if ($response->failed() || !isset($response->json()['data'])) {
            return back()->with('message', 'APIからデータを取得できませんでした。少し時間をおいて再度お試しください。');
        }
        // $responseから漫画のdataを取得する
        $manga = $response->json()['data'];
        // ログイン中であれば、この漫画のブックマークの状態を取得
        $favorite = null;
        $wantToRead = null;
        if (auth()->check()) {
            // この漫画の情報を取得
            $mangaModel = Manga::where('mal_id', $mal_id)->first();
            if ($mangaModel) {
                $favorite = Bookmark::where('user_id', auth()->id())
                    ->where('manga_id', $mangaModel->id)
                    ->where('type', 'favorite')
                    ->first();

                $wantToRead = Bookmark::where('user_id', auth()->id())
                    ->where('manga_id', $mangaModel->id)
                    ->where('type', 'want_to_read')
                    ->first();
            }
        }
        // レビュー格納用の空の変数を準備
        $reviews = [];
        $myReview = null;
        // このアプリのDBから取得した漫画の情報を取得
        $mangaModel = Manga::where('mal_id', $mal_id)->first();
        if ($mangaModel) {
            // この漫画の全てのレビューを取得
            $reviews = Review::where('manga_id', $mangaModel->id)
                ->with('user')
                ->latest()
                ->get();
                if (auth()->check()) {
                    // この漫画の自分のレビューを取得
                    $myReview = Review::where('user_id', auth()->id())
                        ->where('manga_id', $mangaModel->id)
                        ->first();
                }
        }
        // 詳細ページに遷移、該当ページで各変数を使えるようにする
        return view('mangas.show', compact('manga', 'favorite', 'wantToRead', 'reviews', 'myReview'));
    }
}
