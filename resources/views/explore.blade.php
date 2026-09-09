<x-app-layout>
     <div class="py-6 max-w-md mx-auto px-4">
        <h1 class="text-xl font-extrabold text-gray-800 dark:text-gray-100 mb-1">🧭 Explore</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">Temuin habit yang lagi rame dijalanin orang</p>

        <a href="{{ route('leaderboard.index') }}"
            class="bg-gradient-to-r from-amber-400 to-orange-500 rounded-2xl p-4 mb-4 shadow-lg flex items-center justify-between active:scale-95 transition">
            <div>
                <p class="font-extrabold text-white">🏆 Leaderboard Mingguan</p>
                <p class="text-xs text-white/80">Siapa paling konsisten minggu ini?</p>
            </div>
            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </a>
                <div class="grid grid-cols-2 gap-3">
            @foreach($categories as $category)
                <a href="{{ route('explore.show', $category) }}"
                    class="bg-white dark:bg-gray-800 rounded-2xl p-4 shadow text-center active:scale-95 transition">
                    <div class="text-4xl mb-2">{{ $category->icon }}</div>
                    <p class="font-bold text-gray-700 dark:text-gray-200 text-sm">{{ $category->name }}</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">{{ $category->habits_count }} habit</p>
                </a>
            @endforeach
        </div>
    </div>
</x-app-layout>

        