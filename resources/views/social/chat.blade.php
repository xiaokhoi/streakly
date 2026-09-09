<x-app-layout>
    <style>
        @keyframes pop-in { 0% { transform: scale(.9); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
        .pop-in { animation: pop-in .15s ease-out; }
    </style>

    {{-- HEADER CHAT: FIXED paling atas --}}
    <div class="fixed top-0 inset-x-0 z-40 bg-gray-100 dark:bg-gray-950 border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-md mx-auto px-4 py-2.5 flex items-center gap-3">
            <a href="{{ route('social.index') }}" class="text-2xl text-gray-400">←</a>
            <x-avatar :type="$partner->avatar" class="w-10 h-10" />
            <div class="flex-1 min-w-0">
                <p class="font-bold text-gray-800 dark:text-gray-100 truncate">
                    {{ $types[$friendship->type] }} {{ $partner->name }}
                </p>
                <p class="text-xs text-orange-500 font-bold">🔥 Streak bareng: {{ $friendship->streak_count }} hari</p>
            </div>
            <div class="shrink-0 px-3 py-1.5 rounded-full text-xs font-bold
                {{ $friendship->last_mutual_date?->toDateString() === today()->toDateString()
                    ? 'bg-green-100 dark:bg-green-900/60 text-green-600 dark:text-green-400'
                    : 'bg-amber-100 dark:bg-amber-900/60 text-amber-600 dark:text-amber-400' }}">
                {{ $friendship->last_mutual_date?->toDateString() === today()->toDateString() ? '✓ Aman' : '⚠️ Bahaya' }}
            </div>
        </div>
    </div>

    {{-- PERINGATAN STREAK: nempel di bawah header --}}
    @if($friendship->last_mutual_date && $friendship->last_mutual_date->toDateString() !== today()->toDateString())
        <div class="fixed top-[68px] inset-x-0 z-30 px-4">
            <div class="max-w-md mx-auto bg-red-50 dark:bg-red-950/50 border border-red-300 dark:border-red-700 rounded-xl p-3 text-sm text-red-600 dark:text-red-400 text-center shadow">
                ⚠️ Belum saling chat HARI INI — streak bakal hangus kalau besok juga gak chat! 😱
            </div>
        </div>
    @endif

    {{-- BUBBLE CHAT --}}
    <div class="max-w-md mx-auto px-4 pt-24 pb-32 space-y-1.5" id="chat-scroll">
        @forelse($messages as $message)
            @php
                $mine = $message->sender_id === auth()->id();
                $prev = $messages->get($loop->index - 1);
                $sameSenderAsPrev = $prev && $prev->sender_id === $message->sender_id;
            @endphp
            <div class="flex {{ $mine ? 'justify-end' : 'justify-start' }} {{ $sameSenderAsPrev ? '' : 'mt-3' }}">
                <div class="{{ $mine
                    ? 'bg-indigo-600 text-white ' . ($sameSenderAsPrev ? 'rounded-2xl' : 'rounded-2xl rounded-tr-sm')
                    : 'bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 shadow ' . ($sameSenderAsPrev ? 'rounded-2xl' : 'rounded-2xl rounded-tl-sm') }}
                    max-w-[75%] px-4 py-2.5 pop-in">
                    <p class="text-sm break-words whitespace-pre-wrap">{{ $message->body }}</p>
                    <p class="text-[10px] mt-1 {{ $mine ? 'text-white/60' : 'text-gray-400 dark:text-gray-500' }} {{ $sameSenderAsPrev ? 'opacity-0 h-0' : '' }} text-right">
                        {{ $message->sent_at->format('H:i') }}
                    </p>
                </div>
            </div>
        @empty
            <div class="text-center py-10">
                <p class="text-4xl mb-2">👋</p>
                <p class="text-sm text-gray-400 dark:text-gray-500">Belum ada pesan. Sapa dia dulu — streak mulai dari sini!</p>
            </div>
        @endforelse
    </div>

    {{-- INPUT KIRIM: fixed, di atas bottom nav --}}
    <div class="fixed bottom-[72px] inset-x-0 px-4 py-2 bg-gray-100 dark:bg-gray-950 border-t border-gray-200 dark:border-gray-800">
        <form action="{{ route('chat.store', $friendship) }}" method="POST" class="flex gap-2 max-w-md mx-auto">
            @csrf
            <input type="text" name="body" placeholder="Ketik pesan..." required maxlength="1000"
                class="flex-1 rounded-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 dark:placeholder-gray-500 px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-400">
            <button class="w-12 h-12 shrink-0 rounded-full bg-indigo-600 hover:bg-indigo-700 text-white shadow-lg flex items-center justify-center active:scale-90 transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                </svg>
            </button>
        </form>
    </div>

    <script>
        window.addEventListener('load', () => {
            window.scrollTo(0, document.body.scrollHeight);
        });
    </script>
</x-app-layout>