<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">
            {{ $manga['title_japanese'] ?? $manga['title'] }}
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto px-6 py-6">

        {{-- メッセージがあれば表示 --}}
        @if (session('message'))
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ session('message') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        {{-- 戻るリンク --}}
        <a href="javascript:history.back()"
            style="display:inline-flex;align-items:center;gap:6px;color:#6366f1;font-size:0.875rem;font-weight:500;text-decoration:none;margin-bottom:20px;">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M19 12H5M12 5l-7 7 7 7"/>
            </svg>
            戻る
        </a>

        {{-- メインカード --}}
        <div style="background:white;border-radius:16px;padding:28px;box-shadow:0 1px 3px rgba(0,0,0,0.06);border:1px solid #f3f4f6;">
            <div class="flex gap-6">

                {{-- 左側：表紙画像＋ブックマークボタン --}}
                <div style="width:180px;flex-shrink:0;">
                    <img src="{{ $manga['images']['jpg']['image_url'] }}"
                        alt="{{ $manga['title'] }}"
                        style="width:100%;border-radius:12px;box-shadow:0 4px 16px rgba(0,0,0,0.15);">

                    {{-- ブックマークボタン（ログイン時のみ表示） --}}
                    @auth
                        <div style="margin-top:16px;display:flex;flex-direction:column;gap:8px;">

                            {{-- お気に入りボタン --}}
                            @if ($favorite)
                                <form action="/bookmarks/{{ $favorite->id }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="
                                        display:flex;align-items:center;justify-content:center;gap:6px;
                                        width:100%;padding:10px;border-radius:10px;
                                        background:#fff1f2;color:#f43f5e;
                                        border:1px solid #fecdd3;
                                        font-size:0.8rem;font-weight:600;cursor:pointer;
                                        transition:all 0.2s;
                                    ">
                                        <svg width="14" height="14" fill="#f43f5e" viewBox="0 0 24 24">
                                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                        </svg>
                                        お気に入り済み
                                    </button>
                                </form>
                            @else
                                <form action="/bookmarks" method="post">
                                    @csrf
                                    <input type="hidden" name="mal_id" value="{{ $manga['mal_id'] }}">
                                    <input type="hidden" name="type" value="favorite">
                                    <button type="submit" style="
                                        display:flex;align-items:center;justify-content:center;gap:6px;
                                        width:100%;padding:10px;border-radius:10px;
                                        background:white;color:#f43f5e;
                                        border:1px solid #fecdd3;
                                        font-size:0.8rem;font-weight:600;cursor:pointer;
                                        transition:all 0.2s;
                                    ">
                                        <svg width="14" height="14" fill="none" stroke="#f43f5e" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                        </svg>
                                        お気に入り
                                    </button>
                                </form>
                            @endif

                            {{-- 読みたいボタン --}}
                            @if ($wantToRead)
                                <form action="/bookmarks/{{ $wantToRead->id }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="
                                        display:flex;align-items:center;justify-content:center;gap:6px;
                                        width:100%;padding:10px;border-radius:10px;
                                        background:#f0fdf4;color:#22c55e;
                                        border:1px solid #bbf7d0;
                                        font-size:0.8rem;font-weight:600;cursor:pointer;
                                        transition:all 0.2s;
                                    ">
                                        <svg width="14" height="14" fill="#22c55e" viewBox="0 0 24 24">
                                            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/>
                                        </svg>
                                        読みたい済み
                                    </button>
                                </form>
                            @else
                                <form action="/bookmarks" method="post">
                                    @csrf
                                    <input type="hidden" name="mal_id" value="{{ $manga['mal_id'] }}">
                                    <input type="hidden" name="type" value="want_to_read">
                                    <button type="submit" style="
                                        display:flex;align-items:center;justify-content:center;gap:6px;
                                        width:100%;padding:10px;border-radius:10px;
                                        background:white;color:#22c55e;
                                        border:1px solid #bbf7d0;
                                        font-size:0.8rem;font-weight:600;cursor:pointer;
                                        transition:all 0.2s;
                                    ">
                                        <svg width="14" height="14" fill="none" stroke="#22c55e" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/>
                                        </svg>
                                        読みたい
                                    </button>
                                </form>
                            @endif

                        </div>
                    @endauth
                </div>

                {{-- 右側：漫画情報 --}}
                <div class="flex-1">

                    {{-- タイトル --}}
                    <h2 style="font-size:1.5rem;font-weight:700;color:#1f2937;margin-bottom:4px;">
                        {{ $manga['title_japanese'] ?? $manga['title'] }}
                    </h2>
                    <p style="font-size:0.875rem;color:#9ca3af;margin-bottom:20px;">
                        {{ $manga['title'] }}
                    </p>

                    {{-- 情報グリッド --}}
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:20px;">

                        {{-- スコア --}}
                        <div style="background:#f9fafb;border-radius:10px;padding:12px;">
                            <p style="font-size:0.7rem;color:#9ca3af;margin-bottom:4px;">スコア</p>
                            <div style="display:flex;align-items:center;gap:4px;">
                                <svg width="14" height="14" fill="#f59e0b" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <p style="font-size:1rem;font-weight:700;color:#1f2937;">
                                    {{ $manga['score'] ?? '未評価' }}
                                </p>
                            </div>
                        </div>

                        {{-- 状態 --}}
                        <div style="background:#f9fafb;border-radius:10px;padding:12px;">
                            <p style="font-size:0.7rem;color:#9ca3af;margin-bottom:4px;">状態</p>
                            <p style="font-size:0.9rem;font-weight:600;color:#1f2937;">
                                {{-- 英語→日本語に変換 --}}
                                @php
                                    $statusMap = [
                                        'Finished' => '完結',
                                        'Publishing' => '連載中',
                                        'On Hiatus' => '休載中',
                                        'Discontinued' => '打ち切り',
                                        'Not yet published' => '未発売',
                                    ];
                                @endphp
                                {{ $statusMap[$manga['status']] ?? $manga['status'] ?? '不明' }}
                            </p>
                        </div>

                        {{-- 巻数 --}}
                        <div style="background:#f9fafb;border-radius:10px;padding:12px;">
                            <p style="font-size:0.7rem;color:#9ca3af;margin-bottom:4px;">巻数</p>
                            <p style="font-size:0.9rem;font-weight:600;color:#1f2937;">
                                {{ $manga['volumes'] ? $manga['volumes'].'巻' : '不明' }}
                            </p>
                        </div>

                        {{-- 著者 --}}
                        <div style="background:#f9fafb;border-radius:10px;padding:12px;">
                            <p style="font-size:0.7rem;color:#9ca3af;margin-bottom:4px;">著者</p>
                            <p style="font-size:0.9rem;font-weight:600;color:#1f2937;">
                                @foreach ($manga['authors'] as $author)
                                    {{ $author['name'] }}@if (!$loop->last)、@endif
                                @endforeach
                            </p>
                        </div>

                    </div>

                    {{-- ジャンル（タグ表示） --}}
                    @if (!empty($manga['genres']))
                        <div style="margin-bottom:20px;">
                            <p style="font-size:0.7rem;color:#9ca3af;margin-bottom:8px;">ジャンル</p>
                            <div style="display:flex;flex-wrap:wrap;gap:6px;">
                                @foreach ($manga['genres'] as $genre)
                                    <span style="background:#eef2ff;color:#6366f1;padding:4px 10px;border-radius:20px;font-size:0.75rem;font-weight:500;">
                                        {{ $genre['name'] }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- あらすじ --}}
                    <div>
                        <p style="font-size:0.7rem;color:#9ca3af;margin-bottom:8px;">あらすじ</p>
                        <p style="font-size:0.875rem;color:#4b5563;line-height:1.7;">
                            {{ $manga['synopsis'] ?? 'あらすじ情報なし' }}
                        </p>
                    </div>

                </div>
            </div>
        </div>

        {{-- レビュー投稿フォーム（ログイン時のみ） --}}
        @auth
            <div style="background:white;border-radius:16px;padding:28px;box-shadow:0 1px 3px rgba(0,0,0,0.06);border:1px solid #f3f4f6;margin-top:20px;">

                <h3 style="font-size:1rem;font-weight:700;color:#1f2937;margin-bottom:20px;">
                    {{ $myReview ? 'レビューを編集' : 'レビューを投稿' }}
                </h3>

                <form action="/reviews" method="post">
                    @csrf
                    <input type="hidden" name="mal_id" value="{{ $manga['mal_id'] }}">

                    {{-- 評価 --}}
                    <div style="margin-bottom:16px;">
                        <label style="font-size:0.875rem;font-weight:600;color:#374151;display:block;margin-bottom:8px;">評価</label>
                        <select name="rating"
                            style="border:1px solid #e5e7eb;border-radius:10px;padding:10px 14px;font-size:0.875rem;color:#374151;background:white;cursor:pointer;">
                            @for ($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}" {{ ($myReview && $myReview->rating == $i) ? 'selected' : '' }}>
                                    {{ str_repeat('★', $i) }}{{ str_repeat('☆', 5 - $i) }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    {{-- 感想 --}}
                    <div style="margin-bottom:16px;">
                        <label style="font-size:0.875rem;font-weight:600;color:#374151;display:block;margin-bottom:8px;">感想（任意）</label>
                        <textarea name="comment" rows="4"
                            style="width:100%;border:1px solid #e5e7eb;border-radius:10px;padding:12px;font-size:0.875rem;color:#374151;resize:vertical;outline:none;box-sizing:border-box;"
                            placeholder="この漫画の感想を書いてください...">{{ $myReview->comment ?? '' }}</textarea>
                    </div>

                    <button type="submit" style="
                        background:#4f46e5;color:white;
                        padding:10px 24px;border-radius:10px;
                        font-size:0.875rem;font-weight:600;
                        border:none;cursor:pointer;
                        transition:background 0.2s;
                    ">
                        {{ $myReview ? '更新する' : '投稿する' }}
                    </button>
                </form>
            </div>
        @endauth

        {{-- レビュー一覧 --}}
        <div style="background:white;border-radius:16px;padding:28px;box-shadow:0 1px 3px rgba(0,0,0,0.06);border:1px solid #f3f4f6;margin-top:20px;">

            <h3 style="font-size:1rem;font-weight:700;color:#1f2937;margin-bottom:20px;">レビュー</h3>

            @if (count($reviews) === 0)
                <div style="text-align:center;padding:24px 0;">
                    <svg width="40" height="40" fill="none" stroke="#d1d5db" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 12px;">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    <p style="color:#9ca3af;font-size:0.875rem;">まだレビューはありません</p>
                </div>
            @else
                <div style="display:flex;flex-direction:column;gap:12px;">
                    @foreach ($reviews as $review)
                        <div style="background:#f9fafb;border-radius:12px;padding:16px;">
                            <div class="flex items-start justify-between">
                                <div>
                                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
                                        <span style="color:#f59e0b;font-size:0.95rem;">
                                            {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                                        </span>
                                        <span style="font-size:0.8rem;color:#9ca3af;">{{ $review->user->name }}</span>
                                    </div>
                                    @if ($review->comment)
                                        <p style="font-size:0.875rem;color:#4b5563;">{{ $review->comment }}</p>
                                    @endif
                                </div>
                                {{-- 自分のレビューのみ削除ボタンを表示 --}}
                                @if (auth()->check() && auth()->id() === $review->user_id)
                                    <form action="/reviews/{{ $review->id }}" method="post" style="flex-shrink:0;margin-left:16px;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn" style="
                                            display:inline-flex;align-items:center;gap:4px;
                                            background:#fff5f5;color:#ef4444;
                                            border:1px solid #fecaca;
                                            border-radius:8px;padding:5px 10px;
                                            font-size:0.75rem;font-weight:500;
                                            cursor:pointer;transition:background 0.2s;
                                        ">
                                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M3 6h18M19 6l-1 14H6L5 6M10 11v6M14 11v6M9 6V4h6v2"/>
                                            </svg>
                                            削除
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

    <style>
        .delete-btn:hover { background: #fee2e2 !important; }
    </style>

</x-app-layout>