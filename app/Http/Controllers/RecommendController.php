<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
        // ```jsonと```を取り除く
        $answer = preg_replace('/^```json\s*/m', '', $answer);
        $answer = preg_replace('/^```\s*$/m', '', $answer);
        $answer = trim($answer);
        // dd($answer);
        $answer = json_decode($answer, true);
        // json_decodeが失敗した場合のnullチェック
        if (!$answer) {
            return back()->with('message', 'AIからの応答を取得できませんでした。もう一度お試しください。');
        }
        return view('recommend.result', compact('question', 'answer'));
    }

    // AIへのプロンプトを組み立てる
    private function buildSystemPrompt() {
        return "あなたは漫画の専門家です。以下の回答ルールを厳守し、ユーザーの要望に合った漫画をおすすめしてください。

    回答ルール：
    - 必ず以下のJSON形式のみで出力する
    - JSONの前後に余計な文字は一切つけない
    - ```json などのマークダウン記法で囲まない  // ← 追加
    - 最初の文字は必ず { にする
    - 日本語で回答する

    出力形式：
    {
        \"intro\": \"導入文をここに\",
        \"mangas\": [
            {\"title\": \"タイトル\", \"reason\": \"おすすめ理由\"},
            {\"title\": \"タイトル\", \"reason\": \"おすすめ理由\"}
        ]
    }";
    }
}
