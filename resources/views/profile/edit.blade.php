<x-app-layout>
    <div class="py-6 max-w-md mx-auto px-4">

        {{-- HEADER PROFIL --}}
        <div class="bg-gradient-to-b from-indigo-500 to-purple-600 rounded-3xl p-6 text-center shadow-lg mb-4">
            <div class="inline-block bg-white/20 rounded-full p-2">
                <x-avatar :type="auth()->user()->avatar" class="w-20 h-20" />
            </div>
            <h1 class="text-xl font-extrabold text-white mt-3">{{ auth()->user()->name }}</h1>
            <p class="text-xs text-white/70">{{ auth()->user()->email }}</p>
            @if(auth()->user()->title)
                <span class="inline-flex items-center gap-1 bg-white/20 text-white text-xs font-bold px-3 py-1 rounded-full mt-2">
                    {{ auth()->user()->title->icon }} {{ auth()->user()->title->name }}
                </span>
            @endif
        </div>

        {{-- STATISTIK --}}
        <div class="grid grid-cols-4 gap-2 mb-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl p-3 text-center shadow">
                <p class="text-lg font-extrabold text-orange-500">🔥 {{ auth()->user()->current_streak }}</p>
                <p class="text-[10px] text-gray-400 dark:text-gray-500">Streak</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl p-3 text-center shadow">
                <p class="text-lg font-extrabold text-indigo-500">Lv.{{ auth()->user()->level }}</p>
                <p class="text-[10px] text-gray-400 dark:text-gray-500">Level</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl p-3 text-center shadow">
                <p class="text-lg font-extrabold text-purple-500">{{ auth()->user()->xp }}</p>
                <p class="text-[10px] text-gray-400 dark:text-gray-500">Total XP</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl p-3 text-center shadow">
                <p class="text-lg font-extrabold text-green-500">{{ $habitsCount }}</p>
                <p class="text-[10px] text-gray-400 dark:text-gray-500">Habit</p>
            </div>
        </div>

        {{-- KOLEKSI BADGE --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-4 mb-4">
            <div class="flex items-center justify-between mb-3">
                <h2 class="font-bold text-gray-700 dark:text-gray-200">🏅 Koleksi Badge</h2>
                <span class="text-xs font-bold text-indigo-500">{{ count($earnedIds) }}/{{ $badges->count() }}</span>
            </div>

            <div class="grid grid-cols-3 gap-2">
                @foreach($badges as $badge)
                    @php $earned = in_array($badge->id, $earnedIds); @endphp
                    <div class="rounded-xl p-3 text-center
                        {{ $earned ? 'bg-amber-50 dark:bg-amber-950/30' : 'bg-gray-100 dark:bg-gray-900 opacity-50' }}">
                        <div class="text-2xl {{ $earned ? '' : 'grayscale' }}">{{ $badge->icon }}</div>
                        <p class="text-[10px] font-bold text-gray-600 dark:text-gray-300 mt-1 leading-tight">{{ $badge->name }}</p>
                        @if($earned && auth()->user()->badge_id === $badge->id)
                            <span class="text-[9px] font-bold text-indigo-500">● dipakai</span>
                        @elseif(!$earned)
                            <span class="text-[9px] text-gray-400 dark:text-gray-600">🔒 {{ $badge->required_streak }} hari</span>
                        @endif
                    </div>
                @endforeach
            </div>

            <a href="{{ route('badges.index') }}" class="block text-center text-xs font-bold text-indigo-600 dark:text-indigo-400 mt-3">
                Kelola gelar ➜
            </a>
        </div>

        {{-- ARAH KE PENGATURAN --}}
        <a href="{{ route('settings') }}"
            class="bg-white dark:bg-gray-800 rounded-2xl shadow p-4 mb-4 flex items-center justify-between active:scale-[0.98] transition">
            <span class="text-sm font-bold text-gray-700 dark:text-gray-200">⚙️ Pengaturan</span>
            <span class="text-xs text-gray-400">edit avatar, nama, password</span>
            <span class="text-gray-300 dark:text-gray-600">›</span>
        </a>

        <div class="h-4"></div>
    </div>
</x-app-layout>