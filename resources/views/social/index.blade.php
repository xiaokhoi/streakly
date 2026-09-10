<x-app-layout>
    <div class="max-w-2xl mx-auto px-3 pt-4">

        <h1 class="text-lg font-extrabold text-gray-900 dark:text-gray-100 mb-3">Chat</h1>

        {{-- BANNER --}}
        @if(session('requestSent'))
            <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-3 mb-3 text-sm flex items-center gap-2">
                <svg class="w-5 h-5 text-yellow-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                Permintaan terkirim! Tunggu doi accept.
            </div>
        @endif
        @if(session('alreadyFriend'))
            <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-3 mb-3 text-sm flex items-center gap-2">
                <svg class="w-5 h-5 text-yellow-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" /></svg>
                Lu udah terhubung sama orang ini
            </div>
        @endif

        {{-- ===== PERMINTAAN MASUK ===== --}}
        @if($pendings->count())
            <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg mb-3 overflow-hidden">
                <div class="px-3 py-2.5 border-b border-gray-100 dark:border-neutral-800">
                    <h2 class="text-xs font-bold uppercase tracking-wide text-gray-500">Permintaan pertemanan ({{ $pendings->count() }})</h2>
                </div>
                @foreach($pendings as $pending)
                    <div class="flex items-center gap-3 px-3 py-3 border-b border-gray-50 dark:border-neutral-800 last:border-0">
                        <x-avatar :type="$pending->requester->avatar" class="w-10 h-10 shrink-0" />
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-gray-900 dark:text-gray-100 truncate">{{ $pending->requester->name }}</p>
                            <p class="text-xs text-gray-400">mau jadi streak partner lu</p>
                        </div>
                        <div class="flex gap-1.5 shrink-0">
                            <form action="{{ route('social.accept', $pending) }}" method="POST">
                                @csrf
                                <button class="bg-yellow-400 hover:bg-yellow-300 text-gray-900 text-xs font-bold px-4 py-1.5 rounded-full active:scale-95 transition">Terima</button>
                            </form>
                            <form action="{{ route('social.reject', $pending) }}" method="POST">
                                @csrf
                                <button class="text-xs font-bold text-gray-500 border border-gray-300 dark:border-neutral-700 rounded-full px-4 py-1.5 hover:bg-gray-100 dark:hover:bg-neutral-800 active:scale-95 transition">Tolak</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- ===== CARI TEMEN ===== --}}
        <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-3 mb-3">
            <h2 class="text-xs font-bold uppercase tracking-wide text-gray-500 mb-2.5">Cari streak partner</h2>
            <form action="{{ route('social.search') }}" method="GET" class="flex gap-2">
                <input type="text" name="q" value="{{ $searched ?? '' }}" placeholder="Nama atau email temen lu..." required minlength="3"
                    class="flex-1 bg-gray-100 dark:bg-neutral-800 dark:text-gray-100 dark:placeholder-gray-500 rounded-full px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-yellow-400">
                <button class="bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-bold text-sm px-5 rounded-full active:scale-95 transition">Cari</button>
            </form>

            @isset($results)
                <div class="mt-3 space-y-2">
                    @forelse($results as $result)
                        <div class="flex items-center gap-2.5 bg-gray-50 dark:bg-neutral-800 rounded-lg p-2.5">
                            <x-avatar :type="$result->avatar" class="w-9 h-9 shrink-0" />
                            <span class="text-sm font-bold text-gray-900 dark:text-gray-100 flex-1 min-w-0 truncate">{{ $result->name }}</span>
                            <form action="{{ route('social.store') }}" method="POST" class="flex items-center gap-1.5 shrink-0">
                                @csrf
                                <input type="hidden" name="friend_id" value="{{ $result->id }}">
                                <select name="type" class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-700 dark:text-gray-100 text-xs rounded-full py-1.5 px-2">
                                    @foreach($types as $typeKey => $typeIcon)
                                        <option value="{{ $typeKey }}">{{ $typeIcon }} {{ ucfirst($typeKey) }}</option>
                                    @endforeach
                                </select>
                                <button class="bg-yellow-400 hover:bg-yellow-300 text-gray-900 text-xs font-bold px-3.5 py-1.5 rounded-full active:scale-95 transition">Ajak</button>
                            </form>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400 text-center py-2">Gak ketemu — pastiin ejaannya bener</p>
                    @endforelse
                </div>
            @endisset
        </div>

        {{-- ===== INBOX: STREAK BARENG ===== --}}
        <h2 class="text-xs font-bold uppercase tracking-wide text-gray-500 px-1 mb-2">Streak bareng</h2>

        <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg overflow-hidden">
            @forelse($friendships as $friendship)
                @php
                    $partner = $friendship->user_id === auth()->id() ? $friendship->partner : $friendship->requester;
                    $mutualToday = $friendship->last_mutual_date?->toDateString() === today()->toDateString();
                    $last = $friendship->lastMessage;
                @endphp
                <a href="{{ route('chat.show', $friendship) }}"
                    class="flex items-center gap-3 px-3 py-3 border-b border-gray-50 dark:border-neutral-800 last:border-0 hover:bg-gray-50 dark:hover:bg-neutral-800/50 transition">
                    <div class="relative shrink-0">
                        <x-avatar :type="$partner->avatar" class="w-12 h-12" />
                        @if(!$mutualToday && $friendship->streak_count > 0)
                            <span class="absolute -top-0.5 -right-0.5 w-3 h-3 bg-red-500 border-2 border-white dark:border-neutral-900 rounded-full"></span>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-1.5">
                            <p class="text-sm font-bold text-gray-900 dark:text-gray-100 truncate">{{ $partner->name }}</p>
                            <span class="text-[10px] text-gray-400">{{ $types[$friendship->type] }}</span>
                        </div>
                        @if($last)
                            <p class="text-xs text-gray-400 truncate">
                                {{ $last->sender_id === auth()->id() ? 'Lu: ' : '' }}{{ $last->body }}
                            </p>
                        @else
                            <p class="text-xs text-gray-400">Belum ada chat — mulai sekarang</p>
                        @endif
                    </div>
                    <div class="text-right shrink-0">
                        <div class="flex items-center gap-1 justify-end">
                            <svg class="w-3.5 h-3.5 text-yellow-500" fill="currentColor" viewBox="0 0 24 24"><path d="M13.5.67s.74 2.65.74 4.8c0 2.06-1.35 3.73-3.41 3.73-2.07 0-3.63-1.67-3.63-3.73l.03-.36C5.21 7.51 4 10.62 4 14c0 4.42 3.58 8 8 8s8-3.58 8-8C20 8.61 17.41 3.8 13.5.67z"/></svg>
                            <span class="text-sm font-extrabold text-gray-900 dark:text-gray-100">{{ $friendship->streak_count }}</span>
                        </div>
                        @if($mutualToday)
                            <p class="text-[10px] font-bold text-yellow-600 dark:text-yellow-400 mt-0.5">✓ aman</p>
                        @else
                            <p class="text-[10px] font-bold text-red-500 mt-0.5">⚠️ bahaya</p>
                        @endif
                    </div>
                </a>
            @empty
                <div class="p-8 text-center">
                    <p class="text-3xl mb-2">👋</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-bold">Belum ada streak partner</p>
                    <p class="text-xs text-gray-400 mt-1">Cari di atas, ajak temen lu saing streak!</p>
                </div>
            @endforelse
        </div>

        <div class="pb-4"></div>
    </div>
</x-app-layout>