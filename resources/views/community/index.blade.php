<x-app-layout>
    <div class="max-w-2xl mx-auto px-3 pt-4">
        <h1 class="text-lg font-extrabold text-gray-900 dark:text-gray-100 mb-1">🏘️ Komunitas</h1>
        <p class="text-xs text-gray-400 mb-3">Cerita progres, saling support satu sama lain</p>
        
        <p class="text-xs text-gray-400 mb-2">Cerita progres, saling support satu sama lain</p>

        <div class="flex gap-1.5 mb-3">
            @foreach(['hot' => '🔥 Hot', 'top' => '🏆 Top', 'new' => '🆕 Baru'] as $key => $label)
                <a href="{{ request()->fullUrlWithQuery(['sort' => $key]) }}"
                    class="text-[11px] font-bold px-3 py-1.5 rounded-full border transition
                    {{ ($sort ?? 'hot') === $key ? 'bg-yellow-400 border-yellow-400 text-gray-900' : 'border-gray-300 dark:border-neutral-700 text-gray-500' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
        
        @if(session('posted'))
            <div class="bg-white dark:bg-neutral-900 border border-yellow-400 dark:border-yellow-600 rounded-lg p-3 mb-3 text-sm flex items-center gap-2">
                <svg class="w-5 h-5 text-yellow-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                Post ke-publish!
            </div>
        @endif
        @if(session('postDeleted'))
            <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-3 mb-3 text-sm flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                Post dihapus
            </div>
        @endif

        {{-- FORM POST (pilih kategori via dropdown) --}}
        <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg mb-3">
            <button onclick="document.getElementById('post-form').classList.toggle('hidden')"
                class="w-full px-3 py-3 text-left text-sm font-bold text-gray-500 flex items-center gap-2">
                <svg class="w-5 h-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                Bagikan progres kamu ke komunitas...
            </button>

            <div id="post-form" class="hidden px-3 pb-3">
                <form action="{{ route('community.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <select name="category_id" required
                        class="w-full rounded-lg border-gray-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-gray-100 px-3 py-2.5 text-sm">
                        <option value="" disabled selected>Posting ke kategori...</option>
                        @foreach(\App\Models\Category::orderBy('name')->get() as $cat)
                            <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->icon }} {{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="text-xs text-red-500">{{ $message }}</p>@enderror

                    <input type="text" name="title" value="{{ old('title') }}" placeholder="Judul (min. 5 karakter)" required maxlength="120"
                        class="w-full rounded-lg border-gray-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-gray-100 dark:placeholder-gray-500 px-3 py-2.5 text-sm">
                    @error('title')<p class="text-xs text-red-500">{{ $message }}</p>@enderror

                    <textarea name="body" rows="4" placeholder="Ceritain streak/habit lu hari ini..." required maxlength="2000"
                        class="w-full rounded-lg border-gray-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-gray-100 dark:placeholder-gray-500 px-3 py-2.5 text-sm">{{ old('body') }}</textarea>
                    @error('body')<p class="text-xs text-red-500">{{ $message }}</p>@enderror

                    <button class="bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-bold text-sm py-2.5 px-6 rounded-full">Posting</button>
                </form>
            </div>
        </div>

        {{-- FEED GLOBAL --}}
        <div class="space-y-2">
            @forelse($posts as $post)
                <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-3 flex gap-2.5">
                    <div class="flex flex-col items-center gap-0.5 shrink-0 w-8">
                        <form action="{{ route('community.vote', $post) }}" method="POST">
                            @csrf
                            <input type="hidden" name="value" value="1">
                            <button class="w-6 h-6 rounded flex items-center justify-center {{ $post->myVote() === 1 ? 'text-yellow-500 bg-yellow-100 dark:bg-yellow-950/50' : 'text-gray-300 hover:bg-gray-100 dark:hover:bg-neutral-800' }}" aria-label="Upvote">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" /></svg>
                            </button>
                        </form>
                        <span class="text-xs font-extrabold {{ $post->score() > 0 ? 'text-yellow-500' : 'text-gray-400' }}">{{ $post->score() }}</span>
                        <form action="{{ route('community.vote', $post) }}" method="POST">
                            @csrf
                            <input type="hidden" name="value" value="-1">
                            <button class="w-6 h-6 rounded flex items-center justify-center {{ $post->myVote() === -1 ? 'text-indigo-400 bg-indigo-50 dark:bg-indigo-950/50' : 'text-gray-300 hover:bg-gray-100 dark:hover:bg-neutral-800' }}" aria-label="Downvote">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
                            </button>
                        </form>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[10px] text-gray-400">
                            <a href="{{ route('community.show', $post->category) }}" class="font-bold text-yellow-600 dark:text-yellow-400 hover:underline">r/{{ strtolower(str_replace(' ', '', $post->category->name)) }}</a>
                            · {{ $post->user->name }} · {{ $post->created_at->diffForHumans() }}
                        </p>
                                               <a href="{{ route('community.detail', $post) }}">
                            <h3 class="font-bold text-sm text-gray-900 dark:text-gray-100 mt-0.5 hover:underline">{{ $post->title }}</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">{{ $post->body }}</p>
                        </a>
                        <a href="{{ route('community.detail', $post) }}" class="text-[11px] text-gray-400 mt-2 flex items-center gap-1 hover:text-yellow-500 transition">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 0 1-.923 1.785A5.969 5.969 0 0 0 6 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337Z" /></svg>
                            {{ $post->comments_count }} komentar
                        </a>
                    </div>
                    @if($post->user_id === auth()->id())
                        <form action="{{ route('community.destroy', $post) }}" method="POST"
                            onsubmit="return confirm('Hapus post ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-gray-300 hover:text-red-500 transition shrink-0" aria-label="Hapus">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                            </button>
                        </form>
                    @endif
                </div>
            @empty
                <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-8 text-center">
                    <p class="text-4xl mb-2">🏘️</p>
                    <p class="text-sm text-gray-500 font-bold">Komunitas masih sepi</p>
                    <p class="text-xs text-gray-400 mt-1">Jadi yang pertama bagikan progres lu!</p>
                </div>
            @endforelse
        </div>

        <div class="mt-3">{{ $posts->links() }}</div>
        <div class="pb-4"></div>
    </div>
</x-app-layout>