<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class RecommendController extends Controller
{
    // 質問画面表示
    public function index() {
        return view('recommend.index');
    }

    // AIからの回答を取得する
    public function ask(Request $request) {
        // 質問が空の場合、前の画面に戻る
        if (!$request->question || trim($request->question) === '') {
            return back()->with('message', '質問を入力してください。');
        }
        // 質問を変数に代入
        $question = $request->question;
        // Claude APIにリクエストを送る
        $response = Http::withHeaders([
            'x-api-key' => env('ANTHROPIC_API_KEY'),
            // APIのバージョンを指定
            'anthropic-version' => '2023-06-01',
            'content-type' => 'application/json'
        ])->post('https://api.anthropic.com/v1/messages', [
            'model' => 'claude-haiku-4-5-20251001',
            // 500~700文字程度の回答を想定
            'max_tokens' => 1024,
            'system' => $this->buildSystemPrompt(),
            'messages' => [
                [
                    'role' => 'user',
                    // 自作のプロンプトに沿った内容を回答してもらう
                    'content' => $question,
                ],
            ],
        ]);
        // APIエラー対策
        if ($response->failed()) {
            return back()->with('message', 'AIからの応答を取得できませんでした。もう一度お試しください。');
        }
        // text内にAIの回答が格納されているので取得して$answerに格納
        $answer = $response->json()['content'][0]['text'];
        // 不要な記号を除去
        $answer = str_replace(['{', '}', '"""'], '', $answer);
        // エスケープ・改行処理
        $answer = nl2br(e($answer));
        return view('recommend.result', compact('question', 'answer'));
    }

    // AIへのプロンプトを組み立てる
    private function buildSystemPrompt() {
        return "あなたは漫画の専門家です。以下の回答ルールを厳守し、ユーザーの要望に合った漫画をおすすめしてください。

        回答ルール：
        - プレーンテキストのみで出力する
        - 絶対に回答を引用符、クォーテーション、波括弧、バッククォート、トリプルクォートなどで囲まない
        - Markdownの記法は一切使わない
        - 回答の最初の1文字は必ず日本語のひらがな・カタカナ・漢字で始める
        - 3〜5作品をおすすめする
        - 各作品について、タイトルとおすすめ理由を簡潔に説明する
        - 日本語で回答する";
    }
}
