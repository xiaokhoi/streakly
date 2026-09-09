<x-app-layout>
    <div class="py-6 max-w-md mx-auto px-4">
        <h1 class="text-xl font-extrabold text-gray-800 dark:text-gray-100 mb-1">🏆 Leaderboard</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Perebutan XP minggu ini</p>
        <p class="text-xs text-gray-400 dark:text-gray-500 mb-4">
            ⏳ Reset otomatis tiap Senin · {{ $total }} orang ikut bertarung minggu ini
        </p>

        {{-- KARTU POSISI LU SENDIRI --}}
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-4 mb-4 shadow-lg text-white flex items-center justify-between">
            <div>
                <p class="text-xs opacity-80">Posisi lu minggu ini</p>
                <p class="text-2xl font-extrabold">
                    {{ $myPosition !== false ? '#'.($myPosition + 1) : 'Belum bertarung' }}
                </p>
            </div>
            <div class="text-right">
                <p class="text-xs opacity-80">XP minggu ini</p>
                <p class="text-xl font-bold">{{ $myXp }} ⚡</p>
            </div>
        </div>

        {{-- TOP 10 --}}
        <div class="space-y-2">
            @forelse($top as $i => $user)
                @php
                    $isMe = $user->id === auth()->id();
                    $medal = match($i) { 0 => '🥇', 1 => '🥈', 2 => '🥉', default => null };
                @endphp
                <div class="rounded-2xl p-3 flex items-center gap-3 shadow
                    {{ $isMe
                        ? 'bg-indigo-100 dark:bg-indigo-950 border-2 border-indigo-400 dark:border-indigo-600'
                        : 'bg-white dark:bg-gray-800' }}">
                    <span class="w-8 text-center font-extrabold text-gray-500 dark:text-gray-400">
                        {{ $medal ?? ($i + 1) }}
                    </span>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-gray-800 dark:text-gray-100 truncate {{ $isMe ? 'text-indigo-700 dark:text-indigo-300' : '' }}">
                            {{ $isMe ? $user->name . ' (lu)' : $user->name }}
                        </p>
                        <p class="text-xs text-gray-400 dark:text-gray-500">
                            Lv.{{ $user->level }}
                            @if($user->title)
                                · {{ $user->title->icon }} {{ $user->title->name }}
                            @endif
                        </p>
                    </div>
                    <span class="font-extrabold text-indigo-600 dark:text-indigo-400">{{ $user->weekly_xp }} ⚡</span>
                </div>
            @empty
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 text-center">
                    <p class="text-gray-400 dark:text-gray-500 text-sm">Belum ada yang dapet XP minggu ini 😴</p>
                    <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">Check-in dulu, jadi juara pertama!</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>