<x-app-layout>
    <style>
        @keyframes pop-in { 0% { transform: scale(.9); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
        .pop-in { animation: pop-in .15s ease-out; }
    </style>

    {{-- HEADER CHAT --}}
    <div class="fixed top-14 inset-x-0 z-40 bg-white dark:bg-neutral-900 border-b border-gray-300 dark:border-neutral-800">
        <div class="max-w-2xl mx-auto px-3 py-2 flex items-center gap-2.5">
            <a href="{{ route('social.index') }}" class="w-8 h-8 rounded-full hover:bg-gray-100 dark:hover:bg-neutral-800 flex items-center justify-center text-gray-500 transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
            </a>
            <x-avatar :type="$partner->avatar" class="w-9 h-9" />
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-gray-900 dark:text-gray-100 truncate">{{ $partner->name }}</p>
                <p class="text-[11px] text-gray-400 flex items-center gap-1">
                    <svg class="w-3 h-3 text-yellow-500" fill="currentColor" viewBox="0 0 24 24"><path d="M13.5.67s.74 2.65.74 4.8c0 2.06-1.35 3.73-3.41 3.73-2.07 0-3.63-1.67-3.63-3.73l.03-.36C5.21 7.51 4 10.62 4 14c0 4.42 3.58 8 8 8s8-3.58 8-8C20 8.61 17.41 3.8 13.5.67z"/></svg>
                    streak bareng {{ $friendship->streak_count }} hari
                </p>
            </div>
            <div class="shrink-0 text-[10px] font-extrabold uppercase tracking-wide px-2.5 py-1 rounded-full
                {{ $friendship->last_mutual_date?->toDateString() === today()->toDateString()
                    ? 'bg-yellow-100 dark:bg-yellow-950/50 text-yellow-700 dark:text-yellow-400'
                    : 'bg-red-50 dark:bg-red-950/50 text-red-500' }}">
                {{ $friendship->last_mutual_date?->toDateString() === today()->toDateString() ? 'Aman' : 'Bahaya' }}
            </div>
        </div>
    </div>

    {{-- PERINGATAN --}}
    @if($friendship->last_mutual_date && $friendship->last_mutual_date->toDateString() !== today()->toDateString())
        <div class="fixed top-[112px] inset-x-0 z-30 px-3">
            <div class="max-w-2xl mx-auto bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-900 rounded-lg px-3 py-2 text-xs text-red-600 dark:text-red-400 text-center shadow-sm">
                Kalian belum saling chat hari ini — streak bakal hangus kalau besok juga kosong!
            </div>
        </div>
    @endif

    {{-- BUBBLE CHAT --}}
    <div class="max-w-2xl mx-auto px-3 pt-24 pb-28 space-y-1.5" id="chat-scroll">
        @forelse($messages as $message)
            @php
                $mine = $message->sender_id === auth()->id();
                $prev = $messages->get($loop->index - 1);
                $sameSenderAsPrev = $prev && $prev->sender_id === $message->sender_id;
            @endphp
            <div class="flex {{ $mine ? 'justify-end' : 'justify-start' }} {{ $sameSenderAsPrev ? '' : 'mt-3' }}">
                <div class="{{ $mine
                    ? 'bg-yellow-400 text-gray-900 ' . ($sameSenderAsPrev ? 'rounded-2xl' : 'rounded-2xl rounded-br-sm')
                    : 'bg-gray-200 dark:bg-neutral-800 text-gray-900 dark:text-gray-100 ' . ($sameSenderAsPrev ? 'rounded-2xl' : 'rounded-2xl rounded-bl-sm') }}
                    max-w-[75%] px-4 py-2.5 pop-in">
                    <p class="text-sm break-words whitespace-pre-wrap">{{ $message->body }}</p>
                    <p class="text-[10px] mt-1 {{ $mine ? 'text-gray-600/70' : 'text-gray-400' }} {{ $sameSenderAsPrev ? 'opacity-0 h-0' : '' }} text-right">
                        {{ $message->sent_at->format('H:i') }}
                    </p>
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <p class="text-3xl mb-2">💬</p>
                <p class="text-sm text-gray-400">Belum ada pesan — streak mulai dari sini</p>
            </div>
        @endforelse
    </div>

    {{-- INPUT --}}
    <div class="fixed bottom-0 inset-x-0 z-40 bg-white dark:bg-neutral-900 border-t border-gray-300 dark:border-neutral-800 md:mb-0 mb-14">
        <form action="{{ route('chat.store', $friendship) }}" method="POST" class="max-w-2xl mx-auto flex gap-2 px-3 py-2.5">
            @csrf
            <input type="text" name="body" placeholder="Ketik pesan..." required maxlength="1000" autocomplete="off"
                class="flex-1 bg-gray-100 dark:bg-neutral-800 dark:text-gray-100 dark:placeholder-gray-500 rounded-full px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-yellow-400">
            <button class="w-10 h-10 shrink-0 rounded-full bg-yellow-400 hover:bg-yellow-300 text-gray-900 flex items-center justify-center active:scale-90 transition" aria-label="Kirim">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" /></svg>
            </button>
        </form>
    </div>

    <script>
        window.addEventListener('load', () => {
            window.scrollTo(0, document.body.scrollHeight);
        });
    </script>
</x-app-layout>