<x-app-layout>
    <div class="py-6 max-w-md mx-auto px-4">
        <h1 class="text-xl font-extrabold text-gray-800 dark:text-gray-100 mb-1">📊 Recap Mingguan</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ $start->format('d M') }} – {{ $end->format('d M Y') }}</p>

        {{-- ANGKA UTAMA: HARI AKTIF --}}
        <div class="bg-gradient-to-br from-purple-600 to-fuchsia-600 rounded-3xl p-8 text-center text-white shadow-2xl mb-4">
            <p class="text-6xl font-extrabold">{{ $checkinDays }}<span class="text-2xl font-bold">/7</span></p>
            <p class="text-sm opacity-80 mt-1">hari aktif minggu lalu</p>

            @if($checkinDays >= 6)
                <p class="mt-3 inline-block bg-white/20 rounded-full px-4 py-1 text-sm font-bold">🔥 Gila, hampir sempurna!</p>
            @elseif($checkinDays >= 3)
                <p class="mt-3 inline-block bg-white/20 rounded-full px-4 py-1 text-sm font-bold">💪 Konsisten, gas terus!</p>
            @elseif($checkinDays >= 1)
                <p class="mt-3 inline-block bg-white/20 rounded-full px-4 py-1 text-sm font-bold">🌱 Awal yang bagus!</p>
            @else
                <p class="mt-3 inline-block bg-white/20 rounded-full px-4 py-1 text-sm font-bold">😅 Minggu lalu sepi... mulai lagi!</p>
            @endif
        </div>

        {{-- XP --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-4 mb-4 flex items-center justify-between">
            <div>
                <p class="font-bold text-gray-700 dark:text-gray-200">⚡ XP minggu lalu</p>
                <p class="text-xs text-gray-400 dark:text-gray-500">Hasil jerih payah 7 hari</p>
            </div>
            <p class="text-2xl font-extrabold text-purple-500">+{{ $weeklyXp }}</p>
        </div>

        {{-- HABIT JUARA --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-4 mb-4">
            <p class="font-bold text-gray-700 dark:text-gray-200 mb-1">🏆 Habit juara</p>
            @if($topHabit)
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Paling sering lu jalanin: <span class="font-extrabold text-indigo-600 dark:text-indigo-400">{{ $topHabit->name }}</span>
                    ({{ $topHabit->total }}x)
                </p>
            @else
                <p class="text-sm text-gray-400 dark:text-gray-500">Belum ada habit yang dicentang minggu lalu 🥲</p>
            @endif
        </div>

        {{-- TIME CAPSULE NOSTALGIA --}}
        @if($memory)
            <div class="bg-amber-50 dark:bg-amber-950/50 border border-amber-300 dark:border-amber-700 rounded-2xl p-4 mb-4">
                <p class="font-bold text-amber-600 dark:text-amber-400 text-sm mb-1">✨ Dari time capsule lu</p>
                <p class="text-sm text-gray-700 dark:text-gray-200 italic">"{{ $memory->note }}"</p>
                <p class="text-[10px] text-amber-500 mt-1">— ditulis {{ \Carbon\Carbon::parse($memory->checked_at)->translatedFormat('l, d M') }}</p>
            </div>
        @endif

        <a href="{{ route('dashboard') }}" class="block text-center text-sm font-bold text-indigo-600 dark:text-indigo-400">
            ← Balik ke dashboard
        </a>
    </div>
</x-app-layout>