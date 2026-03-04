<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ $manga['title_japanese'] ?? $manga['title'] }}
        </h2>
    </x-slot>
    {{-- メッセージがあれば表示 --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('message'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('message') }}
                </div>
            @endif
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                {{-- 詳細ページには検索結果からもマイページからも来るので、検索画面ではなく前来たページに戻るようにする --}}
                <a href="javascript:history.back()" class="text-blue-500 mb-4 inline-block">← 戻る</a>
            </div>
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex gap-6">
                    {{-- 左側：表紙画像 --}}
                    <div class="w-48 flex-shrink-0">
                        <img src="{{ $manga['images']['jpg']['image_url'] }}" alt="{{ $manga['title'] }}" class="w-full rounded">
                    </div>
                    {{-- 右側：漫画情報 --}}
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold">
                            {{ $manga['title_japanese'] ?? $manga['title'] }}
                        </h1>
                        <p class="text-gray-500 text-sm mt-1">
                            {{ $manga['title'] }}
                        </p>
                        <div class="mt-4 space-y-2">
                            <p><span class="font-bold">スコア：{{ $manga['score'] ?? '未評価' }}</span></p>
                            <p><span class="font-bold">状態：{{ $manga['status'] ?? '不明' }}</span></p>
                            <p><span class="font-bold">巻数：{{ $manga['volumes'] ?? '不明' }}</span></p>
                            <p>
                                <span class="font-bold">著者：</span>
                                    @foreach ($manga['authors'] as $author)
                                        {{-- 作者が複数いる場合は「、」で区切る --}}
                                        {{ $author['name'] }} @if (!$loop->last)、@endif
                                    @endforeach
                            </p>
                            <p>
                                <span class="font-bold">ジャンル：</span>
                                @foreach ($manga['genres'] as $genre)
                                    {{ $genre['name'] }} @if (!$loop->last)、@endif
                                @endforeach
                            </p>
                        </div>
                        {{-- あらすじ --}}
                        <div class="mt-6">
                            <h3 class="font-bold text-lg">
                                あらすじ
                            </h3>
                            <p class="mt-2 text-gray-700">
                                {{ $manga['synopsys'] ?? 'あらすじ情報なし' }}
                            </p>
                        </div>
                        {{-- ブックマークボタン（ログイン時のみ表示） --}}
                        @auth
                            <div class="mt-6 flex gap-4">
                                {{-- お気に入りボタン --}}
                                @if ($favorite)
                                    <form action="/bookmarks/{{ $favorite->id }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded">
                                            お気に入り解除
                                        </button>
                                    </form>
                                @else
                                    <form action="/bookmarks" method="post">
                                        @csrf
                                        <input type="hidden" name="mal_id" value="{{ $manga['mal_id'] }}">
                                        <input type="hidden" name="type" value="favorite">
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">
                                            お気に入り
                                        </button>
                                    </form>
                                @endif
                                
                                {{-- 読みたいボタン --}}
                                @if ($wantToRead)
                                    <form action="/bookmarks/{{ $wantToRead->id }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded">
                                            読みたい解除
                                        </button>
                                    </form>
                                @else
                                    <form action="/bookmarks" method="post">
                                        @csrf
                                        <input type="hidden" name="mal_id" value="{{ $manga['mal_id'] }}">
                                        <input type="hidden" name="type" value="want_to_read">
                                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
                                            読みたい
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endauth
                        {{-- レビュー投稿フォーム --}}
                        @auth
                            <div class="mt-8 border-t pt-6">
                                <h3 class="font-bold text-lg mb-4">
                                    {{ $myReview ? 'レビューを編集' : 'レビューを投稿' }}
                                </h3>
                                <form action="/reviews" method="post">
                                    @csrf
                                    <input type="hidden" name="mal_id" value="{{ $manga['mal_id'] }}">

                                    {{-- 星評価 --}}
                                    <div class="mb-4">
                                        <label class="font-bold block mb-2">評価</label>
                                        <select name="rating" class="border rounded px-3 py-2">
                                            @for ($i = 5; $i >= 1; $i--)
                                                <option value="{{ $i }}" {{ ($myReview && $myReview->rating == $i) ? 'selected' : '' }}>
                                                    {{ str_repeat('★', $i) }}{{ str_repeat('⭐︎', 5 - $i) }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>

                                    {{-- 感想 --}}
                                    <div class="mb-4">
                                        <label class="font-bold block mb-2">感想（任意）</label>
                                        <textarea name="comment" rows="4" class="border rounded px-3 py-2 w-full" placeholder="この漫画の感想を書いてください...">
                                            {{ $myReview->comment ?? '' }}
                                        </textarea>
                                    </div>
                                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded">
                                        {{ $myReview ? '更新する' : '投稿する' }}
                                    </button>
                                </form>
                            </div>
                        @endauth

                        {{-- レビュー一覧 --}}
                        <div class="mt-8 border-t pt-6">
                            <h3 class="font-bold text-lg mb-4">レビュー</h3>
                            @if (count($reviews) === 0)
                                <p class="text-gray-500">まだレビューはありません</p>
                            @else
                                @foreach ($reviews as $review)
                                    <div class="mb-4 p-4 bg-gray-50 rounded">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <span class="text-yellow-500">
                                                    {{ str_repeat('★', $review->rating) }}{{ str_repeat('⭐︎', 5 - $review->rating) }}
                                                </span>
                                                <span class="text-sm text-gray-500 ml-2">
                                                    {{ $review->user->name }}
                                                </span>
                                            </div>
                                            @if (auth()->check() && auth()->id() === $review->user_id)
                                                <form action="/reviews/{{ $review->id }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 text-xs">削除</button>
                                                </form>
                                            @endif
                                        </div>
                                        @if ($review->comment)
                                            <p class="mt-2 text-gray-700">{{ $review->comment }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>