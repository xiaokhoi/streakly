<x-app-layout>
    <div class="max-w-2xl mx-auto px-3 pt-4">

        <h1 class="text-lg font-extrabold text-gray-900 dark:text-gray-100">Recap Mingguan</h1>
        <p class="text-xs text-gray-400 mb-3">{{ $start->format('d M') }} – {{ $end->format('d M Y') }}</p>

        {{-- ===== ANGKA UTAMA ===== --}}
        <div class="bg-white dark:bg-neutral-900 border-2 border-yellow-400 dark:border-yellow-600 rounded-lg p-8 text-center mb-3">
            <p class="text-[11px] font-extrabold text-yellow-500 uppercase tracking-widest mb-2">Hari aktif minggu lalu</p>
            <p class="text-6xl font-extrabold text-gray-900 dark:text-gray-100 leading-none">
                {{ $checkinDays }}<span class="text-2xl text-gray-300 dark:text-gray-600">/7</span>
            </p>
            <p class="mt-4 inline-block bg-yellow-100 dark:bg-yellow-950/50 text-yellow-700 dark:text-yellow-400 rounded-full px-4 py-1.5 text-sm font-bold">
                @if($checkinDays >= 6) 🔥 Gila, hampir sempurna!
                @elseif($checkinDays >= 3) 💪 Konsisten, gas terus!
                @elseif($checkinDays >= 1) 🌱 Awal yang bagus!
                @else 😅 Minggu lalu sepi... mulai lagi!
                @endif
            </p>
        </div>

        {{-- ===== XP ===== --}}
        <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-3.5 mb-3 flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-gray-900 dark:text-gray-100">XP minggu lalu</p>
                <p class="text-xs text-gray-400">Hasil jerih payah 7 hari</p>
            </div>
            <p class="text-2xl font-extrabold text-yellow-500">+{{ $weeklyXp }}</p>
        </div>

        {{-- ===== HABIT JUARA ===== --}}
        <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-3.5 mb-3">
            <p class="text-[11px] font-bold uppercase tracking-wide text-gray-400 mb-1">Habit juara</p>
            @if($topHabit)
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Paling sering: <span class="font-extrabold text-gray-900 dark:text-gray-100">{{ $topHabit->name }}</span>
                    <span class="text-gray-400">({{ $topHabit->total }}x)</span>
                </p>
            @else
                <p class="text-sm text-gray-400">Belum ada habit yang dicentang minggu lalu 🥲</p>
            @endif
        </div>

        {{-- ===== TIME CAPSULE ===== --}}
        @if($memory)
            <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-3.5 mb-3">
                <p class="text-[11px] font-bold uppercase tracking-wide text-yellow-500 mb-1">✨ Dari time capsule lu</p>
                <p class="text-sm text-gray-700 dark:text-gray-200 italic">"{{ $memory->note }}"</p>
                <p class="text-[10px] text-gray-400 mt-1">— ditulis {{ \Carbon\Carbon::parse($memory->checked_at)->translatedFormat('l, d M') }}</p>
            </div>
        @endif

        <a href="{{ route('dashboard') }}" class="block text-center text-sm font-bold text-gray-600 dark:text-gray-300 border border-gray-300 dark:border-neutral-700 rounded-full py-3 hover:bg-yellow-400 hover:border-yellow-400 hover:text-gray-900 transition">
            ← Balik ke dashboard
        </a>

        <div class="pb-4"></div>
    </div>
</x-app-layout>