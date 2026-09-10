<x-app-layout>
    <style>
        @keyframes floaty { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-12px); } }
        @keyframes pop { 0% { transform: scale(0.5); opacity: 0; } 70% { transform: scale(1.1); } 100% { transform: scale(1); opacity: 1; } }
        @keyframes fall { 0% { transform: translateY(-10vh) rotate(0deg); opacity: 1; } 100% { transform: translateY(110vh) rotate(360deg); opacity: 0; } }
        .animate-floaty { animation: floaty 3s ease-in-out infinite; }
        .animate-pop { animation: pop .5s ease-out; }
        .confetti { position: fixed; top: -5vh; font-size: 1.2rem; animation: fall 3s linear forwards; pointer-events: none; z-index: 50; }
    </style>

    <div class="max-w-2xl mx-auto px-3 pt-4">

        {{-- BANNER: ADOPT --}}
        @if(session('adopted'))
            <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-3 mb-3 text-sm flex items-center gap-2">
                <svg class="w-5 h-5 text-yellow-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                <span>"{{ session('adopted') }}" masuk ke list habit lu</span>
            </div>
        @endif

        {{-- BANNER: UDAH DIPUNYA --}}
        @if(session('alreadyOwned'))
            <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-3 mb-3 text-sm flex items-center gap-2">
                <svg class="w-5 h-5 text-yellow-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" /></svg>
                <span>Lu udah punya habit "{{ session('alreadyOwned') }}"</span>
            </div>
        @endif

        {{-- BANNER: TERHAPUS --}}
        @if(session('deleted'))
            <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-3 mb-3 text-sm flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                <span>Habit "{{ session('deleted') }}" dihapus</span>
            </div>
        @endif

        {{-- ===== KARTU PET + CHECK-IN ===== --}}
        <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg mb-3 overflow-hidden hover:border-gray-400 dark:hover:border-neutral-700 transition">

            <div class="flex items-center gap-2 px-3 py-2.5 text-xs text-gray-500">
                <div class="w-6 h-6 rounded-full bg-yellow-400 flex items-center justify-center overflow-hidden">
                    <x-avatar :type="$pet->stage === 0 ? 'sun' : 'cat'" class="w-5 h-5" />
                </div>
                <span class="font-bold text-gray-700 dark:text-gray-300">r/petmu</span>
                <span>•</span>
                <span>naik level tiap milestone streak</span>
            </div>

            <div class="px-4 pb-2 text-center">
                <div class="text-7xl animate-floaty select-none py-4">{{ $pet->emoji() }}</div>
                <p class="text-sm text-gray-500 dark:text-gray-400 italic">"{{ $phrase }}"</p>
            </div>

            @if($pet->status === 'fainted')
                <div class="mx-3 mb-3 bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-900 rounded-lg p-3 text-center">
                    <p class="text-sm font-bold text-red-600 dark:text-red-400">Pet pingsan — streak {{ auth()->user()->current_streak }} bisa diselametin</p>
                    <p class="text-xs text-red-400 mt-0.5 mb-2.5">Sisa token: {{ auth()->user()->recovery_tokens }}/3</p>
                    <form action="{{ route('checkin.recover') }}" method="POST">
                        @csrf
                        <button class="bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-bold text-sm py-2 px-5 rounded-full">Pulihkan</button>
                    </form>
                </div>
            @endif

            <div class="flex items-center gap-2 px-3 py-2 border-t border-gray-100 dark:border-neutral-800">
                @if(!$checkedToday && $pet->status !== 'fainted')
                    <form action="{{ route('checkin.store') }}" method="POST" class="flex-1 flex gap-2">
                        @csrf
                        <input type="text" name="note" maxlength="140" placeholder="Tulis 1 kalimat hari ini (opsional)..."
                            class="flex-1 bg-gray-100 dark:bg-neutral-800 rounded-full px-4 text-sm outline-none focus:ring-2 focus:ring-yellow-400 dark:text-gray-100 dark:placeholder-gray-500">
                        <button class="bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-bold text-sm px-5 rounded-full active:scale-95 transition whitespace-nowrap">
                            Check-in
                        </button>
                    </form>
                @elseif($checkedToday)
                    <div class="flex-1 flex items-center gap-2 text-sm">
                        <span class="flex items-center gap-1.5 font-bold text-yellow-600 dark:text-yellow-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                            Udah check-in
                        </span>
                        <span class="text-gray-400 text-xs">• besok lagi ya</span>
                    </div>
                @else
                    <div class="flex-1 text-sm text-gray-400">Pulihkan pet dulu buat check-in</div>
                @endif

                <div class="flex items-center gap-1 bg-gray-100 dark:bg-neutral-800 rounded-full px-3 py-1.5">
                    <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 24 24"><path d="M13.5.67s.74 2.65.74 4.8c0 2.06-1.35 3.73-3.41 3.73-2.07 0-3.63-1.67-3.63-3.73l.03-.36C5.21 7.51 4 10.62 4 14c0 4.42 3.58 8 8 8s8-3.58 8-8C20 8.61 17.41 3.8 13.5.67z"/></svg>
                    <span class="text-sm font-bold">{{ auth()->user()->current_streak }}</span>
                </div>
            </div>
        </div>

        {{-- WARNING MALAM --}}
        @if(!$checkedToday && $pet->status !== 'fainted' && now()->hour >= 21)
            <div class="bg-yellow-50 dark:bg-yellow-950/30 border border-yellow-300 dark:border-yellow-800 rounded-lg p-3 mb-3 text-sm text-yellow-800 dark:text-yellow-300 flex items-center gap-2">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" /></svg>
                Pet-mu belum diberi makan hari ini — mepet jam 12!
            </div>
        @endif

        {{-- ===== FEED HABIT ===== --}}
        <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg mb-3">
            <div class="flex items-center justify-between px-3 py-2.5 border-b border-gray-100 dark:border-neutral-800">
                <h2 class="text-xs font-bold uppercase tracking-wide text-gray-500">Habit hari ini</h2>
                <span class="text-xs text-gray-400">{{ $checkedHabitIds ? count($checkedHabitIds) : 0 }}/{{ $habits->count() }}</span>
            </div>

            @forelse($habits as $habit)
                @php $done = in_array($habit->id, $checkedHabitIds); @endphp
                <div class="flex items-center gap-2 px-2 py-2.5 border-b border-gray-50 dark:border-neutral-800 last:border-0 hover:bg-gray-50 dark:hover:bg-neutral-800/50 transition">
                    @if(!$done)
                        <form action="{{ route('habits.toggle', $habit) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button class="w-9 h-9 rounded-md hover:bg-yellow-100 dark:hover:bg-yellow-950/40 flex items-center justify-center text-gray-400 hover:text-yellow-500 transition" aria-label="Centang">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                            </button>
                        </form>
                    @else
                        <div class="w-9 h-9 flex items-center justify-center text-yellow-500">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                        </div>
                    @endif

                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium {{ $done ? 'text-gray-400' : 'text-gray-900 dark:text-gray-100' }} truncate">{{ $habit->name }}</p>
                        <p class="text-[11px] text-gray-400">{{ $habit->category?->icon }} {{ $habit->category?->name ?? 'Tanpa kategori' }}</p>
                    </div>

                    <form action="{{ route('habits.destroy', $habit) }}" method="POST"
                        onsubmit="return confirm('Hapus habit "{{ $habit->name }}"?')">
                        @csrf
                        @method('DELETE')
                        <button class="w-8 h-8 rounded-md hover:bg-red-50 dark:hover:bg-red-950/40 flex items-center justify-center text-gray-300 dark:text-gray-600 hover:text-red-500 transition" aria-label="Hapus">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                        </button>
                    </form>
                </div>
            @empty
                <p class="text-gray-400 text-sm text-center py-6">Belum ada habit — pencet + di bawah</p>
            @endforelse
        </div>

        {{-- ===== MENU CEPAT: recap + share ===== --}}
        <div class="grid grid-cols-2 gap-3 mb-3">
            <a href="{{ route('recap.show') }}"
                class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-3.5 flex items-center gap-2.5 hover:border-yellow-400 dark:hover:border-yellow-600 transition">
                <svg class="w-5 h-5 text-yellow-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" /></svg>
                <span class="text-sm font-bold text-gray-900 dark:text-gray-100">Recap</span>
            </a>

            <a href="{{ route('share') }}"
                class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-3.5 flex items-center gap-2.5 hover:border-yellow-400 dark:hover:border-yellow-600 transition">
                <svg class="w-5 h-5 text-yellow-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" /></svg>
                <span class="text-sm font-bold text-gray-900 dark:text-gray-100">Share</span>
            </a>
        </div>

        {{-- BANNER RECAP SENIN --}}
        @if(now()->isMonday())
            <a href="{{ route('recap.show') }}" class="block bg-white dark:bg-neutral-900 border border-yellow-400 dark:border-yellow-600 rounded-lg p-3.5 mb-3 hover:bg-yellow-50 dark:hover:bg-yellow-950/20 transition">
                <p class="text-sm font-bold flex items-center gap-2">
                    <svg class="w-5 h-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" /></svg>
                    Recap mingguan lu udah kelar
                </p>
                <p class="text-xs text-gray-400 mt-0.5">Liat seberapa konsisten lu minggu lalu</p>
            </a>
        @endif

        <div class="pb-4"></div>
    </div>

    {{-- POPUP MILESTONE --}}
    @if($milestone)
        @for($i = 0; $i < 24; $i++)
            <span class="confetti" style="left: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 15) / 10 }}s">{{ ['🎉','✨','⭐'][$i % 3] }}</span>
        @endfor
        <div class="fixed inset-0 bg-black/70 z-[60] flex items-center justify-center p-4">
            <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-700 rounded-2xl p-8 text-center max-w-xs w-full animate-pop">
                <p class="text-[11px] font-extrabold text-yellow-500 uppercase tracking-widest">Milestone</p>
                <div class="text-6xl font-extrabold my-3 text-gray-900 dark:text-white">{{ $milestone }}</div>
                <p class="text-sm font-bold text-gray-700 dark:text-gray-200">hari streak!</p>
                <div class="text-5xl my-4">{{ $pet->emoji() }}</div>
                <p class="text-sm text-gray-400 mb-5">Pet-mu berevolusi</p>
                <a href="{{ route('dashboard') }}" class="block bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-bold py-3 rounded-full">Lanjut</a>
            </div>
        </div>
    @endif

    {{-- POPUP LEVEL UP --}}
    @if(session('level_up'))
        @for($i = 0; $i < 24; $i++)
            <span class="confetti" style="left: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 15) / 10 }}s">{{ ['🎉','✨','⭐'][$i % 3] }}</span>
        @endfor
        <div class="fixed inset-0 bg-black/70 z-[60] flex items-center justify-center p-4">
            <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-700 rounded-2xl p-8 text-center max-w-xs w-full animate-pop">
                <p class="text-[11px] font-extrabold text-yellow-500 uppercase tracking-widest">Level up</p>
                <div class="text-6xl font-extrabold text-gray-900 dark:text-white my-4">{{ session('level_up') }}</div>
                <p class="text-sm text-gray-400 mb-5">Makin deket ke versi terbaik lu</p>
                <a href="{{ route('dashboard') }}" class="block bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-bold py-3 rounded-full">Gas terus</a>
            </div>
        </div>
    @endif

    {{-- POPUP BADGE BARU --}}
    @if(session('new_badge'))
        @for($i = 0; $i < 20; $i++)
            <span class="confetti" style="left: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 15) / 10 }}s">{{ ['🎉','✨','⭐'][$i % 3] }}</span>
        @endfor
        <div class="fixed inset-0 bg-black/70 z-[60] flex items-center justify-center p-4">
            <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-700 rounded-2xl p-8 text-center max-w-xs w-full animate-pop">
                <p class="text-[11px] font-extrabold text-yellow-500 uppercase tracking-widest">Badge baru</p>
                <div class="text-6xl my-4">{{ session('new_badge')['icon'] }}</div>
                <p class="text-lg font-extrabold text-gray-900 dark:text-gray-100">{{ session('new_badge')['name'] }}</p>
                <p class="text-sm text-gray-400 mt-1 mb-5">{{ session('new_badge')['description'] }}</p>
                <a href="{{ route('badges.index') }}" class="block bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-bold py-3 rounded-full">Liat koleksi</a>
            </div>
        </div>
    @endif

    {{-- FAB --}}
    <button onclick="document.getElementById('habit-modal').classList.remove('hidden')"
        class="fixed bottom-20 right-4 z-40 w-14 h-14 rounded-full bg-yellow-400 hover:bg-yellow-300 text-gray-900 shadow-xl shadow-yellow-400/30 flex items-center justify-center active:scale-90 transition"
        aria-label="Tambah habit">
        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
    </button>

    {{-- MODAL HABIT --}}
    <div id="habit-modal" class="{{ $errors->has('name') || $errors->has('category_id') ? '' : 'hidden' }} fixed inset-0 z-[60] bg-black/70 flex items-end sm:items-center justify-center p-4">
        <div class="bg-white dark:bg-neutral-900 w-full max-w-md rounded-2xl p-6 shadow-2xl animate-pop border border-gray-300 dark:border-neutral-700">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-extrabold text-gray-900 dark:text-gray-100">Buat habit baru</h2>
                <button onclick="document.getElementById('habit-modal').classList.add('hidden')"
                    class="w-8 h-8 rounded-full bg-gray-100 dark:bg-neutral-800 flex items-center justify-center text-gray-400 active:scale-90 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <form action="{{ route('habits.store') }}" method="POST" class="space-y-3">
                @csrf
                <div>
                    <label class="text-[11px] font-bold text-gray-400 mb-1 block uppercase tracking-wide">Kategori</label>
                    <select name="category_id" required class="w-full rounded-lg border-gray-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-gray-100 px-3 py-3 text-sm focus:ring-2 focus:ring-yellow-400">
                        <option value="" disabled selected>Pilih kategori...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->icon }} {{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-[11px] font-bold text-gray-400 mb-1 block uppercase tracking-wide">Nama habit</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Misal: Baca buku 30 menit" required
                        class="w-full rounded-lg border-gray-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-gray-100 dark:placeholder-gray-500 px-3 py-3 text-sm focus:ring-2 focus:ring-yellow-400">
                    @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <button class="w-full bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-bold py-3.5 rounded-full">Posting habit</button>
            </form>
        </div>
    </div>
</x-app-layout>