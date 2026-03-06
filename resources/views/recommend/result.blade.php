<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">AIおすすめ結果</h2>
    </x-slot>

    <div style="max-width:720px;margin:0 auto;padding:40px 24px 80px;">

        {{-- 質問内容＋新しい質問ボタン --}}
        <div style="background:white;border-radius:16px;padding:20px 24px;box-shadow:0 1px 3px rgba(0,0,0,0.06);border:1px solid #f3f4f6;margin-bottom:20px;">
            <div class="flex items-center justify-between">
                <div>
                    <p style="font-size:0.7rem;color:#9ca3af;margin-bottom:4px;">あなたの質問</p>
                    <p style="font-size:1rem;font-weight:700;color:#1f2937;">{{ $question }}</p>
                </div>
                <a href="/recommend" style="
                    display:inline-flex;align-items:center;gap:6px;
                    background:#eef2ff;color:#6366f1;
                    padding:8px 14px;border-radius:10px;
                    font-size:0.8rem;font-weight:600;text-decoration:none;
                    flex-shrink:0;margin-left:16px;
                ">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 12H5M12 5l-7 7 7 7"/>
                    </svg>
                    新しい質問をする
                </a>
            </div>
        </div>

        {{-- AIおすすめ結果カード --}}
        <div style="background:white;border-radius:16px;padding:28px;box-shadow:0 1px 3px rgba(0,0,0,0.06);border:1px solid #f3f4f6;">

            {{-- AIアイコン＋見出し --}}
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
                <div style="width:36px;height:36px;background:linear-gradient(135deg,#6366f1,#a855f7);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="18" height="18" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="8" width="18" height="12" rx="2"/>
                        <path d="M12 8V4M8 4h8"/>
                        <circle cx="9" cy="14" r="1.5" fill="white"/>
                        <circle cx="15" cy="14" r="1.5" fill="white"/>
                        <path d="M9 18h6"/>
                    </svg>
                </div>
                <h3 style="font-size:1rem;font-weight:700;color:#1f2937;">AIのおすすめ</h3>
            </div>

            {{-- AIの回答 --}}
            <div style="font-size:0.875rem;color:#374151;line-height:1.8;">
                {{-- 導入文 --}}
                <p style="margin-bottom:16px;color:#374151;">
                    {{ $answer['intro'] }}
                </p>

                {{-- 漫画カード一覧 --}}
                <div style="display:flex;flex-direction:column;gap:12px;">
                    @foreach ($answer['mangas'] as $index => $manga)
                        <div style="
                            background:#f9fafb;border-radius:12px;padding:16px;
                            border-left:3px solid {{ $index % 2 === 0 ? '#6366f1' : '#a855f7' }};
                        ">
                            <p style="font-weight:700;color:#1f2937;margin-bottom:6px;">
                                {{ $manga['title'] }}
                            </p>
                            <p style="color:#6b7280;font-size:0.85rem;">
                                {{ $manga['reason'] }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    {{-- AIの回答内のタグにスタイルを当てる --}}
    <style>
        {{-- 見出し（漫画タイトル）をカード形式に --}}
        .recommend-answer p { margin-bottom: 8px; }

        {{-- AIの回答がhタグを使っている場合 --}}
        div[style*="line-height:1.8"] h3,
        div[style*="line-height:1.8"] h4,
        div[style*="line-height:1.8"] strong {
            display: block;
            font-weight: 700;
            color: #1f2937;
            margin-top: 16px;
            margin-bottom: 4px;
        }
        div[style*="line-height:1.8"] p {
            color: #6b7280;
            margin-bottom: 12px;
        }
    </style>

</x-app-layout>