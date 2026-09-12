<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'streakly') }}</title>

        <script>
            if (localStorage.getItem('theme') === 'dark' ||
               (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased h-full bg-gray-100 dark:bg-gray-950 text-gray-900 dark:text-gray-100">

        {{-- ===== TOP NAVBAR ===== --}}
        <header class="fixed top-0 inset-x-0 z-50 bg-white dark:bg-neutral-900 border-b border-gray-300 dark:border-neutral-800">
            <div class="max-w-5xl mx-auto h-14 px-3 flex items-center gap-3">

                {{-- LOGO --}}
                <a href="{{ auth()->check() ? route('dashboard') : url('/') }}" class="flex items-center gap-2 shrink-0">
                    <div class="w-8 h-8 rounded-full bg-yellow-400 flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-900" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C8 2 5 5.6 5 10c0 3.5 2 6.6 4.5 8.4.6.4 1.5.1 1.5-.7v-1.2c0-.6.5-1 1-1s1 .4 1 1v1.2c0 .8.9 1.1 1.5.7C17 16.6 19 13.5 19 10c0-4.4-3-8-7-8z"/>
                        </svg>
                    </div>
                    <span class="font-extrabold text-lg tracking-tight hidden sm:block">streakly</span>
                </a>

                {{-- SEARCH (desktop, user login) --}}
                @if(auth()->check())
                    <div class="hidden md:flex flex-1 max-w-xl mx-4">
                        <div class="w-full flex items-center gap-2 bg-gray-100 dark:bg-neutral-800 border border-transparent hover:border-yellow-400 dark:hover:border-yellow-500 rounded-full px-4 py-2 transition">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                            <input type="text" placeholder="Cari di streakly" class="bg-transparent text-sm outline-none w-full placeholder:text-gray-400 dark:text-gray-100">
                        </div>
                    </div>
                @endif

                <div class="flex-1 md:hidden"></div>

                {{-- KANAN: streak + dropdown avatar --}}
                <div class="flex items-center gap-2 shrink-0">
                    @if(auth()->check())
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-1 bg-gray-100 dark:bg-neutral-800 rounded-full px-3 py-1.5">
                            <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 24 24"><path d="M13.5 0.67s.74 2.65.74 4.8c0 2.06-1.35 3.73-3.41 3.73-2.07 0-3.63-1.67-3.63-3.73l.03-.36C5.21 7.51 4 10.62 4 14c0 4.42 3.58 8 8 8s8-3.58 8-8C20 8.61 17.41 3.8 13.5.67z"/></svg>
                            <span class="text-sm font-bold">{{ auth()->user()->current_streak }}</span>
                        </a>

                        {{-- DROPDOWN MENU AVATAR (ala github) --}}
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open"
                                class="w-8 h-8 rounded-full overflow-hidden bg-gray-100 dark:bg-neutral-800 flex items-center justify-center ring-2 transition
                                    {{ request()->routeIs('profile.*', 'settings') ? 'ring-yellow-400' : 'ring-transparent hover:ring-gray-300 dark:hover:ring-neutral-600' }}"
                                aria-label="Menu akun">
                                <x-avatar :email="auth()->user()->email" class="w-7 h-7" />
                            </button>

                            <div x-show="open" @click="open = false" class="fixed inset-0 z-40"></div>

                            <div x-show="open" x-transition
                                class="absolute right-0 top-10 z-50 w-56 bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-700 rounded-xl shadow-2xl overflow-hidden">

                                <div class="px-4 py-3 border-b border-gray-100 dark:border-neutral-800">
                                    <p class="text-sm font-extrabold text-gray-900 dark:text-gray-100 truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-[11px] text-gray-400">{{ '@' . auth()->user()->username }}</p>
                                </div>

                                <div class="p-1.5">
                                    <a href="{{ route('profile.edit') }}" @click="open = false"
                                        class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-bold text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-neutral-800 transition">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>
                                        Halaman profil
                                    </a>

                                    <a href="{{ route('settings') }}" @click="open = false"
                                        class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-bold text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-neutral-800 transition">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.111-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                                        Pengaturan
                                    </a>

                                    <button type="button" @click="open = false;
                                            const el = document.documentElement;
                                            const dark = el.classList.toggle('dark');
                                            localStorage.setItem('theme', dark ? 'dark' : 'light');"
                                        class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-bold text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-neutral-800 transition">
                                        <svg class="w-4 h-4 text-gray-400 dark:hidden" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" /></svg>
                                        <svg class="w-4 h-4 text-amber-400 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" /></svg>
                                        <span class="dark:hidden">Mode gelap</span>
                                        <span class="hidden dark:inline">Mode terang</span>
                                    </button>

                                    <div class="border-t border-gray-100 dark:border-neutral-800 my-1"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-bold text-red-500 hover:bg-red-50 dark:hover:bg-red-950/50 transition">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" /></svg>
                                            Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="bg-yellow-400 hover:bg-yellow-300 text-gray-900 text-sm font-bold px-4 py-1.5 rounded-full transition">Masuk</a>
                    @endif
                </div>
            </div>
        </header>

        {{-- KONTEN --}}
        <main class="pt-16 pb-24">
            {{ $slot }}
        </main>

        {{-- ===== BOTTOM NAV (mobile, user login) ===== --}}
        @if(auth()->check())
            <nav class="md:hidden fixed bottom-0 inset-x-0 z-50 bg-white dark:bg-neutral-900 border-t border-gray-300 dark:border-neutral-800">
                <div class="max-w-md mx-auto flex justify-around py-1.5">
                    <a href="{{ route('dashboard') }}"
                        class="flex flex-col items-center gap-0.5 px-3 py-1 text-[10px] font-medium transition
                            {{ request()->routeIs('dashboard') ? 'text-gray-900 dark:text-white' : 'text-gray-400' }}">
                        <svg class="w-6 h-6" fill="{{ request()->routeIs('dashboard') ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75" />
                        </svg>
                        Home
                    </a>

                    <a href="{{ route('explore') }}"
                        class="flex flex-col items-center gap-0.5 px-3 py-1 text-[10px] font-medium transition
                            {{ request()->routeIs('explore.*') ? 'text-gray-900 dark:text-white' : 'text-gray-400' }}">
                        <svg class="w-6 h-6" fill="{{ request()->routeIs('explore.*') ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m-18.432 0A8.959 8.959 0 0 1 3 12c0-.778.099-1.533.284-2.253" />
                        </svg>
                        Explore
                    </a>

                    <a href="{{ route('social.index') }}"
                        class="flex flex-col items-center gap-0.5 px-3 py-1 text-[10px] font-medium transition
                            {{ request()->routeIs('social.*', 'chat.*') ? 'text-gray-900 dark:text-white' : 'text-gray-400' }}">
                        <div class="relative">
                            <svg class="w-6 h-6" fill="{{ request()->routeIs('social.*', 'chat.*') ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                            </svg>
                            @if(auth()->user()->hasStreakInDanger())
                                <span class="absolute -top-0.5 -right-1 w-2.5 h-2.5 rounded-full bg-red-500 border-2 border-white dark:border-neutral-900 animate-pulse"></span>
                            @endif
                        </div>
                        Chat
                    </a>

                    <a href="{{ route('leaderboard.index') }}"
                        class="flex flex-col items-center gap-0.5 px-3 py-1 text-[10px] font-medium transition
                            {{ request()->routeIs('leaderboard.*') ? 'text-gray-900 dark:text-white' : 'text-gray-400' }}">
                        <svg class="w-6 h-6" fill="{{ request()->routeIs('leaderboard.*') ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0" />
                        </svg>
                        Papan
                    </a>

                    <a href="{{ route('profile.edit') }}"
                        class="flex flex-col items-center gap-0.5 px-3 py-1 text-[10px] font-medium transition
                            {{ request()->routeIs('profile.*') ? 'text-gray-900 dark:text-white' : 'text-gray-400' }}">
                        <svg class="w-6 h-6" fill="{{ request()->routeIs('profile.*') ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        Profil
                    </a>
                </div>
            </nav>

            {{-- ===== SIDEBAR DESKTOP ===== --}}
            <nav class="hidden md:flex fixed left-0 top-14 bottom-0 w-56 flex-col gap-1 p-3 border-r border-gray-300 dark:border-neutral-800">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-full text-sm font-bold transition
                        {{ request()->routeIs('dashboard') ? 'bg-yellow-400/20 text-gray-900 dark:text-yellow-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-neutral-800' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75" /></svg>
                    Home
                </a>

                <a href="{{ route('explore') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-full text-sm font-bold transition
                        {{ request()->routeIs('explore.*') ? 'bg-yellow-400/20 text-gray-900 dark:text-yellow-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-neutral-800' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m-18.432 0A8.959 8.959 0 0 1 3 12c0-.778.099-1.533.284-2.253" /></svg>
                    Explore
                </a>

                <a href="{{ route('social.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-full text-sm font-bold transition
                        {{ request()->routeIs('social.*', 'chat.*') ? 'bg-yellow-400/20 text-gray-900 dark:text-yellow-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-neutral-800' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" /></svg>
                    Chat
                </a>

                <a href="{{ route('leaderboard.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-full text-sm font-bold transition
                        {{ request()->routeIs('leaderboard.*') ? 'bg-yellow-400/20 text-gray-900 dark:text-yellow-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-neutral-800' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0" /></svg>
                    Papan Peringkat
                </a>

                <a href="{{ route('badges.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-full text-sm font-bold transition
                        {{ request()->routeIs('badges.*') ? 'bg-yellow-400/20 text-gray-900 dark:text-yellow-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-neutral-800' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872" /></svg>
                    Badge
                </a>

                <a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-full text-sm font-bold transition
                        {{ request()->routeIs('profile.*') ? 'bg-yellow-400/20 text-gray-900 dark:text-yellow-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-neutral-800' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>
                    Profil
                </a>
            </nav>
        @endif
    </body>
</html>