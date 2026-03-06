<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="/">
                        <div style="width:36px;height:36px;background:linear-gradient(135deg,#38bdf8,#6366f1);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                            <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
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

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="'/'" :active="request()->is('/')">
                        検索
                    </x-nav-link>
                    <x-nav-link :href="'/mypage'" :active="request()->is('mypage')">
                        マイページ
                    </x-nav-link>
                    <x-nav-link :href="'/recommend'" :active="request()->is('recommend')">
                        AIおすすめ
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    {{-- ログイン中：ユーザー名メニューを表示 --}}
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()?->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="'/mypage'">
                                {{ __('マイページ') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('ログアウト') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    {{-- 未ログイン：ログインボタンを表示 --}}
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 mr-4">
                        ログイン
                    </a>
                    <a href="{{ route('register') }}" style="background:#4f46e5;color:white;padding:8px 16px;border-radius:8px;font-size:0.875rem;font-weight:500;text-decoration:none;">
                        新規登録
                    </a>
                @endif
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="'/'" :active="request()->is('/')">
                検索
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="'/mypage'" :active="request()->is('/mypage')">
                マイページ
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="'/recommend'" :active="request()->is('/recommend')">
                AIおすすめ
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">
                        {{ Auth::user()?->name }}
                    </div>
                    <div class="font-medium text-sm text-gray-500">
                        {{ Auth::user()?->email }}
                    </div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="'/mypage'">
                        {{ __('マイページ') }}
                    </x-responsive-nav-link>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.closest('form').submit();">
                            {{ __('ログアウト') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('ログイン') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')">
                        {{ __('新規登録') }}
                    </x-responsive-nav-link>
                </div>
            @endauth
        </div>
    </div>
</nav>
