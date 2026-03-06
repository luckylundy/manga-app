<x-app-layout>
    <x-slot name="header">
        {{-- ヘッダー：検索結果タイトル＋再検索バー --}}
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-400 mb-1">検索結果</p>
                <h2 class="text-xl font-bold text-gray-800">「{{ $query }}」の検索結果</h2>
            </div>
            {{-- 再検索バー（タブレット以上で表示） --}}
            <form action="/mangas/search" method="get" class="hidden md:flex items-center gap-2">
                <input
                    type="text"
                    name="q"
                    value="{{ $query }}"
                    class="border border-gray-200 rounded-lg px-4 py-2 text-sm w-64 focus:outline-none focus:ring-2 focus:ring-indigo-300"
                >
                <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors flex items-center gap-1">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                    </svg>
                    再検索
                </button>
            </form>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-6 py-6">

        {{-- 戻るリンク＋ページ数表示 --}}
        <div class="flex items-center justify-between mb-5">
            <a href="/" style="display:inline-flex;align-items:center;gap:6px;color:#6366f1;font-size:0.875rem;font-weight:500;text-decoration:none;">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M19 12H5M12 5l-7 7 7 7"/>
                </svg>
                検索に戻る
            </a>
            <p class="text-sm text-gray-400">{{ $page }} / {{ $lastPage }} ページ</p>
        </div>

        {{-- 漫画カードグリッド
            スマホ：2列
            タブレット：3列
            PC：5列 → 5列×2行＝10枚表示 --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach ($mangas as $manga)
                <a href="/mangas/{{ $manga['mal_id'] }}"
                    class="manga-card bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100"
                    style="text-decoration:none;">
                    <div class="overflow-hidden" style="height:200px;">
                        <img src="{{ $manga['images']['jpg']['image_url'] }}"
                            alt="{{ $manga['title'] }}"
                            class="w-full h-full object-cover">
                    </div>
                    <div class="p-3">
                        <p class="font-bold text-sm text-gray-800 leading-tight mb-1">
                            {{ $manga['title_japanese'] ?? $manga['title'] }}
                        </p>
                        <div style="display:flex;align-items:center;gap:4px;">
                            {{-- スコアがある場合 --}}
                            @if ($manga['score'])
                                <svg width="11" height="11" fill="#f59e0b" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <span style="font-size:0.75rem;color:#6b7280;">{{ $manga['score'] }}</span>
                            @else
                            {{-- スコアがない場合 --}}
                                <svg width="11" height="11" fill="#d1d5db" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <span style="font-size:0.75rem;color:#d1d5db;">未評価</span>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- ページネーション --}}
        <div class="mt-10 flex items-center justify-center gap-2">

            {{-- 前へボタン：1ページ目のときは非表示 --}}
            @if ($page > 1)
                <a href="/mangas/search?q={{ $query }}&page={{ $page - 1 }}"
                    style="display:inline-flex;align-items:center;gap:6px;background:white;border:1px solid #e5e7eb;color:#374151;font-size:0.875rem;font-weight:500;padding:10px 16px;border-radius:10px;text-decoration:none;box-shadow:0 1px 3px rgba(0,0,0,0.06);">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 12H5M12 5l-7 7 7 7"/>
                    </svg>
                    前へ
                </a>
            @endif

            {{-- 1ページ目は常に表示 --}}
            @if ($page == 1)
                {{-- 現在ページ（紺色） --}}
                <span style="background:#4f46e5;color:white;font-size:0.875rem;font-weight:700;padding:10px 14px;border-radius:10px;">1</span>
            @else
                <a href="/mangas/search?q={{ $query }}&page=1"
                    style="background:white;border:1px solid #e5e7eb;color:#374151;font-size:0.875rem;font-weight:500;padding:10px 14px;border-radius:10px;text-decoration:none;box-shadow:0 1px 3px rgba(0,0,0,0.06);">1</a>
            @endif

            {{-- 現在ページが4以上なら「...」を表示 --}}
            @if ($page > 3)
                <span style="color:#9ca3af;font-size:0.875rem;padding:0 4px;">...</span>
            @endif

            {{-- 現在ページの前後2ページを表示
                ただし1ページ目と最終ページは除く --}}
            @for ($i = max(2, $page - 2); $i <= min($lastPage - 1, $page + 2); $i++)
                @if ($i == $page)
                    {{-- 現在ページ（紺色） --}}
                    <span style="background:#4f46e5;color:white;font-size:0.875rem;font-weight:700;padding:10px 14px;border-radius:10px;">{{ $i }}</span>
                @else
                    <a href="/mangas/search?q={{ $query }}&page={{ $i }}"
                        style="background:white;border:1px solid #e5e7eb;color:#374151;font-size:0.875rem;font-weight:500;padding:10px 14px;border-radius:10px;text-decoration:none;box-shadow:0 1px 3px rgba(0,0,0,0.06);">{{ $i }}</a>
                @endif
            @endfor

            {{-- 現在ページが最終ページの3つ前より小さければ「...」を表示 --}}
            @if ($page < $lastPage - 2)
                <span style="color:#9ca3af;font-size:0.875rem;padding:0 4px;">...</span>
            @endif

            {{-- 最終ページは常に表示 --}}
            @if ($lastPage > 1)
                @if ($page == $lastPage)
                    {{-- 現在ページ（紺色） --}}
                    <span style="background:#4f46e5;color:white;font-size:0.875rem;font-weight:700;padding:10px 14px;border-radius:10px;">{{ $lastPage }}</span>
                @else
                    <a href="/mangas/search?q={{ $query }}&page={{ $lastPage }}"
                        style="background:white;border:1px solid #e5e7eb;color:#374151;font-size:0.875rem;font-weight:500;padding:10px 14px;border-radius:10px;text-decoration:none;box-shadow:0 1px 3px rgba(0,0,0,0.06);">{{ $lastPage }}</a>
                @endif
            @endif

            {{-- 次へボタン：最終ページのときは非表示 --}}
            @if ($page < $lastPage)
                <a href="/mangas/search?q={{ $query }}&page={{ $page + 1 }}"
                    style="display:inline-flex;align-items:center;gap:6px;background:white;border:1px solid #e5e7eb;color:#374151;font-size:0.875rem;font-weight:500;padding:10px 16px;border-radius:10px;text-decoration:none;box-shadow:0 1px 3px rgba(0,0,0,0.06);">
                    次へ
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            @endif

        </div>

    </div>

    {{-- ホバーアニメーション用CSS --}}
    <style>
        .manga-card { transition: transform 0.2s, box-shadow 0.2s; }
        .manga-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0,0,0,0.12); }
        .manga-card img { transition: transform 0.3s; }
        .manga-card:hover img { transform: scale(1.03); }
    </style>

</x-app-layout>
