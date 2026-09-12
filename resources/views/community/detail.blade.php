<x-app-layout>
    <div class="max-w-2xl mx-auto px-3 pt-4">

        <a href="{{ route('community.index') }}" class="text-xs text-gray-400 inline-flex items-center gap-1 mb-3">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
            Semua postingan
        </a>

        @if(session('commented'))
            <div class="bg-white dark:bg-neutral-900 border border-yellow-400 dark:border-yellow-600 rounded-lg p-3 mb-2 text-sm flex items-center gap-2">
                <svg class="w-5 h-5 text-yellow-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                Komentar terkirim!
            </div>
        @endif
        @if(session('commentDeleted'))
            <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-3 mb-2 text-sm">Komentar dihapus</div>
        @endif
        @if(session('reported'))
            <div class="bg-white dark:bg-neutral-900 border border-yellow-400 dark:border-yellow-600 rounded-lg p-3 mb-2 text-sm flex items-center gap-2">
                <span>🚨</span>
                <span>Laporan terkirim — admin bakal ngecek. Makasih udah jaga komunitas!</span>
            </div>
        @endif

        {{-- POST UTAMA --}}
        <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-4 mb-3 flex gap-2.5">
            <div class="flex flex-col items-center gap-0.5 shrink-0 w-9">
                <form action="{{ route('community.vote', $post) }}" method="POST">
                    @csrf
                    <input type="hidden" name="value" value="1">
                    <button class="w-7 h-7 rounded flex items-center justify-center transition
                        {{ $post->myVote() === 1 ? 'text-yellow-500 bg-yellow-100 dark:bg-yellow-950/50' : 'text-gray-300 hover:bg-gray-100 dark:hover:bg-neutral-800' }}" aria-label="Upvote">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" /></svg>
                    </button>
                </form>
                <span class="text-sm font-extrabold {{ $post->score() > 0 ? 'text-yellow-500' : ($post->score() < 0 ? 'text-indigo-400' : 'text-gray-400') }}">{{ $post->score() }}</span>
                <form action="{{ route('community.vote', $post) }}" method="POST">
                    @csrf
                    <input type="hidden" name="value" value="-1">
                    <button class="w-7 h-7 rounded flex items-center justify-center transition
                        {{ $post->myVote() === -1 ? 'text-indigo-400 bg-indigo-50 dark:bg-indigo-950/50' : 'text-gray-300 hover:bg-gray-100 dark:hover:bg-neutral-800' }}" aria-label="Downvote">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
                    </button>
                </form>
            </div>

            <div class="flex-1 min-w-0">
                <p class="text-[10px] text-gray-400 flex items-center gap-1.5 flex-wrap">
                    <a href="{{ route('community.show', $post->category) }}" class="font-bold text-yellow-600 dark:text-yellow-400 hover:underline">r/{{ strtolower(str_replace(' ', '', $post->category->name)) }}</a>
                    · <span class="font-bold">{{ $post->user->name }}</span>
                    @if($post->user->title)
                        <span class="font-bold text-yellow-600 dark:text-yellow-400">{{ $post->user->title->icon }} {{ $post->user->title->name }}</span>
                    @endif
                    · {{ $post->created_at->diffForHumans() }}
                </p>
                <h1 class="font-extrabold text-base text-gray-900 dark:text-gray-100 mt-1">{{ $post->title }}</h1>
                <p class="text-sm text-gray-700 dark:text-gray-300 mt-2 whitespace-pre-wrap">{{ $post->body }}</p>

                <div class="mt-3 flex items-center gap-3">
                    @if($post->user_id === auth()->id())
                        <form action="{{ route('community.destroy', $post) }}" method="POST"
                            onsubmit="return confirm('Hapus post ini beserta komentarnya?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-[11px] text-red-400 hover:text-red-500 font-bold">Hapus post</button>
                        </form>
                    @else
                        <form action="{{ route('community.report') }}" method="POST"
                            onsubmit="this.reason.value = prompt('Kenapa lu lapor post ini? (misal: spam, toxic, gak nyambung)'); return !!this.reason.value;">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <input type="hidden" name="reason">
                            <button class="text-[11px] text-gray-400 hover:text-red-500 font-bold">🚨 Lapor</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        {{-- FORM KOMENTAR --}}
        <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-3 mb-3">
            <form action="{{ route('community.comment', $post) }}" method="POST" class="space-y-2">
                @csrf
                <textarea name="body" rows="3" required maxlength="1000" placeholder="Tulis komentar yang membangun..."
                    class="w-full rounded-lg border-gray-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-gray-100 dark:placeholder-gray-500 px-3 py-2.5 text-sm focus:ring-2 focus:ring-yellow-400">{{ old('body') }}</textarea>
                @error('body')<p class="text-xs text-red-500">{{ $message }}</p>@enderror
                <div class="text-right">
                    <button class="bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-bold text-xs py-2 px-5 rounded-full active:scale-95 transition">Kirim</button>
                </div>
            </form>
        </div>

        {{-- THREAD --}}
        <h2 class="text-xs font-bold uppercase tracking-wide text-gray-500 px-1 mb-2">{{ $totalComments }} komentar</h2>

        <div class="space-y-2 mb-4">
            @forelse($comments as $comment)
                <div class="bg-white dark:bg-neutral-900 border border-gray-200 dark:border-neutral-800 rounded-lg p-3">
                    @include('community._comment', ['comment' => $comment, 'post' => $post, 'depth' => 0])
                </div>
            @empty
                <div class="bg-white dark:bg-neutral-900 border border-gray-200 dark:border-neutral-800 rounded-lg p-6 text-center">
                    <p class="text-3xl mb-1">💬</p>
                    <p class="text-xs text-gray-400">Belum ada komentar — jadi yang pertama!</p>
                </div>
            @endforelse
        </div>

        <div class="pb-4"></div>
    </div>
</x-app-layout>