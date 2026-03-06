<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            漫画レコメンドシステム
        </h2>
    </x-slot>

    {{-- メッセージがあれば表示 --}}
    @if (session('message'))
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-4">
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                {{ session('message') }}
            </div>
        </div>
    @endif

    {{-- ▼ ヒーローセクション --}}
    <div style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #1e40af 100%); position: relative; overflow: hidden;">

        {{-- 背景の光彩エフェクト --}}
        <div style="
            position: absolute; inset: 0; pointer-events: none;
            background:
                radial-gradient(circle at 20% 50%, rgba(99,102,241,0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(59,130,246,0.15) 0%, transparent 50%);
        "></div>

        <div class="max-w-6xl mx-auto px-6 py-20 flex items-center justify-between relative">

            {{-- 左側：テキスト + 検索バー --}}
            <div class="flex-1 max-w-xl">

                {{-- バッジ --}}
                <div style="
                    display: inline-flex; align-items: center; gap: 8px;
                    background: rgba(99,102,241,0.2);
                    border: 1px solid rgba(99,102,241,0.4);
                    border-radius: 9999px; padding: 6px 16px; margin-bottom: 24px;
                ">
                    <span style="width: 8px; height: 8px; background: #818cf8; border-radius: 50%; display: inline-block;"></span>
                    <span style="color: #c7d2fe; font-size: 0.875rem; font-weight: 500;">AI搭載の漫画レコメンドシステム</span>
                </div>

                {{-- キャッチコピー --}}
                <h1 style="font-size: 2.25rem; font-weight: 900; color: white; line-height: 1.3; margin-bottom: 16px;">
                    あなたにぴったりの<br>
                    <span style="color: #a5b4fc;">漫画</span>を見つけよう
                </h1>

                <p style="color: #c7d2fe; font-size: 1rem; margin-bottom: 32px; line-height: 1.75;">
                    8万冊以上の漫画データベースから検索。<br>
                    AIがあなたの好みに合わせたおすすめを提案します。
                </p>

                {{-- 検索フォーム --}}
                <form action="/mangas/search" method="get">
                    <div style="
                        display: flex;
                        background: white;
                        border-radius: 12px;
                        overflow: hidden;
                        box-shadow: 0 0 0 4px rgba(99,102,241,0.3), 0 8px 32px rgba(0,0,0,0.2);
                    ">
                        <input
                            type="text"
                            name="q"
                            placeholder="タイトルを入力..."
                            style="
                                flex: 1; padding: 16px 20px;
                                font-size: 1rem; color: #374151;
                                border: none; outline: none;
                                background: transparent;
                            "
                        >
                        <button
                            type="submit"
                            style="
                                background: #4f46e5; color: white;
                                padding: 16px 24px; font-weight: 500;
                                border: none; cursor: pointer;
                                display: flex; align-items: center; gap: 8px;
                                transition: background 0.2s;
                            "
                            onmouseover="this.style.background='#4338ca'"
                            onmouseout="this.style.background='#4f46e5'"
                        >
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="8"/>
                                <path d="m21 21-4.35-4.35"/>
                            </svg>
                            検索
                        </button>
                    </div>
                </form>

                <p style="color: #818cf8; font-size: 0.75rem; margin-top: 12px;">
                    例：「ONE PIECE」「進撃の巨人」「鬼滅の刃」
                </p>
            </div>

            {{-- 右側：浮かぶ漫画カバー（大画面のみ表示） --}}
            <div class="hidden lg:flex items-end gap-4 ml-16 pb-4">
                <div style="animation: float1 6s ease-in-out infinite;">
                    <div style="
                        width: 112px; height: 160px;
                        background: linear-gradient(135deg, #f472b6, #9333ea);
                        border-radius: 10px;
                        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
                        display: flex; align-items: flex-end; padding: 10px;
                    ">
                        <span style="color: white; font-size: 0.75rem; font-weight: 700;">推しの子</span>
                    </div>
                </div>
                <div style="animation: float2 8s ease-in-out infinite; margin-bottom: 24px;">
                    <div style="
                        width: 112px; height: 160px;
                        background: linear-gradient(135deg, #fb923c, #dc2626);
                        border-radius: 10px;
                        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
                        display: flex; align-items: flex-end; padding: 10px;
                    ">
                        <span style="color: white; font-size: 0.75rem; font-weight: 700;">ONE PIECE</span>
                    </div>
                </div>
                <div style="animation: float3 7s ease-in-out infinite;">
                    <div style="
                        width: 112px; height: 160px;
                        background: linear-gradient(135deg, #60a5fa, #4f46e5);
                        border-radius: 10px;
                        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
                        display: flex; align-items: flex-end; padding: 10px;
                    ">
                        <span style="color: white; font-size: 0.75rem; font-weight: 700;">鬼滅の刃</span>
                    </div>
                </div>
            </div>

        </div>

        {{-- 波形の区切り --}}
        <div style="position: absolute; bottom: 0; left: 0; right: 0;">
            <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 60L480 20L960 50L1440 10V60H0Z" fill="#f9fafb"/>
            </svg>
        </div>

    </div>

    {{-- アニメーション用CSS --}}
    <style>
        @keyframes float1 {
            0%, 100% { transform: translateY(0px) rotate(-3deg); }
            50%       { transform: translateY(-12px) rotate(-3deg); }
        }
        @keyframes float2 {
            0%, 100% { transform: translateY(0px) rotate(2deg); }
            50%       { transform: translateY(-8px) rotate(2deg); }
        }
        @keyframes float3 {
            0%, 100% { transform: translateY(0px) rotate(-1deg); }
            50%       { transform: translateY(-15px) rotate(-1deg); }
        }
    </style>

    {{-- ▼ 機能紹介セクション --}}
    <div style="background: #f9fafb; padding: 64px 24px;">
        <div class="max-w-5xl mx-auto">

            {{-- 見出し --}}
            <div style="text-align: center; margin-bottom: 48px;">
                <h2 style="font-size: 1.5rem; font-weight: 700; color: #1f2937; margin-bottom: 12px;">
                    3つの機能で漫画探しをもっと楽しく
                </h2>
                <p style="color: #9ca3af; font-size: 0.875rem;">
                    気になる漫画を検索して、お気に入りを管理。AIに相談もできます。
                </p>
            </div>

            {{-- カード3枚 --}}
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px;">

                {{-- 検索カード --}}
                <a href="/mangas/search" style="text-decoration: none;">
                    <div style="
                        background: white; border-radius: 16px; padding: 28px;
                        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
                        border: 1px solid #f3f4f6;
                        transition: transform 0.2s, box-shadow 0.2s;
                        cursor: pointer;
                    "
                    onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 32px rgba(0,0,0,0.1)';"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.08)';"
                    >
                        <div style="
                            width: 48px; height: 48px; background: #eef2ff;
                            border-radius: 12px; display: flex; align-items: center;
                            justify-content: center; margin-bottom: 20px;
                        ">
                            <svg width="22" height="22" fill="none" stroke="#6366f1" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                            </svg>
                        </div>
                        <h3 style="font-weight: 700; color: #1f2937; font-size: 1.125rem; margin-bottom: 8px;">漫画を検索</h3>
                        <p style="color: #9ca3af; font-size: 0.875rem; line-height: 1.6; margin-bottom: 16px;">
                            タイトルで漫画を検索。スコアや巻数、あらすじなど詳細情報を確認できます。
                        </p>
                        <span style="color: #6366f1; font-size: 0.875rem; font-weight: 500;">検索する →</span>
                    </div>
                </a>

                {{-- マイページカード --}}
                <a href="/mypage" style="text-decoration: none;">
                    <div style="
                        background: white; border-radius: 16px; padding: 28px;
                        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
                        border: 1px solid #f3f4f6;
                        transition: transform 0.2s, box-shadow 0.2s;
                        cursor: pointer;
                    "
                    onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 32px rgba(0,0,0,0.1)';"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.08)';"
                    >
                        <div style="
                            width: 48px; height: 48px; background: #f0fdf4;
                            border-radius: 12px; display: flex; align-items: center;
                            justify-content: center; margin-bottom: 20px;
                        ">
                            <svg width="22" height="22" fill="none" stroke="#22c55e" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/>
                            </svg>
                        </div>
                        <h3 style="font-weight: 700; color: #1f2937; font-size: 1.125rem; margin-bottom: 8px;">マイページ</h3>
                        <p style="color: #9ca3af; font-size: 0.875rem; line-height: 1.6; margin-bottom: 16px;">
                            お気に入りや読みたいリストを管理。自分だけの漫画ライブラリを作れます。
                        </p>
                        <span style="color: #22c55e; font-size: 0.875rem; font-weight: 500;">マイページへ →</span>
                    </div>
                </a>

                {{-- AIおすすめカード --}}
                <a href="/recommend" style="text-decoration: none;">
                    <div style="
                        background: white; border-radius: 16px; padding: 28px;
                        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
                        border: 1px solid #f3f4f6;
                        transition: transform 0.2s, box-shadow 0.2s;
                        cursor: pointer;
                    "
                    onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 32px rgba(0,0,0,0.1)';"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.08)';"
                    >
                        <div style="
                            width: 48px; height: 48px; background: #faf5ff;
                            border-radius: 12px; display: flex; align-items: center;
                            justify-content: center; margin-bottom: 20px;
                        ">
                            <svg width="22" height="22" fill="none" stroke="#a855f7" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M12 16v-4M12 8h.01"/>
                            </svg>
                        </div>
                        <h3 style="font-weight: 700; color: #1f2937; font-size: 1.125rem; margin-bottom: 8px;">AIおすすめ</h3>
                        <p style="color: #9ca3af; font-size: 0.875rem; line-height: 1.6; margin-bottom: 16px;">
                            読みたい雰囲気を自由に入力するだけ。AIがあなたにぴったりの漫画を提案します。
                        </p>
                        <span style="color: #a855f7; font-size: 0.875rem; font-weight: 500;">AIに相談する →</span>
                    </div>
                </a>

            </div>
        </div>
    </div>

</x-app-layout>