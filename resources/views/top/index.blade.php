<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            漫画レコメンドシステム
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">
                        漫画を検索
                    </h1>
                    <form action="/mangas/search" method="get">
                        <input type="text" name="q" placeholder="タイトルを入力..." class="border rounded px-4 py-2 w-80">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded ml-2">
                            検索
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>