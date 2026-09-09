<x-app-layout>
    <div class="py-6 max-w-md mx-auto px-4">
        <h1 class="text-xl font-extrabold text-gray-800 dark:text-gray-100 mb-1">🏅 Koleksi Badge</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
            Kumpulin semua — streak {{ auth()->user()->longest_streak }} hari terpanjang lu 🔥
        </p>

        @if(session('worn'))
            <div class="bg-indigo-50 dark:bg-indigo-950/50 border border-indigo-300 dark:border-indigo-700 rounded-xl p-3 mb-4 text-sm text-indigo-700 dark:text-indigo-400 text-center animate-pop">
                ✨ Gelar "{{ session('worn')->name }}" dipasang!
            </div>
        @endif

        <div class="grid grid-cols-2 gap-3">
            @foreach($badges as $badge)
                @php $earned = in_array($badge->id, $earnedIds); @endphp
                <div class="rounded-2xl p-4 text-center shadow
                    {{ $earned ? 'bg-white dark:bg-gray-800' : 'bg-gray-100 dark:bg-gray-900 opacity-60' }}">
                    <div class="text-4xl mb-2 {{ $earned ? '' : 'grayscale' }}">{{ $badge->icon }}</div>
                    <p class="font-bold text-gray-700 dark:text-gray-200 text-sm">{{ $badge->name }}</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1 mb-2">{{ $badge->description }}</p>

                    @if($earned)
                        @if(auth()->user()->badge_id === $badge->id)
                            <span class="inline-flex items-center gap-1 bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 text-xs font-bold px-3 py-1 rounded-full">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                                Dipakai
                            </span>
                        @else
                            <form action="{{ route('badges.wear', $badge) }}" method="POST">
                                @csrf
                                <button class="text-xs font-bold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950 px-3 py-1 rounded-full hover:bg-indigo-100 dark:hover:bg-indigo-900 active:scale-95 transition">
                                    Pakai sebagai gelar
                                </button>
                            </form>
                        @endif
                    @else
                        <span class="text-xs font-bold text-gray-400 dark:text-gray-600">
                            🔒 Streak {{ $badge->required_streak }} hari
                        </span>
                    @endif
                </div>
            @endforeach
        </div>

        @if(auth()->user()->badge_id)
            <form action="{{ route('badges.remove') }}" method="POST" class="mt-4 text-center">
                @csrf
                <button class="text-xs text-gray-400 dark:text-gray-500 underline">Lepas gelar</button>
            </form>
        @endif
    </div>
</x-app-layout>