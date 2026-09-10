<x-app-layout>
    <div class="max-w-2xl mx-auto px-3 pt-4">

        {{-- BREADCRUMB --}}
        <div class="flex items-center gap-2 text-sm mb-3">
            <a href="{{ route('explore') }}" class="text-gray-400 hover:text-yellow-500 transition">Explore</a>
            <span class="text-gray-300 dark:text-gray-700">›</span>
            <span class="font-bold text-gray-900 dark:text-gray-100">r/{{ strtolower(str_replace(' ', '', $category->name)) }}</span>
        </div>

        {{-- HEADER KOMUNITAS --}}
        <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg mb-3 overflow-hidden">
            <div class="h-16 bg-yellow-400"></div>
            <div class="px-4 pb-3">
                <div class="flex items-end gap-3 -mt-6 mb-2">
                    <div class="w-14 h-14 rounded-full bg-white dark:bg-neutral-900 border-4 border-white dark:border-neutral-900 flex items-center justify-center text-2xl shrink-0">
                        {{ $category->icon }}
                    </div>
                </div>
                <h1 class="text-lg font-extrabold text-gray-900 dark:text-gray-100">{{ $category->name }}</h1>
                <p class="text-xs text-gray-400">Habit paling rame dijalain orang di kategori ini</p>
            </div>
        </div>

        {{-- ===== FEED HABIT POPULER ===== --}}
        <div class="space-y-2">
            @forelse($popular as $i => $item)
                <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-3 flex items-center gap-3 hover:border-gray-400 dark:hover:border-neutral-700 transition">
                    {{-- ranking ala reddit trending --}}
                    <span class="w-6 text-center text-sm font-extrabold text-gray-300 dark:text-gray-600 shrink-0">{{ $i + 1 }}</span>

                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-sm text-gray-900 dark:text-gray-100 truncate">{{ $item->name }}</p>
                        <p class="text-xs text-gray-400">{{ $item->users_count }} orang lagi jalanin</p>
                    </div>

                    @if(in_array($item->name, $ownedNames))
                        <span class="flex items-center gap-1 text-xs font-bold text-yellow-600 dark:text-yellow-400 shrink-0">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                            Ikut
                        </span>
                    @else
                        <form action="{{ route('explore.adopt') }}" method="POST" class="shrink-0">
                            @csrf
                            <input type="hidden" name="name" value="{{ $item->name }}">
                            <input type="hidden" name="category_id" value="{{ $category->id }}">
                            <button class="text-[11px] font-bold text-gray-600 dark:text-gray-300 border border-gray-300 dark:border-neutral-700 rounded-full px-4 py-1.5 hover:bg-yellow-400 hover:border-yellow-400 hover:text-gray-900 transition">
                                + Ikut
                            </button>
                        </form>
                    @endif
                </div>
            @empty
                <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-8 text-center">
                    <p class="text-3xl mb-2">🌱</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-bold">Komunitas masih sepi</p>
                    <p class="text-xs text-gray-400 mt-1">Jadi yang pertama bikin habit di sini — dari dashboard!</p>
                </div>
            @endforelse
        </div>

        <div class="pb-4"></div>
    </div>
</x-app-layout>