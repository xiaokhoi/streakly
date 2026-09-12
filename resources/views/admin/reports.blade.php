<x-app-layout>
    <div class="max-w-2xl mx-auto px-3 pt-4">
        <h1 class="text-lg font-extrabold text-gray-900 dark:text-gray-100 mb-3">🚨 Admin · Laporan</h1>

        <x-admin-tabs />

        @if(session('dismissed'))
            <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-3 mb-3 text-sm">Laporan diabaikan.</div>
        @endif
        @if(session('resolved'))
            <div class="bg-white dark:bg-neutral-900 border border-red-300 dark:border-red-800 rounded-lg p-3 mb-3 text-sm">Konten dilaporkan dihapus.</div>
        @endif

        <div class="space-y-2">
            @forelse($reports as $report)
                <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-3.5">
                    <p class="text-[10px] text-gray-400">
                        Dilaporin oleh <span class="font-bold">{{ $report->reporter->name }}</span>
                        · {{ $report->created_at->diffForHumans() }}
                    </p>
                    <p class="text-sm text-gray-800 dark:text-gray-200 mt-1">
                        Alasan: <span class="font-bold text-red-500">"{{ $report->reason }}"</span>
                    </p>

                    {{-- PRATINJAU KONTEN --}}
                    @if($report->post)
                        <div class="mt-2 bg-gray-50 dark:bg-neutral-800 rounded-lg p-2.5">
                            <p class="text-[10px] text-gray-400 font-bold uppercase">Post</p>
                            <p class="text-xs font-bold text-gray-800 dark:text-gray-200">{{ $report->post->title }}</p>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 line-clamp-2">{{ $report->post->body }}</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">oleh {{ $report->post->user?->name ?? '(user terhapus)' }}</p>
                        </div>
                    @endif
                    @if($report->comment)
                        <div class="mt-2 bg-gray-50 dark:bg-neutral-800 rounded-lg p-2.5">
                            <p class="text-[10px] text-gray-400 font-bold uppercase">Komentar</p>
                            <p class="text-[11px] text-gray-700 dark:text-gray-300">{{ $report->comment->body }}</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">oleh {{ $report->comment->user?->name ?? '(user terhapus)' }}</p>
                        </div>
                    @endif

                    <div class="flex gap-2 mt-2.5">
                        <form action="{{ route('admin.reports.resolve', $report) }}" method="POST"
                            onsubmit="return confirm('Hapus konten yang dilaporkan?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-[11px] font-bold text-red-500 border border-red-300 dark:border-red-800 rounded-full px-4 py-1.5 hover:bg-red-50 dark:hover:bg-red-950/50">
                                🗑️ Hapus konten
                            </button>
                        </form>
                        <form action="{{ route('admin.reports.dismiss', $report) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="text-[11px] font-bold text-gray-500 border border-gray-300 dark:border-neutral-700 rounded-full px-4 py-1.5 hover:bg-gray-100 dark:hover:bg-neutral-800">
                                Abaikan
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-8 text-center">
                    <p class="text-4xl mb-2">🕊️</p>
                    <p class="text-sm text-gray-500 font-bold">Gak ada laporan</p>
                    <p class="text-xs text-gray-400 mt-1">Komunitas damai. Enjoy.</p>
                </div>
            @endforelse
        </div>

        <div class="pb-4"></div>
    </div>
</x-app-layout>