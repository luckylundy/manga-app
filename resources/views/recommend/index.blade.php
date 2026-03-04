<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">AIのおすすめ</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- エラーメッセージを表示 --}}
                    @if (session('message'))
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                            {{ session('message') }}
                        </div>
                    @endif
                    <h1 class="text-2xl font-bold mb-4">AIに漫画をおすすめしてもらう</h1>
                    <p class="text-gray-500 mb-6">読みたい漫画の雰囲気や好みを自由に入力してください</p>

                    <form action="/recommend" method="post">
                        @csrf
                        <textarea name="question" rows="4" class="border rounded px-4 py-2 w-full" placeholder="例：バトルもので熱い展開がある漫画を教えて"></textarea>
                        <button type="submit" class="mt-4 bg-blue-500 text-white px-6 py-2 rounded">
                            おすすめを聞く
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>