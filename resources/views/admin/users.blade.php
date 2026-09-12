<x-app-layout>
    <div class="max-w-2xl mx-auto px-3 pt-4">
        <h1 class="text-lg font-extrabold text-gray-900 dark:text-gray-100 mb-3">🛠️ Admin · Kelola User</h1>

        <x-admin-tabs />

        @if(session('userDeleted'))
            <div class="bg-white dark:bg-neutral-900 border border-red-300 dark:border-red-800 rounded-lg p-3 mb-3 text-sm">
                User "{{ session('userDeleted') }}" dihapus.
            </div>
        @endif

        <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg overflow-hidden">
            @foreach($users as $u)
                <div class="flex items-center gap-3 px-3 py-3 border-b border-gray-100 dark:border-neutral-800 last:border-0">
                    <x-avatar :type="$u->avatar" class="w-9 h-9 shrink-0" />
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-gray-900 dark:text-gray-100 truncate">
                            {{ $u->name }}
                            @if($u->email === auth()->user()->email)
                                <span class="text-[9px] font-extrabold text-yellow-600 dark:text-yellow-400">(LU)</span>
                            @endif
                        </p>
                        <p class="text-[11px] text-gray-400 truncate">{{ $u->email }} · 🔥{{ $u->current_streak }} · Lv.{{ $u->level }} · {{ $u->habits_count }} habit · {{ $u->checkIns_count }} check-in</p>
                    </div>
                    @if($u->email !== auth()->user()->email)
                        <form action="{{ route('admin.users.destroy', $u) }}" method="POST"
                            onsubmit="return confirm('Hapus user {{ $u->name }}? SEMUA datanya (streak, habit, post, chat) hilang permanen!')">
                            @csrf
                            @method('DELETE')
                            <button class="text-[11px] font-bold text-red-400 hover:text-red-500 shrink-0">hapus</button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="pb-4"></div>
    </div>
</x-app-layout>