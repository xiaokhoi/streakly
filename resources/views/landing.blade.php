<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>streakly — jaga streak, pelihara pet</title>

        <script>
            if (localStorage.getItem('theme') === 'dark' ||
               (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-100 dark:bg-gray-950 text-gray-900 dark:text-gray-100 font-sans antialiased">
        {{-- NAVBAR --}}
        <header class="h-14 flex items-center justify-between px-4 border-b border-gray-300 dark:border-neutral-800 bg-white dark:bg-neutral-900">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-yellow-400 flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-900" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C8 2 5 5.6 5 10c0 3.5 2 6.6 4.5 8.4.6.4 1.5.1 1.5-.7v-1.2c0-.6.5-1 1-1s1 .4 1 1v1.2c0 .8.9 1.1 1.5.7C17 16.6 19 13.5 19 10c0-4.4-3-8-7-8z"/>
                    </svg>
                </div>
                <span class="font-extrabold text-lg tracking-tight">streakly</span>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('login') }}" class="text-sm font-bold text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition">Masuk</a>
                <a href="{{ route('register') }}" class="bg-yellow-400 hover:bg-yellow-300 text-gray-900 text-sm font-bold px-4 py-2 rounded-full transition">Daftar</a>
            </div>
        </header>

        {{-- ===== HERO ===== --}}
        <section class="max-w-2xl mx-auto px-4 pt-12 pb-8 text-center">
            <div class="text-8xl mb-4 animate-bounce select-none">🥚</div>
            <h1 class="text-3xl sm:text-4xl font-extrabold leading-tight">
                Check-in tiap hari.<br>
                <span class="bg-yellow-400 text-gray-900 px-2 rounded-lg">Pet-mu</span> hidup.
            </h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm sm:text-base mt-4 max-w-md mx-auto">
                Bangun streak harian, pelihara pet yang berevolusi bareng konsistensimu,
                dan ajak temen buat streak bareng — kaya Snapchat, tapi buat kebiasaan baik.
            </p>
            <div class="mt-6 flex flex-col sm:flex-row gap-2 justify-center">
                <a href="{{ route('register') }}"
                    class="bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-bold py-3.5 px-8 rounded-full shadow-lg shadow-yellow-400/30 active:scale-95 transition">
                    Mulai gratis — netasin telurnya 🥚
                </a>
                <a href="{{ route('login') }}"
                    class="border border-gray-300 dark:border-neutral-700 hover:bg-white dark:hover:bg-neutral-900 text-gray-700 dark:text-gray-200 font-bold py-3.5 px-8 rounded-full active:scale-95 transition">
                    Udah punya akun
                </a>
            </div>
        </section>

        {{-- ===== SHOWCASE FITUR ===== --}}
        <section class="max-w-2xl mx-auto px-4 pb-10 space-y-3">

            <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-5 flex gap-4 items-start">
                <div class="w-11 h-11 rounded-xl bg-yellow-400/20 flex items-center justify-center text-2xl shrink-0">🔥</div>
                <div>
                    <h2 class="font-extrabold">Streak harian</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Check-in tiap hari, jaga apinya. Bolong? Tenang — ada token pemulihan buat nyelametin pet-mu.</p>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-5 flex gap-4 items-start">
                <div class="w-11 h-11 rounded-xl bg-yellow-400/20 flex items-center justify-center text-2xl shrink-0">🐣</div>
                <div>
                    <h2 class="font-extrabold">Pet yang berevolusi</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Dari telur jadi naga. Tiap milestone streak, pet-mu naik wujud. Gak konsisten? Ia reset ke telur lagi 🥲</p>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-5 flex gap-4 items-start">
                <div class="w-11 h-11 rounded-xl bg-yellow-400/20 flex items-center justify-center text-2xl shrink-0">💬</div>
                <div>
                    <h2 class="font-extrabold">Streak bareng temen</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Chat tiap hari sama sahabat, pacar, atau keluarga — streak bareng nyala kalau dua-duanya aktif. Gak ada yang mau jadi yang ngilangin.</p>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-5 flex gap-4 items-start">
                <div class="w-11 h-11 rounded-xl bg-yellow-400/20 flex items-center justify-center text-2xl shrink-0">🏘️</div>
                <div>
                    <h2 class="font-extrabold">Komunitas & peringkat</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Cerita progres di forum, panen reaksi 🔥, dan rebutan papan peringkat mingguan.</p>
                </div>
            </div>
        </section>

        {{-- ===== CTA AKHIR ===== --}}
        <section class="max-w-2xl mx-auto px-4 pb-14 text-center">
            <div class="bg-yellow-400 rounded-2xl p-8">
                <p class="text-xl font-extrabold text-gray-900">Telurnya nunggu buat menetas.</p>
                <a href="{{ route('register') }}"
                    class="inline-block mt-4 bg-gray-900 hover:bg-black text-white font-bold py-3.5 px-8 rounded-full active:scale-95 transition">
                    Daftar sekarang
                </a>
            </div>
        </section>

        <footer class="text-center text-xs text-gray-400 pb-8">
            streakly · dibuat dengan laravel & banyak kopi ☕
        </footer>
    </body>
</html>