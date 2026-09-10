<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-950 text-gray-900 dark:text-gray-100">

        {{-- ===== TOP BAR ala reddit: logo kiri ===== --}}
        <header class="h-14 flex items-center px-4 border-b border-gray-300 dark:border-neutral-800">
            <a href="/" class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-yellow-400 flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-900" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C8 2 5 5.6 5 10c0 3.5 2 6.6 4.5 8.4.6.4 1.5.1 1.5-.7v-1.2c0-.6.5-1 1-1s1 .4 1 1v1.2c0 .8.9 1.1 1.5.7C17 16.6 19 13.5 19 10c0-4.4-3-8-7-8z"/>
                    </svg>
                </div>
                <span class="font-extrabold text-lg tracking-tight">streakly</span>
            </a>
        </header>

        {{-- ===== KONTEN ===== --}}
        <main class="max-w-md mx-auto px-4 pt-8 pb-12">
            <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-6">
                {{ $slot }}
            </div>

            <p class="text-center text-xs text-gray-400 mt-5">
                Check-in tiap hari. Jaga streak-mu.
            </p>
        </main>
    </body>
</html>