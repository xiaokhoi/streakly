<x-app-layout>
    <div class="max-w-2xl mx-auto px-3 pt-4">

        <h1 class="text-lg font-extrabold text-gray-900 dark:text-gray-100 mb-1">🪦 Makam Streak</h1>
        <p class="text-xs text-gray-400 mb-3">Mereka pernah menyala. Sekarang istirahat. Rekor lu: {{ $longest }} hari</p>

        <div class="space-y-2">
            @forelse($graves as $grave)
                <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-4 flex items-center gap-3">
                    <div class="text-3xl shrink-0">🪦</div>
                    <div class="flex-1 min-w-0">
                        <p class="font-extrabold text-gray-900 dark:text-gray-100 text-sm">
                            Streak {{ $grave->length }} hari
                        </p>
                        <p class="text-xs text-gray-400 italic">"{{ $grave->epitaph() }}"</p>
                        <p class="text-[10px] text-gray-400 mt-0.5">
                            Gugur {{ $grave->died_at->translatedFormat('d M Y') }}
                        </p>
                    </div>
                    @if($grave->length >= 30)
                        <span class="text-[10px] font-extrabold text-yellow-600 dark:text-yellow-400 bg-yellow-100 dark:bg-yellow-950/50 rounded-full px-2.5 py-1 shrink-0">
                            LEGENDA
                        </span>
                    @elseif($grave->length >= 7)
                        <span class="text-[10px] font-extrabold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-neutral-800 rounded-full px-2.5 py-1 shrink-0">
                            TERHORMAT
                        </span>
                    @endif
                </div>
            @empty
                <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-8 text-center">
                    <p class="text-4xl mb-2">🌱</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-bold">Makam masih kosong</p>
                    <p class="text-xs text-gray-400 mt-1">Selamat — streak lu belum pernah mati. Jaga terus (atau gak usah, biar makamnya ada isi 😄)</p>
                </div>
            @endforelse
        </div>

        <a href="{{ route('profile.edit') }}" class="block text-center text-sm font-bold text-gray-600 dark:text-gray-300 border border-gray-300 dark:border-neutral-700 rounded-full py-3 mt-4 mb-4 hover:bg-yellow-400 hover:border-yellow-400 hover:text-gray-900 transition">
            ← Balik ke profil
        </a>
    </div>
</x-app-layout>