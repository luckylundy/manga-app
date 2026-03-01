<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ $manga['title_japanese'] ?? $manga['title'] }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                                <form action="/bookmarks" method="post">
                                    @csrf
                                    <input type="hidden" name="mal_id" value="{{ $manga['mal_id'] }}">
                                    <input type="hidden" name="type" value="favorite">
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">
                                        お気に入り
                                    </button>
                                </form>
                                <form action="/bookmarks" method="post">
                                    @csrf
                                    <input type="hidden" name="mal_id" value="{{ $manga['mal_id'] }}">
                                    <input type="hidden" name="type" value="want_to_read">
                                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
                                        読みたい
                                    </button>
                                </form>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>