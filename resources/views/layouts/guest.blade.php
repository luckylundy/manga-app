<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="icon" type="image/svg+xml" href="/favicon.svg">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <div style="width:64px;height:64px;background:linear-gradient(135deg,#38bdf8,#6366f1);border-radius:18px;display:flex;align-items:center;justify-content:center;margin:0 auto;">
                        <svg width="44" height="44" fill="none" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="9" stroke="white" stroke-width="1.5" fill="white" fill-opacity="0.15"/>
                            <circle cx="12" cy="12" r="1.8" fill="white"/>
                            <path d="M12 3 L9.5 12 L12 10 L14.5 12 Z" fill="white"/>
                            <path d="M12 21 L14.5 12 L12 14 L9.5 12 Z" fill="white" opacity="0.45"/>
                            <line x1="12" y1="3.5" x2="12" y2="5" stroke="white" stroke-width="1.2" opacity="0.6"/>
                            <line x1="20.5" y1="12" x2="19" y2="12" stroke="white" stroke-width="1.2" opacity="0.6"/>
                            <line x1="3.5" y1="12" x2="5" y2="12" stroke="white" stroke-width="1.2" opacity="0.6"/>
                            <line x1="12" y1="20.5" x2="12" y2="19" stroke="white" stroke-width="1.2" opacity="0.6"/>
                        </svg>
                    </div>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
