<x-app-layout>
    <div class="max-w-2xl mx-auto px-3 pt-4">

        <h1 class="text-lg font-extrabold text-gray-900 dark:text-gray-100 mb-1">📖 Perjalanan lu</h1>
        <p class="text-xs text-gray-400 mb-3">{{ $total }} catatan — bukti hari-hari yang lu lalui</p>

        @forelse($memories as $month => $items)
            <div class="mb-4">
                <h2 class="text-xs font-bold uppercase tracking-wide text-gray-500 px-1 mb-2">{{ $month }}</h2>

                <div class="space-y-2">
                    @foreach($items as $memory)
                        <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-3.5 flex gap-3">
                            <div class="shrink-0 text-center w-10">
                                <p class="text-lg font-extrabold text-yellow-500 leading-none">{{ $memory->checked_at->format('d') }}</p>
                                <p class="text-[10px] text-gray-400 uppercase">{{ $memory->checked_at->translatedFormat('M') }}</p>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-800 dark:text-gray-200">{{ $memory->note }}</p>
                                <p class="text-[10px] text-gray-400 mt-1">
                                    {{ $memory->checked_at->format('H:i') }}
                                    @if($memory->habit)
                                        · {{ $memory->habit->category?->icon }} {{ $memory->habit->name }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-8 text-center">
                <p class="text-4xl mb-2">✨</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-bold">Belum ada catatan</p>
                <p class="text-xs text-gray-400 mt-1">Mulai tulis 1 kalimat tiap check-in — nanti jadi kenangan</p>
            </div>
        @endforelse

        <a href="{{ route('profile.edit') }}" class="block text-center text-sm font-bold text-gray-600 dark:text-gray-300 border border-gray-300 dark:border-neutral-700 rounded-full py-3 mt-2 mb-4 hover:bg-yellow-400 hover:border-yellow-400 hover:text-gray-900 transition">
            ← Balik ke profil
        </a>
    </div>
</x-app-layout>