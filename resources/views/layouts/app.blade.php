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

        {{-- TOP NAVBAR --}}
        <header class="fixed top-0 inset-x-0 z-50 bg-white dark:bg-neutral-900 border-b border-gray-300 dark:border-neutral-800">
            <div class="max-w-5xl mx-auto h-14 px-3 flex items-center gap-3">
                <a href="{{ auth()->check() ? route('dashboard') : url('/') }}" class="flex items-center gap-2 shrink-0">
                    <div class="w-8 h-8 rounded-full bg-yellow-400 flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-900" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C8 2 5 5.6 5 10c0 3.5 2 6.6 4.5 8.4.6.4 1.5.1 1.5-.7v-1.2c0-.6.5-1 1-1s1 .4 1 1v1.2c0 .8.9 1.1 1.5.7C17 16.6 19 13.5 19 10c0-4.4-3-8-7-8z"/>
                        </svg>
                    </div>
                    <span class="font-extrabold text-lg tracking-tight hidden sm:block">streakly</span>
                </a>

                @if(auth()->check())
                    <div class="hidden md:flex flex-1 max-w-xl mx-4">
                        <div class="w-full flex items-center gap-2 bg-gray-100 dark:bg-neutral-800 border border-transparent hover:border-yellow-400 dark:hover:border-yellow-500 rounded-full px-4 py-2 transition">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                            <input type="text" placeholder="Cari di streakly" class="bg-transparent text-sm outline-none w-full placeholder:text-gray-400 dark:text-gray-100">
                        </div>
                    </div>
                @endif

                <div class="flex-1 md:hidden"></div>

                <div class="flex items-center gap-2 shrink-0">
                    @if(auth()->check())
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-1 bg-gray-100 dark:bg-neutral-800 rounded-full px-3 py-1.5">
                            <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 24 24"><path d="M13.5 0.67s.74 2.65.74 4.8c0 2.06-1.35 3.73-3.41 3.73-2.07 0-3.63-1.67-3.63-3.73l.03-.36C5.21 7.51 4 10.62 4 14c0 4.42 3.58 8 8 8s8-3.58 8-8C20 8.61 17.41 3.8 13.5.67z"/></svg>
                            <span class="text-sm font-bold">{{ auth()->user()->current_streak }}</span>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="w-8 h-8 rounded-full overflow-hidden bg-gray-100 dark:bg-neutral-800 flex items-center justify-center">
                            <x-avatar :type="auth()->user()->avatar" class="w-7 h-7" />
                        </a>
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

        {{-- NAV: cuma buat user login --}}
        @if(auth()->check())
            <x-nav-bottom />
            <x-nav-sidebar />
        @endif
    </body>
</html>