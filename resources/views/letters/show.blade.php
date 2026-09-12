<x-app-layout>
    <div class="max-w-md mx-auto px-4 pt-6">
        @if(session('letterOpened'))
            <div class="text-center mb-4 animate-pop">
                <div class="text-6xl mb-2">💌</div>
                <p class="text-sm font-extrabold text-yellow-500 uppercase tracking-widest">Surat-mu terbuka!</p>
                <p class="text-xs text-gray-400 mt-1">Dari diri lu yang {{ $letter->written_at->translatedFormat('d M Y') }}...</p>
            </div>
        @endif

        <div class="bg-white dark:bg-neutral-900 border-2 border-yellow-400 dark:border-yellow-600 rounded-lg p-6 shadow-lg">
            <p class="text-[11px] font-bold uppercase tracking-wide text-gray-400 mb-3">
                Ditulis {{ $letter->written_at->translatedFormat('l, d F Y') }}
            </p>
            <p class="text-sm text-gray-800 dark:text-gray-200 whitespace-pre-wrap leading-relaxed">{{ $letter->body }}</p>
            <p class="text-[11px] text-gray-400 mt-4 pt-3 border-t border-gray-100 dark:border-neutral-800 italic">
                — diri lu di masa lalu, yang percaya lu bakal nyampe sini
            </p>
        </div>

        @if($letter->isLocked())
            <p class="text-center text-xs text-gray-400 mt-3">
                🔒 Terkunci — dibuka otomatis pas streak lu capai {{ $letter->unlock_at_streak }} hari (sekarang: {{ auth()->user()->current_streak }})
            </p>
        @endif

        <a href="{{ route('letters.index') }}" class="block text-center text-sm font-bold text-gray-600 dark:text-gray-300 border border-gray-300 dark:border-neutral-700 rounded-full py-3 mt-4 mb-4 hover:bg-yellow-400 hover:border-yellow-400 hover:text-gray-900 transition">
            ← Semua surat
        </a>
    </div>
</x-app-layout>