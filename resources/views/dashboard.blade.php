<x-app-layout>
    <style>
        @keyframes floaty { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-12px); } }
        @keyframes pop { 0% { transform: scale(0.5); opacity: 0; } 70% { transform: scale(1.1); } 100% { transform: scale(1); opacity: 1; } }
        @keyframes fall { 0% { transform: translateY(-10vh) rotate(0deg); opacity: 1; } 100% { transform: translateY(110vh) rotate(360deg); opacity: 0; } }
        @keyframes pulse-danger { 0%,100% { box-shadow: 0 0 0 0 rgba(239,68,68,.4); } 50% { box-shadow: 0 0 0 12px rgba(239,68,68,0); } }
        .animate-floaty { animation: floaty 3s ease-in-out infinite; }
        .animate-pop { animation: pop .5s ease-out; }
        .animate-danger { animation: pulse-danger 1.5s ease-in-out infinite; }
        .confetti { position: fixed; top: -5vh; font-size: 1.5rem; animation: fall 3s linear forwards; pointer-events: none; z-index: 50; }
    </style>

    <div class="py-6 max-w-md mx-auto px-4">

        {{-- BANNER SUKSES ADOPT --}}
        @if(session('adopted'))
            <div class="bg-green-50 dark:bg-green-950/50 border border-green-300 dark:border-green-700 rounded-xl p-3 mb-4 text-sm text-green-700 dark:text-green-400 text-center animate-pop">
                ✅ "{{ session('adopted') }}" masuk ke list habit lu! Selamat mulai 🎉
            </div>
        @endif

        {{-- BANNER: HABIT UDAH DIPUNYA --}}
        @if(session('alreadyOwned'))
            <div class="bg-amber-50 dark:bg-amber-950/50 border border-amber-300 dark:border-amber-700 rounded-xl p-3 mb-4 text-sm text-amber-700 dark:text-amber-400 text-center animate-pop">
                ⚠️ Lu udah punya habit "{{ session('alreadyOwned') }}" — cek di list habit bawah 👇
            </div>
        @endif

                {{-- BANNER: HABIT TERHAPUS --}}
        @if(session('deleted'))
            <div class="bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl p-3 mb-4 text-sm text-gray-600 dark:text-gray-300 text-center animate-pop">
                🗑️ Habit "{{ session('deleted') }}" udah dihapus. Riwayat check-in-nya tetep aman kok ✌️
            </div>
        @endif

        {{-- BANNER RECAP SENIN --}}
        @if(now()->isMonday())
            <a href="{{ route('recap.show') }}"
                class="block bg-gradient-to-r from-purple-500 to-fuchsia-500 rounded-2xl p-4 mb-4 shadow-lg text-white active:scale-[0.98] transition">
                <p class="font-extrabold">📊 Recap minggu lu udah kelar!</p>
                <p class="text-xs opacity-80 mt-0.5">Liat seberapa konsisten lu minggu lalu ➜</p>
            </a>
        @endif

        {{-- HEADER: sapaan + gelar + rekor + level/XP + streak --}}
        <div class="flex items-center justify-between mb-4">
            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-500 dark:text-gray-400 truncate flex items-center gap-1.5">
                    <x-avatar :type="auth()->user()->avatar" class="w-6 h-6 shrink-0" />
                    Hai, {{ auth()->user()->name }} 👋
                    @if(auth()->user()->title)
                        <span class="inline-flex items-center gap-1 bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 text-[10px] font-bold px-2 py-0.5 rounded-full align-middle">
                            {{ auth()->user()->title->icon }} {{ auth()->user()->title->name }}
                        </span>
                    @endif
                </p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mb-1.5">🏆 Rekor: {{ auth()->user()->longest_streak }} hari</p>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-extrabold text-indigo-600 dark:text-indigo-400">Lv.{{ auth()->user()->level }}</span>
                    <div class="flex-1 h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full transition-all" style="width: {{ auth()->user()->xpProgress() }}%"></div>
                    </div>
                    <span class="text-[10px] text-gray-400 dark:text-gray-500 whitespace-nowrap">{{ auth()->user()->xp }}/{{ auth()->user()->xpForNextLevel() }} XP</span>
                </div>
            </div>
            <div class="bg-orange-100 dark:bg-orange-500/20 text-orange-600 dark:text-orange-400 rounded-full px-4 py-2 font-bold text-lg shadow-inner ml-3 shrink-0">
                🔥 {{ auth()->user()->current_streak }}
            </div>
        </div>

        {{-- BANNER RECOVERY: pet pingsan --}}
        @if($pet->status === 'fainted')
            <div class="bg-red-50 dark:bg-red-950/50 border-2 border-red-300 dark:border-red-700 rounded-2xl p-4 mb-4 text-center animate-pop animate-danger">
                <p class="font-bold text-red-600 dark:text-red-400">⚠️ Pet-mu pingsan!</p>
                <p class="text-sm text-red-500 dark:text-red-400/80 mb-3">Streak {{ auth()->user()->current_streak }} bisa diselametin. Sisa token: {{ auth()->user()->recovery_tokens }}/3</p>
                <form action="{{ route('checkin.recover') }}" method="POST">
                    @csrf
                    <button class="bg-red-500 hover:bg-red-600 active:scale-95 transition text-white font-bold py-2 px-6 rounded-full shadow-lg">
                        💘 PULIHKAN PET
                    </button>
                </form>
            </div>
        @endif
        {{-- AREA PET --}}
        <div class="bg-gradient-to-b from-indigo-50 to-purple-100 dark:from-indigo-950 dark:to-purple-950 rounded-3xl p-8 text-center shadow-lg mb-4">
            <div class="text-8xl animate-floaty select-none">{{ $pet->emoji() }}</div>
            <p class="mt-4 text-gray-600 dark:text-gray-300 italic">"{{ $phrase }}"</p>
            <a href="{{ route('share') }}"
                class="inline-block mt-4 text-xs font-bold text-indigo-600 dark:text-indigo-400 bg-white/70 dark:bg-gray-800/70 rounded-full px-4 py-1.5 shadow active:scale-95 transition">
                📣 Pamerin streak lu
            </a>
        </div>

        {{-- WARNING HARI BAHAYA --}}
        @if(!$checkedToday && $pet->status !== 'fainted' && now()->hour >= 21)
            <div class="bg-amber-50 dark:bg-amber-950/50 border border-amber-300 dark:border-amber-700 rounded-xl p-3 mb-4 text-sm text-amber-700 dark:text-amber-400 text-center">
                ⚠️ Pet-mu belum makan hari ini! Cepetan sebelum tengah malam 😰
            </div>
        @endif

        {{-- CHECK-IN + TIME CAPSULE --}}
        @if(!$checkedToday && $pet->status !== 'fainted')
            <form action="{{ route('checkin.store') }}" method="POST" class="mb-4">
                @csrf
                <input type="text" name="note" maxlength="140"
                    placeholder="Catet 1 kalimat hari ini... (time capsule ✨)"
                    class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 dark:placeholder-gray-500 mb-2 px-4 py-3 text-sm shadow-sm focus:ring-2 focus:ring-indigo-400">
                <button class="w-full bg-indigo-600 hover:bg-indigo-700 active:scale-95 transition text-white font-bold py-4 rounded-2xl shadow-lg text-lg">
                    ✅ CHECK-IN HARI INI
                </button>
            </form>
        @elseif($checkedToday)
            <div class="bg-green-50 dark:bg-green-950/50 border border-green-300 dark:border-green-700 rounded-2xl p-4 text-center text-green-700 dark:text-green-400 font-bold mb-4">
                ✓ Udah check-in! Ketemu lagi besok 😎
            </div>
        @endif

        {{-- LIST HABIT --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-4 mb-4">
            <h2 class="font-bold text-gray-700 dark:text-gray-200 mb-3">📋 Habit hari ini</h2>

            @forelse($habits as $habit)
                <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700 last:border-0">
                    <span class="{{ in_array($habit->id, $checkedHabitIds)
                        ? 'text-green-600 dark:text-green-400 font-semibold'
                        : 'text-gray-700 dark:text-gray-200' }}">
                        {{ $habit->category?->icon }} {{ $habit->name }}
                    </span>
                    <div class="flex items-center gap-2 shrink-0">
                        @if(!in_array($habit->id, $checkedHabitIds))
                            <form action="{{ route('habits.toggle', $habit) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button class="w-8 h-8 rounded-full border-2 border-indigo-300 dark:border-indigo-500 hover:bg-indigo-100 dark:hover:bg-indigo-950 active:scale-90 transition">✓</button>
                            </form>
                        @else
                            <span class="w-8 h-8 rounded-full bg-green-100 dark:bg-green-900/60 text-green-600 dark:text-green-400 flex items-center justify-center font-bold" title="Selesai hari ini">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                            </span>
                        @endif
                        <form action="{{ route('habits.destroy', $habit) }}" method="POST"
                            onsubmit="return confirm('Hapus habit "{{ $habit->name }}"? Riwayat check-in-nya tetep tersimpan.')">
                            @csrf
                            @method('DELETE')
                            <button class="w-8 h-8 rounded-full text-gray-300 dark:text-gray-600 hover:text-red-500 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/50 active:scale-90 transition flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-400 dark:text-gray-500 text-sm">Belum ada habit. Pencet tombol + di bawah! 👇</p>
            @endforelse
        </div>
    </div>

    {{-- POPUP MILESTONE + KONFETI --}}
    @if($milestone)
        @for($i = 0; $i < 24; $i++)
            <span class="confetti" style="left: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 15) / 10 }}s">
                {{ ['🎉', '✨', '🔥', '⭐'][$i % 4] }}
            </span>
        @endfor

        <div class="fixed inset-0 bg-black/60 z-40 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 text-center max-w-xs w-full animate-pop">
                <p class="text-2xl font-extrabold text-indigo-600 dark:text-indigo-400 mb-2">🎉 MILESTONE!</p>
                <div class="text-7xl my-4">{{ $pet->emoji() }}</div>
                <p class="font-bold text-lg text-gray-800 dark:text-gray-100">{{ $milestone }} HARI BERTURUT-TURUT!</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 mb-4">Pet-mu naik level! Makin keren 🔥</p>
                <a href="{{ route('dashboard') }}"
                    class="block bg-indigo-600 text-white font-bold py-3 rounded-xl hover:bg-indigo-700">
                    Lanjut ➜
                </a>
            </div>
        </div>
    @endif

    {{-- POPUP LEVEL UP --}}
    @if(session('level_up'))
        @for($i = 0; $i < 24; $i++)
            <span class="confetti" style="left: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 15) / 10 }}s">
                {{ ['🎊', '💜', '⭐', '✨'][$i % 4] }}
            </span>
        @endfor

        <div class="fixed inset-0 bg-black/60 z-40 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 text-center max-w-xs w-full animate-pop">
                <p class="text-2xl font-extrabold text-purple-600 dark:text-purple-400 mb-2">⬆️ LEVEL UP!</p>
                <div class="text-7xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-purple-500 my-4">
                    {{ session('level_up') }}
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Makin deket jadi versi terbaik diri lu 🔥</p>
                <a href="{{ route('dashboard') }}"
                    class="block bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold py-3 rounded-xl hover:opacity-90">
                    Gas terus ➜
                </a>
            </div>
        </div>
    @endif

    {{-- POPUP BADGE BARU --}}
    @if(session('new_badge'))
        @for($i = 0; $i < 20; $i++)
            <span class="confetti" style="left: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 15) / 10 }}s">
                {{ ['🏅', '⭐', '✨'][$i % 3] }}
            </span>
        @endfor

        <div class="fixed inset-0 bg-black/60 z-40 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 text-center max-w-xs w-full animate-pop">
                <p class="text-xl font-extrabold text-amber-500 mb-2">🏅 BADGE BARU!</p>
                <div class="text-7xl my-4">{{ session('new_badge')->icon }}</div>
                <p class="font-bold text-lg text-gray-800 dark:text-gray-100">{{ session('new_badge')->title?->name }}</p>
                <p class="font-bold text-lg text-gray-800 dark:text-gray-100">{{ session('new_badge')->name }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 mb-4">{{ session('new_badge')->description }}</p>
                <a href="{{ route('badges.index') }}"
                    class="block bg-amber-500 text-white font-bold py-3 rounded-xl hover:bg-amber-600">
                    Liat koleksi 🏆
                </a>
            </div>
        </div>
    @endif

    {{-- FAB: tambah habit --}}
    <button onclick="document.getElementById('habit-modal').classList.remove('hidden')"
        class="fixed bottom-24 right-4 z-40 w-14 h-14 rounded-full bg-indigo-600 hover:bg-indigo-700 text-white shadow-xl shadow-indigo-600/30 flex items-center justify-center active:scale-90 transition"
        aria-label="Tambah habit">
        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
    </button>

    {{-- MODAL: form tambah habit --}}
    <div id="habit-modal" class="{{ $errors->has('name') || $errors->has('category_id') ? '' : 'hidden' }} fixed inset-0 z-50 bg-black/60 flex items-end sm:items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 w-full max-w-md rounded-3xl p-6 shadow-2xl animate-pop">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-extrabold text-lg text-gray-800 dark:text-gray-100">➕ Habit baru</h2>
                <button onclick="document.getElementById('habit-modal').classList.add('hidden')"
                    class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-400 active:scale-90 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('habits.store') }}" method="POST" class="space-y-3">
                @csrf
                <div>
                    <label class="text-xs font-bold text-gray-500 dark:text-gray-400 mb-1 block">KATEGORI</label>
                    <select name="category_id" required
                        class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 px-3 py-3 text-sm focus:ring-2 focus:ring-indigo-400">
                        <option value="" disabled selected>Pilih kategori...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                {{ $category->icon }} {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-500 dark:text-gray-400 mb-1 block">NAMA HABIT</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Misal: Baca buku 30 menit" required
                        class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-500 px-3 py-3 text-sm focus:ring-2 focus:ring-indigo-400">
                    @error('name')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button class="w-full bg-indigo-600 hover:bg-indigo-700 active:scale-95 transition text-white font-bold py-3.5 rounded-xl shadow-lg">
                    Simpan habit 🚀
                </button>
            </form>
        </div>
    </div>
</x-app-layout>