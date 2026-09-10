<x-app-layout>
    <div class="max-w-2xl mx-auto px-3 pt-4">

        {{-- ===== KARTU PROFIL ala u/username ===== --}}
        <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg mb-3 overflow-hidden">
            {{-- banner kuning --}}
            <div class="h-20 bg-yellow-400"></div>

            <div class="px-4 pb-4">
                <div class="flex items-end justify-between -mt-7 mb-2">
                    {{-- avatar besar ala reddit --}}
                    <div class="w-16 h-16 rounded-full bg-white dark:bg-neutral-900 border-4 border-white dark:border-neutral-900 overflow-hidden flex items-center justify-center">
                        <x-avatar :type="auth()->user()->avatar" class="w-14 h-14" />
                    </div>

                    <a href="{{ route('settings') }}"
                        class="text-xs font-bold text-gray-600 dark:text-gray-300 border border-gray-300 dark:border-neutral-700 rounded-full px-4 py-1.5 hover:bg-yellow-400 hover:border-yellow-400 hover:text-gray-900 transition">
                        Edit profil
                    </a>
                </div>

                <h1 class="text-xl font-extrabold text-gray-900 dark:text-gray-100">u/{{ strtolower(str_replace(' ', '', auth()->user()->name)) }}</h1>
                <p class="text-xs text-gray-400">{{ auth()->user()->email }}</p>

                @if(auth()->user()->title)
                    <span class="inline-flex items-center gap-1 bg-yellow-100 dark:bg-yellow-950/50 text-yellow-700 dark:text-yellow-400 text-[11px] font-bold px-2.5 py-1 rounded-full mt-2">
                        {{ auth()->user()->title->icon }} {{ auth()->user()->title->name }}
                    </span>
                @endif

                {{-- STATS ROW ala karma reddit --}}
                <div class="flex gap-6 mt-4 pt-3 border-t border-gray-100 dark:border-neutral-800">
                    <div>
                        <p class="text-base font-extrabold text-gray-900 dark:text-gray-100 leading-none">{{ auth()->user()->current_streak }}</p>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mt-1">Streak</p>
                    </div>
                    <div>
                        <p class="text-base font-extrabold text-gray-900 dark:text-gray-100 leading-none">{{ auth()->user()->longest_streak }}</p>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mt-1">Rekor</p>
                    </div>
                    <div>
                        <p class="text-base font-extrabold text-gray-900 dark:text-gray-100 leading-none">Lv.{{ auth()->user()->level }}</p>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mt-1">Level</p>
                    </div>
                    <div>
                        <p class="text-base font-extrabold text-yellow-500 leading-none">{{ auth()->user()->xp }}</p>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mt-1">Karma XP</p>
                    </div>
                    <div>
                        <p class="text-base font-extrabold text-gray-900 dark:text-gray-100 leading-none">{{ $habitsCount }}</p>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mt-1">Habit</p>
                    </div>
                </div>
                <a href="{{ route('graves.index') }}" class="flex items-center justify-between mt-4 pt-3 border-t border-gray-100 dark:border-neutral-800 text-sm">
                    <span class="text-gray-500 dark:text-gray-400">🪦 Makam streak</span>
                    <span class="text-gray-400">›</span>
                </a>
                
            </div>
        </div>
        
                {{-- ===== HEATMAP ala github ===== --}}
        <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg mb-3 overflow-hidden">
            <div class="flex items-center justify-between px-3 py-2.5 border-b border-gray-100 dark:border-neutral-800">
                <h2 class="text-xs font-bold uppercase tracking-wide text-gray-500">Aktivitas 15 minggu</h2>
                <span class="text-xs font-bold text-yellow-500">{{ $activeCount }} hari aktif</span>
            </div>

            <div class="p-3 overflow-x-auto">
                <div class="flex gap-[3px] w-max">
                    @for($w = 0; $w < 15; $w++)
                        <div class="flex flex-col gap-[3px]">
                            @for($d = 0; $d < 7; $d++)
                                @php
                                    $cellDate = now()->subDays((14 - $w) * 7 + (6 - $d));
                                    $active = $activeDays->has($cellDate->toDateString());
                                @endphp
                                <span title="{{ $cellDate->translatedFormat('d M Y') }}"
                                    class="w-3 h-3 rounded-[2px]
                                    {{ $cellDate->isFuture() ? 'bg-transparent' : ($active ? 'bg-yellow-400' : 'bg-gray-200 dark:bg-neutral-800') }}">
                                </span>
                            @endfor
                        </div>
                    @endfor
                </div>

                {{-- legend --}}
                <div class="flex items-center gap-1.5 mt-2.5 text-[10px] text-gray-400">
                    <span>Kurang</span>
                    <span class="w-3 h-3 rounded-[2px] bg-gray-200 dark:bg-neutral-800"></span>
                    <span class="w-3 h-3 rounded-[2px] bg-yellow-200"></span>
                    <span class="w-3 h-3 rounded-[2px] bg-yellow-400"></span>
                    <span class="w-3 h-3 rounded-[2px] bg-yellow-500"></span>
                    <span>Rajin</span>
                </div>
            </div>
        </div>

        {{-- ===== KOLEKSI BADGE ala "awards" ===== --}}

        {{-- ===== KOLEKSI BADGE ala "awards" ===== --}}
        <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg mb-3 overflow-hidden">
            <div class="flex items-center justify-between px-3 py-2.5 border-b border-gray-100 dark:border-neutral-800">
                <h2 class="text-xs font-bold uppercase tracking-wide text-gray-500">Badge koleksi</h2>
                <span class="text-xs font-bold text-gray-400">{{ count($earnedIds) }}/{{ $badges->count() }}</span>
            </div>

            <div class="grid grid-cols-3 gap-2 p-3">
                @foreach($badges as $badge)
                    @php $earned = in_array($badge->id, $earnedIds); @endphp
                    <div class="rounded-lg p-3 text-center {{ $earned ? 'border border-yellow-300 dark:border-yellow-800 bg-yellow-50/50 dark:bg-yellow-950/20' : 'border border-gray-100 dark:border-neutral-800 opacity-50' }}">
                        <div class="text-2xl {{ $earned ? '' : 'grayscale' }}">{{ $badge->icon }}</div>
                        <p class="text-[10px] font-bold text-gray-700 dark:text-gray-300 mt-1 leading-tight">{{ $badge->name }}</p>
                        @if($earned && auth()->user()->badge_id === $badge->id)
                            <span class="text-[9px] font-extrabold text-yellow-600 dark:text-yellow-400">● DIPAKAI</span>
                        @elseif(!$earned)
                            <span class="text-[9px] text-gray-400">🔒 {{ $badge->required_streak }} hari</span>
                        @endif
                    </div>
                @endforeach
            </div>

            <a href="{{ route('badges.index') }}" class="block text-center text-xs font-bold text-gray-600 dark:text-gray-300 border-t border-gray-100 dark:border-neutral-800 py-2.5 hover:bg-gray-50 dark:hover:bg-neutral-800 transition">
                Kelola gelar ➜
            </a>
        </div>

        <div class="pb-4"></div>
    </div>
</x-app-layout>