<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">AIおすすめ結果</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="/recommend" class="text-blue-500 mb-4 inline-block">
                ← 新しい質問をする
            </a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold text-lg mb-2">あなたの質問</h3>
                    <p class="mb-6 p-4 bg-gray-50 rounded">{{ $question }}</p>

                    <h3 class="font-bold text-lg mb-2">AIのおすすめ</h3>
                    <div class="prose max-w-none">
                        {{-- サニタイズはaskメソッドの中で実施済み --}}
                        {!! $answer !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>