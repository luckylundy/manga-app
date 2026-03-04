<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">マイページ</h2>
    </x-slot>
    {{-- メッセージがあれば表示 --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('message'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    {{ session('message') }}
                </div>
            @endif
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h3 class="text-lg font-bold mb-4">お気に入り</h3>
            @if ($favorites->isEmpty())
                <p class="text-gray-500 mb-8">
                    お気に入りはまだありません
                </p>
            @else
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
                    @foreach ($favorites as $bookmark)
                        <div class="bg-white shadow rounded p-4">
                            <a href="/mangas/{{ $bookmark->manga->mal_id }}">
                                <img src="{{ $bookmark->manga->image_url }}" alt="{{ $bookmark->manga->title }}" class="w-full h-64 object-cover">
                                <p class="mt-2 font-bold text-sm">
                                    {{ $bookmark->manga->title_japanese ?? $bookmark->manga->title }}
                                </p>
                            </a>
                            <form action="/bookmarks/{{ $bookmark->id }}" method="post" class="mt-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 text-xs">
                                    削除
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
            {{-- 読みたいリスト --}}
            <h3 class="text-lg font-bold mb-4">読みたい</h3>
            @if ($wantToReads->isEmpty())
                <p class="text-gray-500">読みたいリストはまだありません</p>
            @else
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    @foreach ($wantToReads as $bookmark)
                        <div class="bg-white shadow rounded p-4">
                            <a href="/mangas/{{ $bookmark->manga->mal_id }}">
                                <img src="{{ $bookmark->manga->image_url }}" alt="{{ $bookmark->manga->title }}" class="w-full h-64 object-cover">
                            </a>
                            <p class="mt-2 font-bold text-sm">
                                {{ $bookmark->manga->title_japanese ?? $bookmark->manga->title }}
                            </p>
                            <form action="/bookmarks/{{ $bookmark->id }}" method="post" class="mt-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 text-xs">削除</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
            {{-- レビュー一覧 --}}
            <h3 class="text-lg font-bold mb-4 mt-8">レビュー</h3>
            @if ($reviews->isEmpty())
                <p class="text-gray-500">レビューはまだありません</p>
            @else
                @foreach ($reviews as $review)
                    <div class="mb-4 p-4 bg-white shadow rounded">
                        <div class="flex justify-between items-center">
                            <a href="/mangas/{{ $review->manga->mal_id }}" class="font-bold text-blue-500">
                                {{ $review->manga->title_japanese ?? $review->manga->title }}
                            </a>
                            <form action="/reviews/{{ $review->id }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 text-xs">
                                    削除
                                </button>
                            </form>
                        </div>
                        <span class="text-yellow-500">
                            {{ str_repeat('★', $review->rating) }}{{ str_repeat('⭐︎', 5 - $review->rating) }}
                        </span>
                        @if ($review->comment)
                            <p class="mt-2 text-gray-700">
                                {{ $review->comment }}
                            </p>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</x-app-layout>