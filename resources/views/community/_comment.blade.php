@php $isMine = $comment->user_id === auth()->id(); @endphp

<p class="text-[10px] text-gray-400 flex items-center gap-1.5 flex-wrap">
    <x-avatar :email="$comment->user->email" class="w-5 h-5" />
    <span class="font-bold text-gray-600 dark:text-gray-300">{{ $comment->user->name }}</span>
    @if($comment->user->title)
        <span class="font-bold text-yellow-600 dark:text-yellow-400">{{ $comment->user->title->icon }} {{ $comment->user->title->name }}</span>
    @endif
    · {{ $comment->created_at->diffForHumans() }}
</p>

<p class="text-sm text-gray-800 dark:text-gray-200 mt-1.5 whitespace-pre-wrap">{{ $comment->body }}</p>

<div class="flex items-center gap-3 mt-2">
    <form action="{{ route('community.fire', $comment) }}" method="POST">
        @csrf
        <button class="flex items-center gap-1 text-[11px] font-bold transition
            {{ $comment->myFire() ? 'text-orange-500' : 'text-gray-400 hover:text-orange-400' }}">
            🔥 {{ $comment->fireCount() > 0 ? $comment->fireCount() : '' }}
        </button>
    </form>

    @if($depth < 4)
        <button onclick="document.getElementById('reply-form-{{ $comment->id }}').classList.toggle('hidden')"
            class="text-[11px] font-bold text-gray-400 hover:text-yellow-500 transition">Balas</button>
    @endif

    @if(!$isMine)
        <form action="{{ route('community.report') }}" method="POST"
            onsubmit="this.reason.value = prompt('Kenapa lu lapor komentar ini?'); return !!this.reason.value;">
            @csrf
            <input type="hidden" name="comment_id" value="{{ $comment->id }}">
            <input type="hidden" name="reason">
            <button class="text-[11px] text-gray-400 hover:text-red-500">🚨</button>
        </form>
    @endif

    @if($isMine)
        <form action="{{ route('community.comment.destroy', $comment) }}" method="POST"
            onsubmit="return confirm('Hapus komentar ini? Balasan di bawahnya ikut terhapus.')">
            @csrf
            @method('DELETE')
            <button class="text-[11px] text-red-400 hover:text-red-500 font-bold">hapus</button>
        </form>
    @endif
</div>

@if($depth < 4)
    <div id="reply-form-{{ $comment->id }}" class="hidden mt-2">
        <form action="{{ route('community.comment', $post) }}" method="POST" class="space-y-1.5">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
            <textarea name="body" rows="2" required maxlength="1000" placeholder="Balas {{ $comment->user->name }}..."
                class="w-full rounded-lg border-gray-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-gray-100 dark:placeholder-gray-500 px-3 py-2 text-xs">{{ old('body') }}</textarea>
            <div class="text-right">
                <button class="bg-gray-900 dark:bg-gray-100 text-white dark:text-gray-900 font-bold text-[11px] py-1.5 px-4 rounded-full">Balas</button>
            </div>
        </form>
    </div>
@endif

@if($comment->children->count())
    <div class="mt-3 {{ $depth < 3 ? 'pl-3 border-l-2 border-gray-100 dark:border-neutral-800' : '' }} space-y-3">
        @foreach($comment->children as $child)
            @include('community._comment', ['comment' => $child, 'post' => $post, 'depth' => $depth + 1])
        @endforeach
    </div>
@endif