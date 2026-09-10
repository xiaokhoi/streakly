<x-app-layout>
    <div class="max-w-2xl mx-auto px-3 pt-4">

        {{-- HEADER KECIL --}}
        <div class="mb-3">
            <h1 class="text-lg font-extrabold text-gray-900 dark:text-gray-100">Explore</h1>
            <p class="text-xs text-gray-500">Temuin habit yang lagi rame dijalanin orang</p>
        </div>

        {{-- SEARCH (mobile — desktop udah ada di navbar) --}}
        <div class="md:hidden flex items-center gap-2 bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-full px-4 py-2.5 mb-3">
            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
            <input type="text" placeholder="Cari kategori..." class="bg-transparent text-sm outline-none w-full dark:text-gray-100" 
                onfocus="this.closest('div').classList.add('ring-2','ring-yellow-400')"
                onblur="this.closest('div').classList.remove('ring-2','ring-yellow-400')">
        </div>

        {{-- LEADERBOARD CTA --}}
        <a href="{{ route('leaderboard.index') }}"
            class="block bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-3.5 mb-3 hover:border-yellow-400 dark:hover:border-yellow-600 transition">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-yellow-400 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-gray-900" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0" /></svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-gray-900 dark:text-gray-100">Papan Peringkat Mingguan</p>
                    <p class="text-xs text-gray-400">Siapa paling konsisten minggu ini?</p>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
            </div>
        </a>

        {{-- ===== GRID KATEGORI (ala daftar community) ===== --}}
        <h2 class="text-xs font-bold uppercase tracking-wide text-gray-500 px-1 mb-2">Semua kategori</h2>

        <div class="space-y-2">
            @foreach($categories as $category)
                <a href="{{ route('explore.show', $category) }}"
                    class="flex items-center gap-3 bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-3 hover:border-gray-400 dark:hover:border-neutral-700 active:scale-[0.99] transition">
                    {{-- avatar komunitas ala subreddit --}}
                    <div class="w-11 h-11 rounded-full bg-gray-100 dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 flex items-center justify-center text-xl shrink-0">
                        {{ $category->icon }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-sm text-gray-900 dark:text-gray-100">r/{{ strtolower(str_replace(' ', '', $category->name)) }}</p>
                        <p class="text-xs text-gray-400">{{ $category->name }} · {{ $category->habits_count }} habit</p>
                    </div>
                    <span class="text-[11px] font-bold text-gray-500 border border-gray-300 dark:border-neutral-700 rounded-full px-3 py-1.5 hover:bg-yellow-400 hover:border-yellow-400 hover:text-gray-900 transition">
                        Lihat
                    </span>
                </a>
            @endforeach
        </div>

        <div class="pb-4"></div>
    </div>
</x-app-layout>