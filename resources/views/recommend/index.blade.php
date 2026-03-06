<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">AIおすすめ</h2>
    </x-slot>

    <div style="max-width:720px;margin:0 auto;padding:40px 24px 80px;">

        {{-- エラーメッセージ --}}
        @if (session('message'))
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
                {{ session('message') }}
            </div>
        @endif

        {{-- ヘッダー --}}
        <div style="text-align:center;margin-bottom:40px;">
            {{-- ロボットアイコン --}}
            <div style="width:64px;height:64px;background:linear-gradient(135deg,#6366f1,#a855f7);border-radius:18px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                <svg width="32" height="32" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="8" width="18" height="12" rx="2"/>
                    <path d="M12 8V4M8 4h8"/>
                    <circle cx="9" cy="14" r="1.5" fill="white"/>
                    <circle cx="15" cy="14" r="1.5" fill="white"/>
                    <path d="M9 18h6"/>
                </svg>
            </div>
            <h1 style="font-size:1.5rem;font-weight:700;color:#1f2937;margin-bottom:8px;">AIに漫画をおすすめしてもらう</h1>
            <p style="font-size:0.875rem;color:#9ca3af;">読みたい漫画の雰囲気や好みを自由に入力してください</p>
        </div>

        {{-- 入力カード --}}
        <div style="background:white;border-radius:16px;padding:28px;box-shadow:0 1px 3px rgba(0,0,0,0.06);border:1px solid #f3f4f6;">

            {{-- 例タグ --}}
            <p style="font-size:0.75rem;color:#9ca3af;margin-bottom:10px;">例えばこんな質問ができます</p>
            <div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:20px;">
                <span style="background:#eef2ff;color:#6366f1;padding:6px 12px;border-radius:20px;font-size:0.75rem;font-weight:500;">バトルもので熱い展開がある漫画</span>
                <span style="background:#eef2ff;color:#6366f1;padding:6px 12px;border-radius:20px;font-size:0.75rem;font-weight:500;">泣ける感動的なストーリー</span>
                <span style="background:#eef2ff;color:#6366f1;padding:6px 12px;border-radius:20px;font-size:0.75rem;font-weight:500;">日常系のほのぼの漫画</span>
            </div>

            <form action="/recommend" method="post">
                @csrf

                {{-- テキストエリア --}}
                <textarea
                    name="question"
                    rows="5"
                    style="width:100%;border:1px solid #e5e7eb;border-radius:12px;padding:14px;font-size:0.875rem;color:#374151;resize:vertical;transition:all 0.2s;box-sizing:border-box;"
                    placeholder="例：バトルもので熱い展開がある漫画を教えて"
                ></textarea>

                {{-- 送信ボタン --}}
                <button type="submit" style="
                    margin-top:16px;
                    display:flex;align-items:center;justify-content:center;gap:8px;
                    width:100%;padding:14px;
                    background:linear-gradient(135deg,#6366f1,#a855f7);
                    color:white;border:none;border-radius:12px;
                    font-size:0.95rem;font-weight:600;cursor:pointer;
                    transition:opacity 0.2s;
                ">
                    <svg width="18" height="18" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="8" width="18" height="12" rx="2"/>
                        <path d="M12 8V4M8 4h8"/>
                        <circle cx="9" cy="14" r="1.5" fill="white"/>
                        <circle cx="15" cy="14" r="1.5" fill="white"/>
                        <path d="M9 18h6"/>
                    </svg>
                    AIにおすすめを聞く
                </button>
            </form>

        </div>
    </div>

</x-app-layout>