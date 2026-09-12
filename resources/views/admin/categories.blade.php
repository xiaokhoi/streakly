<x-app-layout>
    <div class="max-w-2xl mx-auto px-3 pt-4">
        <h1 class="text-lg font-extrabold text-gray-900 dark:text-gray-100 mb-3">🛠️ Admin · Kategori</h1>

        <x-admin-tabs />

        @if(session('categoryAdded'))
            <div class="bg-white dark:bg-neutral-900 border border-yellow-400 dark:border-yellow-600 rounded-lg p-3 mb-3 text-sm">Kategori ditambahkan!</div>
        @endif

        {{-- TAMBAH KATEGORI --}}
        <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-3.5 mb-3">
            <form action="{{ route('admin.categories.store') }}" method="POST" class="flex gap-2">
                @csrf
                <input type="text" name="icon" placeholder="Icon emoji" required maxlength="4"
                    class="w-16 rounded-lg border-gray-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-gray-100 px-2 py-2.5 text-center text-sm">
                <input type="text" name="name" placeholder="Nama kategori, misal: Meditasi" required maxlength="30"
                    class="flex-1 rounded-lg border-gray-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-gray-100 px-3 py-2.5 text-sm">
                <button class="bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-bold text-sm px-4 rounded-lg">+</button>
            </form>
            @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- DAFTAR --}}
        <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg overflow-hidden">
            @foreach($categories as $cat)
                <div class="flex items-center gap-3 px-3 py-2.5 border-b border-gray-100 dark:border-neutral-800 last:border-0">
                    <span class="text-xl">{{ $cat->icon }}</span>
                    <span class="text-sm font-bold text-gray-900 dark:text-gray-100 flex-1">{{ $cat->name }}</span>
                    <span class="text-[11px] text-gray-400">{{ $cat->habits_count }} habit dipakai</span>
                </div>
            @endforeach
        </div>

        <div class="pb-4"></div>
    </div>
</x-app-layout>