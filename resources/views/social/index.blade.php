<x-app-layout>
    <div class="py-6 max-w-md mx-auto px-4">
        <h1 class="text-xl font-extrabold text-gray-800 dark:text-gray-100 mb-1">💬 Sosial</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Chat bareng temen tiap hari = streak bareng nyala 🔥</p>

        {{-- BANNER --}}
        @if(session('requestSent'))
            <div class="bg-green-50 dark:bg-green-950/50 border border-green-300 dark:border-green-700 rounded-xl p-3 mb-4 text-sm text-green-700 dark:text-green-400 text-center animate-pop">
                🎯 Permintaan terkirim! Tunggu doi accept.
            </div>
        @endif
        @if(session('alreadyFriend'))
            <div class="bg-amber-50 dark:bg-amber-950/50 border border-amber-300 dark:border-amber-700 rounded-xl p-3 mb-4 text-sm text-amber-700 dark:text-amber-400 text-center animate-pop">
                ⚠️ Lu udah terhubung sama orang ini.
            </div>
        @endif

        {{-- PERMINTAAN MASUK --}}
        @if($pendings->count())
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-4 mb-4">
                <h2 class="font-bold text-gray-700 dark:text-gray-200 text-sm mb-3">📨 Permintaan pertemanan ({{ $pendings->count() }})</h2>
                @foreach($pendings as $pending)
                    <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700 last:border-0">
                        <span class="text-sm text-gray-700 dark:text-gray-200 font-semibold">{{ $pending->requester->name }}</span>
                        <div class="flex gap-2">
                            <form action="{{ route('social.accept', $pending) }}" method="POST">
                                @csrf
                                <button class="bg-green-500 hover:bg-green-600 text-white text-xs font-bold px-4 py-1.5 rounded-full active:scale-95 transition">Terima</button>
                            </form>
                            <form action="{{ route('social.reject', $pending) }}" method="POST">
                                @csrf
                                <button class="bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-xs font-bold px-4 py-1.5 rounded-full active:scale-95 transition">Tolak</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- CARI TEMEN --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-4 mb-4">
            <h2 class="font-bold text-gray-700 dark:text-gray-200 text-sm mb-3">🔍 Cari temen (nama / email)</h2>
            <form action="{{ route('social.search') }}" method="GET" class="flex gap-2">
                <input type="text" name="q" value="{{ $searched ?? '' }}" placeholder="Misal: rifky" required minlength="3"
                    class="flex-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-500 px-3 py-2 text-sm">
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-4 rounded-lg active:scale-95 transition">Cari</button>
            </form>

            @isset($results)
                <div class="mt-3 space-y-2">
                    @forelse($results as $result)
                        <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-900 rounded-xl p-2">
                            <div class="flex items-center gap-2">
                                <x-avatar :type="$result->avatar" class="w-8 h-8" />
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ $result->name }}</span>
                            </div>
                            <form action="{{ route('social.store') }}" method="POST" class="flex items-center gap-1">
                                @csrf
                                <input type="hidden" name="friend_id" value="{{ $result->id }}">
                                <select name="type" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 text-xs py-1">
                                    @foreach($types as $typeKey => $typeIcon)
                                        <option value="{{ $typeKey }}">{{ $typeIcon }} {{ ucfirst($typeKey) }}</option>
                                    @endforeach
                                </select>
                                <button class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-3 py-1.5 rounded-full active:scale-95 transition">Ajak</button>
                            </form>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400 dark:text-gray-500 text-center py-2">Gak ketemu. Pastiin ejaannya bener 🤷</p>
                    @endforelse
                </div>
            @endisset
        </div>

        {{-- DAFTAR TEMEN + STREAK BARENG --}}
        <div class="space-y-2">
            <h2 class="font-bold text-gray-700 dark:text-gray-200 text-sm">🔥 Streak bareng</h2>

                        @forelse($friendships as $friendship)
                @php
                    $partner = $friendship->user_id === auth()->id() ? $friendship->partner : $friendship->requester;
                    // ⚠️ FIX: last_mutual_date = objek Carbon, WAJIB ke string dulu
                    $mutualToday = $friendship->last_mutual_date?->toDateString() === today()->toDateString();
                    $last = $friendship->lastMessage; // null kalau belum pernah chat
                @endphp
                <a href="{{ route('chat.show', $friendship) }}"
                    class="block bg-white dark:bg-gray-800 rounded-2xl shadow p-4 active:scale-[0.98] transition">
                    <div class="flex items-center gap-3">
                        <div class="relative shrink-0">
                            <x-avatar :type="$partner->avatar" class="w-12 h-12" />
                            @if(!$mutualToday)
                                <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-amber-400 border-2 border-white dark:border-gray-800 rounded-full"></span>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-gray-800 dark:text-gray-100 truncate">
                                {{ $types[$friendship->type] }} {{ $partner->name }}
                            </p>
                            @if($last)
                                <p class="text-xs text-gray-400 dark:text-gray-500 truncate">
                                    {{ $last->sender_id === auth()->id() ? 'Lu: ' : $last->sender->name . ': ' }}
                                    <span class="{{ $mutualToday ? 'text-gray-500 dark:text-gray-400' : 'font-bold text-gray-600 dark:text-gray-300' }}">
                                        {{ $last->body }}
                                    </span>
                                </p>
                            @else
                                <p class="text-xs text-gray-400 dark:text-gray-500">Belum ada chat. Mulai sekarang! 👋</p>
                            @endif
                            <p class="text-xs mt-0.5 {{ $mutualToday ? 'text-green-600 dark:text-green-400 font-bold' : 'text-amber-500 font-semibold' }}">
                                {{ $mutualToday ? '✓ Udah saling chat hari ini' : '⏳ Belum saling chat hari ini' }}
                            </p>
                        </div>
                        <div class="text-right shrink-0">
                            <p class="text-2xl font-extrabold {{ $friendship->streak_count > 0 ? 'text-orange-500' : 'text-gray-300 dark:text-gray-600' }}">
                                🔥 {{ $friendship->streak_count }}
                            </p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 text-center">
                    <p class="text-4xl mb-2">👥</p>
                    <p class="text-sm text-gray-400 dark:text-gray-500">Belum ada temen. Cari di atas, ajak temen lu saing streak! 😄</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>