<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Manga;
use App\Models\Review;

class ReviewController extends Controller
{
    // レビュー作成
    public function store(Request $request) {
        // バリデーション
        $request->validate([
            'mal_id' => 'required|integer',
            // ratingは1~5を想定
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);
        // リクエストの漫画情報を取得
        $manga = Manga::where('mal_id', $request->mal_id)->first();
        // 該当漫画の情報がDBにない場合は新規作成する
        if (!$manga) {
            // Jikan APIから特定の漫画の情報を取得する
            $response = Http::get("https://api.jikan.moe/v4/manga/{$request->mal_id}");
            // Jikan APIからのレスポンスがなかった場合
            if ($response->failed() || !isset($response->json()['data'])) {
                return back()->with('message', 'APIからデータを取得できませんでした。少し時間をおいて再度お試しください。');
            }
            // $responseから漫画のdataを取得する
            $data = $response->json()['data'];
            // $dataをもとに該当漫画の情報を登録する
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
                // genresの配列からname属性の値だけ取得してカンマ区切りにする
                'genres' => $data['genres']->pluck('name')->implode(','),
                'authors' => $data['authors']->pluck('name')->implode(','),
            ]);
        }
        // レビューを登録する(すでにある場合は更新)
        Review::updateOrCreate(
            // 検索条件の配列
            [
                'user_id' => auth()->id(),
                'manga_id' => $manga->id,
            ],
            // 更新する値の配列
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]
        );
        return back()->with('message', 'レビューを投稿しました！');
    }

    // レビューの削除
    public function destroy($id) {
        // 該当レビューを特定
        $review = Review::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        // 該当レビューの削除
        $review->delete();
        // 直前のページに戻る
        return back()->with('message', 'レビューを削除しました！');
    }
}
