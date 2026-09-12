<x-app-layout>
    <div class="max-w-2xl mx-auto px-3 pt-4">
        <h1 class="text-lg font-extrabold text-gray-900 dark:text-gray-100 mb-3">🛠️ Admin · Moderasi Komunitas</h1>

        <x-admin-tabs />

        @if(session('postDeleted'))
            <div class="bg-white dark:bg-neutral-900 border border-red-300 dark:border-red-800 rounded-lg p-3 mb-3 text-sm">Post dihapus.</div>
        @endif
        @if(session('commentDeleted'))
            <div class="bg-white dark:bg-neutral-900 border border-red-300 dark:border-red-800 rounded-lg p-3 mb-3 text-sm">Komentar dihapus.</div>
        @endif

        <div class="space-y-2">
            @forelse($posts as $post)
                <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-3">
                    <p class="text-[10px] text-gray-400">
                        <span class="font-bold text-gray-600 dark:text-gray-300">{{ $post->user->name }}</span>
                        · r/{{ strtolower(str_replace(' ', '', $post->category->name)) }}
                        · {{ $post->created_at->diffForHumans() }} · {{ $post->comments_count }} komentar
                    </p>
                    <p class="text-sm font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $post->title }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 line-clamp-2">{{ $post->body }}</p>
                    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="mt-2"
                        onsubmit="return confirm('Hapus post ini (moderasi)?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-[11px] font-bold text-red-400 hover:text-red-500">🗑️ hapus post</button>
                    </form>
                </div>
            @empty
                <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-8 text-center">
                    <p class="text-sm text-gray-400">Belum ada postingan</p>
                </div>
            @endforelse
        </div>

        <div class="pb-4"></div>
    </div>
</x-app-layout>