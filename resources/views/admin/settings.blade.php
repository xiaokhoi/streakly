<x-app-layout>
    <div class="max-w-2xl mx-auto px-3 pt-4">
        <h1 class="text-lg font-extrabold text-gray-900 dark:text-gray-100 mb-1">⚙️ Admin · Aturan Game</h1>
        <p class="text-xs text-gray-400 mb-3">Ubah balance app tanpa sentuh kode. Berlaku langsung ke SEMUA user.</p>

        <x-admin-tabs />

        @if(session('settingsSaved'))
            <div class="bg-white dark:bg-neutral-900 border border-yellow-400 dark:border-yellow-600 rounded-lg p-3 mb-3 text-sm flex items-center gap-2">
                <svg class="w-5 h-5 text-yellow-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                Pengaturan tersimpan & langsung aktif!
            </div>
        @endif

        <form action="{{ route('admin.settings.store') }}" method="POST" class="space-y-3">
            @csrf

            <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-4">
                <h2 class="text-xs font-bold uppercase tracking-wide text-gray-500 mb-3">Streak & Pemulihan</h2>

                <div class="space-y-3">
                    <div>
                        <label class="text-xs font-bold text-gray-600 dark:text-gray-300 block mb-1">{{ \App\Services\GameSettings::DEFS['recovery_tokens'][0] }}</label>
                        <input type="number" name="recovery_tokens" min="0" max="99" value="{{ $values['recovery_tokens'] }}"
                            class="w-24 rounded-lg border-gray-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-gray-100 px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-600 dark:text-gray-300 block mb-1">{{ \App\Services\GameSettings::DEFS['hard_days_limit'][0] }}</label>
                        <input type="number" name="hard_days_limit" min="0" max="99" value="{{ $values['hard_days_limit'] }}"
                            class="w-24 rounded-lg border-gray-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-gray-100 px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-600 dark:text-gray-300 block mb-1">{{ \App\Services\GameSettings::DEFS['milestones'][0] }}</label>
                        <input type="text" name="milestones" value="{{ $values['milestones'] }}"
                            class="w-full rounded-lg border-gray-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-gray-100 px-3 py-2 text-sm">
                        <p class="text-[10px] text-gray-400 mt-1">⚠️ Milestone baru GAK otomatis punya badge & evolusi pet — itu tetap perlu ditambahkan di kode & seeder. Angka di sini mengikuti yang ada.</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-4">
                <h2 class="text-xs font-bold uppercase tracking-wide text-gray-500 mb-3">Chat Streak</h2>

                <div>
                    <label class="text-xs font-bold text-gray-600 dark:text-gray-300 block mb-1">{{ \App\Services\GameSettings::DEFS['chat_streak_miss_days'][0] }}</label>
                    <input type="number" name="chat_streak_miss_days" min="1" max="7" value="{{ $values['chat_streak_miss_days'] }}"
                        class="w-24 rounded-lg border-gray-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-gray-100 px-3 py-2 text-sm">
                    <p class="text-[10px] text-gray-400 mt-1">1 = bolong 1 hari hangus (ketat). 2 = bolong 2 hari baru hangus (santai).</p>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-4">
                <h2 class="text-xs font-bold uppercase tracking-wide text-gray-500 mb-3">Ekonomi XP</h2>

                <div class="grid grid-cols-3 gap-2">
                    <div>
                        <label class="text-[10px] font-bold text-gray-400 block mb-1 uppercase">Check-in app</label>
                        <input type="number" name="xp_checkin_app" min="0" value="{{ $values['xp_checkin_app'] }}"
                            class="w-full rounded-lg border-gray-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-gray-100 px-2 py-2 text-sm text-center">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-gray-400 block mb-1 uppercase">Habit</label>
                        <input type="number" name="xp_checkin_habit" min="0" value="{{ $values['xp_checkin_habit'] }}"
                            class="w-full rounded-lg border-gray-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-gray-100 px-2 py-2 text-sm text-center">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-gray-400 block mb-1 uppercase">Milestone</label>
                        <input type="number" name="xp_milestone" min="0" value="{{ $values['xp_milestone'] }}"
                            class="w-full rounded-lg border-gray-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-gray-100 px-2 py-2 text-sm text-center">
                    </div>
                </div>
            </div>

            <button class="w-full bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-bold py-3.5 rounded-full text-sm active:scale-95 transition">
                Simpan semua pengaturan
            </button>
        </form>

        <div class="pb-4"></div>
    </div>
</x-app-layout>