<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-bold text-gray-800">マイページ</h2>
            <p class="text-xs text-gray-400 mt-1">お気に入りや読みたいリスト、自分のレビューを管理できます</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-6 py-8">

        {{-- メッセージがあれば表示 --}}
        @if (session('message'))
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
                {{ session('message') }}
            </div>
        @endif

        {{-- ▼ お気に入りセクション --}}
        <div class="mb-10">

            {{-- セクション見出し --}}
            <div class="flex items-center gap-3 mb-5">
                <div style="width:36px;height:36px;background:#fff1f2;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                    <svg width="18" height="18" fill="none" stroke="#f43f5e" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-800">お気に入り</h2>
                    <p class="text-xs text-gray-400">{{ $favorites->count() }}冊</p>
                </div>
            </div>

            {{-- お気に入りが空の場合 --}}
            @if ($favorites->isEmpty())
                <div style="background:white;border-radius:16px;padding:32px;text-align:center;border:1px solid #f3f4f6;">
                    <svg width="40" height="40" fill="none" stroke="#d1d5db" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 12px;">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                    </svg>
                    <p class="text-gray-400 text-sm">お気に入りはまだありません</p>
                </div>
            @else
                {{-- カードグリッド --}}
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    @foreach ($favorites as $bookmark)
                        <div class="manga-card bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100">
                            <a href="/mangas/{{ $bookmark->manga->mal_id }}" style="text-decoration:none;">
                                <div class="overflow-hidden" style="height:200px;">
                                    <img src="{{ $bookmark->manga->image_url }}"
                                        alt="{{ $bookmark->manga->title }}"
                                        class="w-full h-full object-cover">
                                </div>
                                <div class="px-3 pt-3">
                                    <p class="font-bold text-sm text-gray-800 leading-tight">
                                        {{ $bookmark->manga->title_japanese ?? $bookmark->manga->title }}
                                    </p>
                                </div>
                            </a>
                            {{-- 削除ボタン --}}
                            <div class="px-3 pb-3 mt-2">
                                <form action="/bookmarks/{{ $bookmark->id }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn"
                                        style="
                                            display:inline-flex;align-items:center;gap:4px;
                                            background:#fff5f5;color:#ef4444;
                                            border:1px solid #fecaca;
                                            border-radius:8px;padding:5px 10px;
                                            font-size:0.75rem;font-weight:500;
                                            cursor:pointer;transition:background 0.2s;
                                        "
                                    >
                                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M3 6h18M19 6l-1 14H6L5 6M10 11v6M14 11v6M9 6V4h6v2"/>
                                        </svg>
                                        削除
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- 区切り線 --}}
        <hr class="border-gray-200 mb-10">

        {{-- ▼ 読みたいセクション --}}
        <div class="mb-10">

            {{-- セクション見出し --}}
            <div class="flex items-center gap-3 mb-5">
                <div style="width:36px;height:36px;background:#f0fdf4;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                    <svg width="18" height="18" fill="none" stroke="#22c55e" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-800">読みたい</h2>
                    <p class="text-xs text-gray-400">{{ $wantToReads->count() }}冊</p>
                </div>
            </div>

            {{-- 読みたいが空の場合 --}}
            @if ($wantToReads->isEmpty())
                <div style="background:white;border-radius:16px;padding:32px;text-align:center;border:1px solid #f3f4f6;">
                    <svg width="40" height="40" fill="none" stroke="#d1d5db" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 12px;">
                        <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/>
                    </svg>
                    <p class="text-gray-400 text-sm">読みたいリストはまだありません</p>
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    @foreach ($wantToReads as $bookmark)
                        <div class="manga-card bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100">
                            <a href="/mangas/{{ $bookmark->manga->mal_id }}" style="text-decoration:none;">
                                <div class="overflow-hidden" style="height:200px;">
                                    <img src="{{ $bookmark->manga->image_url }}"
                                        alt="{{ $bookmark->manga->title }}"
                                        class="w-full h-full object-cover">
                                </div>
                                <div class="px-3 pt-3">
                                    <p class="font-bold text-sm text-gray-800 leading-tight">
                                        {{ $bookmark->manga->title_japanese ?? $bookmark->manga->title }}
                                    </p>
                                </div>
                            </a>
                            {{-- 削除ボタン --}}
                            <div class="px-3 pb-3 mt-2">
                                <form action="/bookmarks/{{ $bookmark->id }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn"
                                        style="
                                            display:inline-flex;align-items:center;gap:4px;
                                            background:#fff5f5;color:#ef4444;
                                            border:1px solid #fecaca;
                                            border-radius:8px;padding:5px 10px;
                                            font-size:0.75rem;font-weight:500;
                                            cursor:pointer;transition:background 0.2s;
                                        "
                                    >
                                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M3 6h18M19 6l-1 14H6L5 6M10 11v6M14 11v6M9 6V4h6v2"/>
                                        </svg>
                                        削除
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- 区切り線 --}}
        <hr class="border-gray-200 mb-10">

        {{-- ▼ レビューセクション --}}
        <div>

            {{-- セクション見出し --}}
            <div class="flex items-center gap-3 mb-5">
                <div style="width:36px;height:36px;background:#faf5ff;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                    <svg width="18" height="18" fill="none" stroke="#a855f7" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-800">レビュー</h2>
                    <p class="text-xs text-gray-400">{{ $reviews->count() }}件</p>
                </div>
            </div>

            {{-- レビューが空の場合 --}}
            @if ($reviews->isEmpty())
                <div style="background:white;border-radius:16px;padding:32px;text-align:center;border:1px solid #f3f4f6;">
                    <svg width="40" height="40" fill="none" stroke="#d1d5db" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 12px;">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    <p class="text-gray-400 text-sm">レビューはまだありません</p>
                </div>
            @else
                @foreach ($reviews as $review)
                    <div style="background:white;border-radius:16px;padding:20px;box-shadow:0 1px 3px rgba(0,0,0,0.06);border:1px solid #f3f4f6;margin-bottom:12px;">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                {{-- 漫画タイトル --}}
                                <a href="/mangas/{{ $review->manga->mal_id }}"
                                    text-decoration:none;>
                                    {{ $review->manga->title_japanese ?? $review->manga->title }}
                                </a>
                                {{-- 星評価 --}}
                                <div class="flex items-center gap-1 mt-2">
                                    <span style="color:#f59e0b;font-size:1rem;">
                                        {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                                    </span>
                                </div>
                                {{-- コメント --}}
                                @if ($review->comment)
                                    <p class="text-sm text-gray-600 mt-2">{{ $review->comment }}</p>
                                @endif
                            </div>
                            {{-- 削除ボタン --}}
                            <form action="/reviews/{{ $review->id }}" method="post" style="flex-shrink:0;margin-left:16px;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn"
                                    style="
                                        display:inline-flex;align-items:center;gap:4px;
                                        background:#fff5f5;color:#ef4444;
                                        border:1px solid #fecaca;
                                        border-radius:8px;padding:5px 10px;
                                        font-size:0.75rem;font-weight:500;
                                        cursor:pointer;transition:background 0.2s;
                                    "
                                >
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M3 6h18M19 6l-1 14H6L5 6M10 11v6M14 11v6M9 6V4h6v2"/>
                                    </svg>
                                    削除
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

    </div>

    {{-- ホバーアニメーション・削除ボタン用CSS --}}
    <style>
        .manga-card { transition: transform 0.2s, box-shadow 0.2s; }
        .manga-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0,0,0,0.12); }
        .manga-card img { transition: transform 0.3s; }
        .manga-card:hover img { transform: scale(1.03); }
        .delete-btn:hover { background: #fee2e2 !important; }
    </style>

</x-app-layout>
