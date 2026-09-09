<x-app-layout>
    <div class="py-6 max-w-md mx-auto px-4">

        <a href="{{ route('explore') }}" class="text-sm text-gray-400 dark:text-gray-500 mb-4 inline-block">← Kembali</a>

        <div class="flex items-center gap-3 mb-1">
            <span class="text-4xl">{{ $category->icon }}</span>
            <h1 class="text-xl font-extrabold text-gray-800 dark:text-gray-100">{{ $category->name }}</h1>
        </div>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Habit paling rame dijalain orang 👇</p>

        <div class="space-y-2">
                        @forelse($popular as $item)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-4 flex items-center justify-between">
                    <div>
                        <p class="font-bold text-gray-700 dark:text-gray-200">{{ $item->name }}</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500">🔥 {{ $item->users_count }} orang lagi jalanin</p>
                    </div>
                    @if(in_array($item->name, $ownedNames))
                        <span class="text-green-500 dark:text-green-400 text-sm font-bold flex items-center gap-1">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            Udah dipunya
                        </span>
                    @else
                        <form action="{{ route('explore.adopt') }}" method="POST">
                            @csrf
                            <input type="hidden" name="name" value="{{ $item->name }}">
                            <input type="hidden" name="category_id" value="{{ $category->id }}">
                            <button class="bg-indigo-600 hover:bg-indigo-700 active:scale-95 transition text-white text-sm font-bold px-4 py-2 rounded-full">
                                + Ikut
                            </button>
                        </form>
                    @endif
                </div>
            @empty
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 text-center">
                    <p class="text-gray-400 dark:text-gray-500 text-sm">Belum ada yang mulai di kategori ini 😴</p>
                    <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">Jadi panutan pertama — bikin dari dashboard!</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>