<x-app-layout>
    <div class="max-w-2xl mx-auto px-3 pt-4">

        <h1 class="text-lg font-extrabold text-gray-900 dark:text-gray-100 mb-1">Papan Peringkat</h1>
        <p class="text-xs text-gray-400 mb-3">XP minggu ini · reset tiap Senin · {{ $total }} orang ikut bertarung</p>

        {{-- POSISI LU --}}
        <div class="bg-white dark:bg-neutral-900 border border-yellow-400 dark:border-yellow-600 rounded-lg p-3.5 mb-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-yellow-400 flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-900" fill="currentColor" viewBox="0 0 24 24"><path d="M13.5.67s.74 2.65.74 4.8c0 2.06-1.35 3.73-3.41 3.73-2.07 0-3.63-1.67-3.63-3.73l.03-.36C5.21 7.51 4 10.62 4 14c0 4.42 3.58 8 8 8s8-3.58 8-8C20 8.61 17.41 3.8 13.5.67z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wide text-gray-400">Posisi lu</p>
                    <p class="text-xl font-extrabold text-gray-900 dark:text-gray-100 leading-none">
                        {{ $myPosition !== false ? '#'.($myPosition + 1) : '—' }}
                    </p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-[10px] font-bold uppercase tracking-wide text-gray-400">XP minggu ini</p>
                <p class="text-xl font-extrabold text-yellow-500 leading-none">+{{ $myXp }}</p>
            </div>
        </div>

        {{-- TOP 10 --}}
        <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg overflow-hidden">
            <div class="px-3 py-2.5 border-b border-gray-100 dark:border-neutral-800">
                <h2 class="text-xs font-bold uppercase tracking-wide text-gray-500">Top 10 minggu ini</h2>
            </div>

            @forelse($top as $i => $user)
                @php
                    $isMe = $user->id === auth()->id();
                    if ($i === 0) { $medal = '🥇'; }
                    elseif ($i === 1) { $medal = '🥈'; }
                    elseif ($i === 2) { $medal = '🥉'; }
                    else { $medal = null; }
                @endphp
                <div class="flex items-center gap-3 px-3 py-3 border-b border-gray-50 dark:border-neutral-800 last:border-0 {{ $isMe ? 'bg-yellow-50/70 dark:bg-yellow-950/20' : '' }}">
                    <span class="w-7 text-center text-sm font-extrabold {{ $medal ? '' : 'text-gray-300 dark:text-gray-600' }}">
                        {{ $medal ?? ($i + 1) }}
                    </span>
                    <x-avatar :type="$user->avatar" class="w-9 h-9 shrink-0" />
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold truncate {{ $isMe ? 'text-yellow-600 dark:text-yellow-400' : 'text-gray-900 dark:text-gray-100' }}">
                            {{ $isMe ? $user->name . ' (lu)' : $user->name }}
                        </p>
                        <p class="text-[11px] text-gray-400">
                            Lv.{{ $user->level }}
                            @if($user->title)
                                · {{ $user->title->icon }} {{ $user->title->name }}
                            @endif
                        </p>
                    </div>
                    <span class="text-sm font-extrabold text-yellow-500 shrink-0">+{{ $user->weekly_xp }}</span>
                </div>
            @empty
                <div class="p-8 text-center">
                    <p class="text-sm text-gray-400 font-bold">Belum ada yang dapet XP minggu ini</p>
                    <p class="text-xs text-gray-400 mt-1">Check-in dulu, jadi #1!</p>
                </div>
            @endforelse
        </div>

        <div class="pb-4"></div>
    </div>
</x-app-layout>