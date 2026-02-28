<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            「{{ $query }}」の検索結果
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @foreach ($mangas as $manga)
                    <div class="bg-white shadow rounded p-4">
                        <img src="{{ $manga['images']['jpg']['image_url'] }}" alt="{{ $manga['title'] }}" class="w-full h-64 object-cover">
                        <p class="mt-2 font-bold text-sm">
                            {{-- 日本語タイトルがなければ外国語タイトルを表示 --}}
                            {{ $manga['title_japanese'] ?? $manga['title'] }}
                        </p>
                        <p class="text-xs text-gray-500">
                            スコア：{{ $manga['score'] ?? '未評価' }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>