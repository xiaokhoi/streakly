<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'HabitPet') }}</title>

        <script>
            if (localStorage.getItem('theme') === 'dark' ||
               (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gradient-to-br from-indigo-600 via-purple-600 to-fuchsia-700 dark:from-gray-950 dark:via-indigo-950 dark:to-purple-950 flex flex-col sm:justify-center items-center pt-6 sm:pt-0">

            {{-- BRANDING --}}
            <div class="text-center mb-6">
                <div class="text-7xl animate-bounce select-none">🥚</div>
                <h1 class="text-3xl font-extrabold text-white mt-2 tracking-tight">HabitPet</h1>
                <p class="text-white/80 text-sm mt-1">Jaga streak, pelihara pet-mu 🐣</p>
            </div>

            {{-- KARTU FORM --}}
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-2xl overflow-hidden sm:rounded-3xl">
                {{ $slot }}
            </div>

            <p class="text-white/60 text-xs mt-6 mb-4">Check-in tiap hari. Jangan sampe pet-mu kelaparan 🥺</p>
        </div>
    </body>
</html>