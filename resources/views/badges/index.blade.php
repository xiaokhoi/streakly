<x-app-layout>
    <div class="max-w-2xl mx-auto px-3 pt-4">

        <h1 class="text-lg font-extrabold text-gray-900 dark:text-gray-100 mb-1">Badge & Gelar</h1>
        <p class="text-xs text-gray-400 mb-3">Streak terpanjang lu: {{ auth()->user()->longest_streak }} hari — kumpulin semuanya</p>

        @if(session('worn'))
            <div class="bg-white dark:bg-neutral-900 border border-yellow-400 dark:border-yellow-600 rounded-lg p-3 mb-3 text-sm flex items-center gap-2">
                <svg class="w-5 h-5 text-yellow-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                <span class="font-bold">Gelar "{{ session('worn') }}" dipasang!</span>
            </div>
        @endif

        <div class="space-y-2">
            @foreach($badges as $badge)
                @php $earned = in_array($badge->id, $earnedIds); @endphp
                <div class="bg-white dark:bg-neutral-900 border rounded-lg p-3.5 flex items-center gap-3
                    {{ $earned ? 'border-gray-300 dark:border-neutral-800' : 'border-gray-200 dark:border-neutral-800 opacity-60' }}">

                    {{-- icon award ala reddit --}}
                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-2xl shrink-0
                        {{ $earned ? 'bg-yellow-100 dark:bg-yellow-950/50' : 'bg-gray-100 dark:bg-neutral-800 grayscale' }}">
                        {{ $badge->icon }}
                    </div>

                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-sm text-gray-900 dark:text-gray-100">{{ $badge->name }}</p>
                        <p class="text-xs text-gray-400">{{ $badge->description }}</p>
                    </div>

                    <div class="shrink-0">
                        @if($earned)
                            @if(auth()->user()->badge_id === $badge->id)
                                <span class="text-[11px] font-extrabold text-yellow-600 dark:text-yellow-400 bg-yellow-100 dark:bg-yellow-950/50 rounded-full px-3 py-1.5">Dipakai</span>
                            @else
                                <form action="{{ route('badges.wear', $badge) }}" method="POST">
                                    @csrf
                                    <button class="text-[11px] font-bold text-gray-600 dark:text-gray-300 border border-gray-300 dark:border-neutral-700 rounded-full px-4 py-1.5 hover:bg-yellow-400 hover:border-yellow-400 hover:text-gray-900 transition">
                                        Pakai
                                    </button>
                                </form>
                            @endif
                        @else
                            <span class="text-[11px] font-bold text-gray-400">🔒 {{ $badge->required_streak }} hari</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        @if(auth()->user()->badge_id)
            <form action="{{ route('badges.remove') }}" method="POST" class="text-center mt-4">
                @csrf
                <button class="text-xs text-gray-400 underline">Lepas gelar</button>
            </form>
        @endif

        <div class="pb-4"></div>
    </div>
</x-app-layout>