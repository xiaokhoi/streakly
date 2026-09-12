<x-app-layout>
    <div class="max-w-2xl mx-auto px-3 pt-4">
    
        <h1 class="text-lg font-extrabold text-gray-900 dark:text-gray-100 mb-3">🛠️ Admin</h1>

        <x-admin-tabs />

        <p class="text-xs text-gray-400 mb-3">Upload PNG dari galeri — otomatis bernomor lanjutan</p>
        {{-- BANNER --}}
        @if(session('uploaded'))
            <div class="bg-white dark:bg-neutral-900 border border-yellow-400 dark:border-yellow-600 rounded-lg p-3 mb-3 text-sm flex items-center gap-2">
                <svg class="w-5 h-5 text-yellow-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                Tersimpan sebagai <span class="font-bold">{{ session('uploaded') }}</span>
            </div>
        @endif
        @if(session('deleted'))
            <div class="bg-white dark:bg-neutral-900 border border-red-300 dark:border-red-800 rounded-lg p-3 mb-3 text-sm flex items-center gap-2">
                <svg class="w-5 h-5 text-red-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                {{ session('deleted') }} dihapus
            </div>
        @endif

        {{-- FORM UPLOAD --}}
        <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-4 mb-3">
            <h2 class="text-xs font-bold uppercase tracking-wide text-gray-500 mb-3">Upload avatar baru</h2>
            <form action="{{ route('admin.avatars.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <input type="file" name="avatar" accept="image/png" required
                    class="w-full text-sm text-gray-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:bg-yellow-400 file:text-gray-900 file:font-bold file:text-sm hover:file:bg-yellow-300 file:cursor-pointer cursor-pointer">
                <p class="text-[11px] text-gray-400">PNG · sebaiknya 256×256 atau lebih · background transparan</p>
                <button class="w-full bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-bold py-3 rounded-full text-sm">Upload</button>
            </form>
        </div>

        {{-- GALERI AVATAR --}}
        <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg overflow-hidden">
            <div class="px-3 py-2.5 border-b border-gray-100 dark:border-neutral-800">
                <h2 class="text-xs font-bold uppercase tracking-wide text-gray-500">Avatar terpasang ({{ $avatars->count() }})</h2>
            </div>
            <div class="grid grid-cols-4 gap-2 p-3">
                @foreach($avatars as $avatar)
                    <div class="text-center">
                        <img src="{{ asset('avatars/' . $avatar) }}" class="w-full aspect-square object-cover object-top rounded-lg border border-gray-200 dark:border-neutral-700" alt="{{ $avatar }}">
                        <p class="text-[9px] text-gray-400 mt-1 truncate">{{ str_replace(['avatar-', '.png'], '', $avatar) }}</p>
                        <form action="{{ route('admin.avatars.destroy', $avatar) }}" method="POST"
                            onsubmit="return confirm('Hapus {{ $avatar }}? User yang pake ini bakal fallback ke avatar-01.')">
                            @csrf
                            @method('DELETE')
                            <button class="text-[10px] text-red-400 hover:text-red-500 mt-0.5">hapus</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>

        <a href="{{ route('dashboard') }}" class="block text-center text-xs text-gray-400 mt-4 mb-4">← Balik</a>
    </div>
</x-app-layout>