<x-app-layout>
    <div class="max-w-2xl mx-auto px-3 pt-4">
        <h1 class="text-lg font-extrabold text-gray-900 dark:text-gray-100 mb-1">✉️ Surat untuk diri sendiri</h1>
        <p class="text-xs text-gray-400 mb-3">Tulis sekarang, dibuka pas streak {{ 30 }} hari</p>

        @if(session('letterWritten'))
            <div class="bg-white dark:bg-neutral-900 border border-yellow-400 dark:border-yellow-600 rounded-lg p-3 mb-3 text-sm">
                ✉️ Surat tersimpan — terkunci sampai streak-mu capai 30 hari. Gak usah putus ya!
            </div>
        @endif
        @if(session('letterExists'))
            <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-3 mb-3 text-sm">
                Lu udah punya surat yang nunggu buka. Selesaikan streak-nya dulu!
            </div>
        @endif

        {{-- FORM: cuma muncul kalau gak ada surat terkunci --}}
        @if(!$letters->contains(fn ($l) => $l->isLocked()))
            <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-4 mb-3">
                <h2 class="text-xs font-bold uppercase tracking-wide text-gray-500 mb-3">Tulis surat baru</h2>
                <form action="{{ route('letters.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <textarea name="body" rows="5" required maxlength="1000"
                        placeholder="Untuk aku yang hari ke-30... 🖊️"
                        class="w-full rounded-lg border-gray-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-gray-100 dark:placeholder-gray-500 px-3 py-3 text-sm focus:ring-2 focus:ring-yellow-400"></textarea>
                    <button class="w-full bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-bold py-3 rounded-full text-sm">
                        Simpan & kunci ✉️
                    </button>
                </form>
            </div>
        @endif

        {{-- DAFTAR SURAT --}}
        <div class="space-y-2">
            @forelse($letters as $letter)
                <a href="{{ route('letters.show', $letter) }}"
                    class="block bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-3.5 flex items-center gap-3 hover:border-yellow-400 dark:hover:border-yellow-600 transition">
                    <div class="text-3xl shrink-0">{{ $letter->isLocked() ? '🔒' : '💌' }}</div>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-sm text-gray-900 dark:text-gray-100">
                            {{ $letter->isLocked() ? 'Surat terkunci' : 'Surat terbuka' }}
                        </p>
                        <p class="text-xs text-gray-400">
                            Ditulis {{ $letter->written_at->translatedFormat('d M Y') }}
                            @if($letter->isLocked())
                                · buka di streak {{ $letter->unlock_at_streak }} hari
                            @else
                                · dibuka {{ $letter->opened_at?->translatedFormat('d M Y') }}
                            @endif
                        </p>
                    </div>
                    <span class="text-gray-400">›</span>
                </a>
            @empty
                <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-8 text-center">
                    <p class="text-4xl mb-2">✉️</p>
                    <p class="text-sm text-gray-500 font-bold">Belum ada surat</p>
                    <p class="text-xs text-gray-400 mt-1">Tulis pesan buat diri lu di masa depan — form di atas</p>
                </div>
            @endforelse
        </div>

        <div class="pb-4"></div>
    </div>
</x-app-layout>