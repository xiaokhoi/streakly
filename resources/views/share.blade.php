<x-app-layout>
    <style>
        @keyframes floaty { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        .animate-floaty { animation: floaty 3s ease-in-out infinite; }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

    <div class="py-6 max-w-md mx-auto px-4">
        <h1 class="text-xl font-extrabold text-gray-800 dark:text-gray-100 mb-1">📣 Share streak lu</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Screenshot kartunya, pamerin ke temen-temen 😎</p>

        {{-- ===== KARTU SHARE ===== --}}
        <div id="share-card" class="rounded-3xl overflow-hidden shadow-2xl mb-4 bg-gradient-to-br from-indigo-600 via-purple-600 to-fuchsia-600 p-6 text-white text-center">
            <p class="text-xs font-bold tracking-widest uppercase opacity-80">HabitPet</p>

            <div class="text-7xl my-4 animate-floaty">{{ $user->pet?->emoji() ?? '🥚' }}</div>

            <p class="text-5xl font-extrabold leading-none">🔥 {{ $user->current_streak }}</p>
            <p class="text-sm font-bold uppercase tracking-widest opacity-80 mt-1">hari berturut-turut</p>

            <div class="mt-5 bg-white/15 rounded-2xl px-4 py-3 flex items-center justify-around">
                <div>
                    <p class="text-lg font-extrabold">Lv.{{ $user->level }}</p>
                    <p class="text-[10px] opacity-70 uppercase">Level</p>
                </div>
                <div class="w-px h-8 bg-white/25"></div>
                <div>
                    <p class="text-lg font-extrabold">{{ $user->longest_streak }}</p>
                    <p class="text-[10px] opacity-70 uppercase">Rekor</p>
                </div>
                <div class="w-px h-8 bg-white/25"></div>
                <div>
                    <p class="text-lg font-extrabold">{{ count($user->badges) }} 🏅</p>
                    <p class="text-[10px] opacity-70 uppercase">Badge</p>
                </div>
            </div>

            <p class="mt-4 font-bold">
                {{ $user->name }}
                @if($user->title)
                    · {{ $user->title->icon }} {{ $user->title->name }}
                @endif
            </p>
            <p class="text-[10px] opacity-60 mt-2">Bikin streak lu sendiri → HabitPet</p>
        </div>
        {{-- ===== /KARTU SHARE ===== --}}

                {{-- TOMBOL AKSI --}}
        <button onclick="downloadCard()"
            class="w-full bg-gradient-to-r from-pink-500 to-rose-500 hover:opacity-90 active:scale-95 transition text-white font-bold py-4 rounded-xl shadow-lg mb-2">
            🖼️ Simpan sebagai gambar
        </button>

        <div class="grid grid-cols-2 gap-2 mb-4">
            <button onclick="shareCard()"
                class="bg-indigo-600 hover:bg-indigo-700 active:scale-95 transition text-white font-bold py-3.5 rounded-xl shadow-lg text-sm">
                📤 Bagikan
            </button>
            <button onclick="copyCaption()"
                class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 active:scale-95 transition text-indigo-600 dark:text-indigo-400 font-bold py-3.5 rounded-xl shadow border border-indigo-200 dark:border-indigo-800 text-sm">
                📋 Salin caption
            </button>
        </div>

        <p id="copy-feedback" class="text-center text-xs text-green-600 dark:text-green-400 font-bold opacity-0 transition-opacity mb-4">
            ✓ Caption tersalin!
        </p>

        <a href="{{ route('dashboard') }}" class="block text-center text-xs text-gray-400 dark:text-gray-500">
            ← Kembali ke dashboard
        </a>
    </div>

    <script>
        async function downloadCard() {
            const el = document.getElementById('share-card');
            const btn = event.target.closest('button');
            const originalText = btn.innerHTML;
            btn.innerHTML = '⏳ Nyiapin gambar...';
            btn.disabled = true;

            try {
                const canvas = await html2canvas(el, {
                    scale: 2,              // resolusi 2x biar tajam
                    backgroundColor: null,  // transparan di luar kartu
                    useCORS: true,
                });

                const link = document.createElement('a');
                link.download = 'habitpet-streak-{{ $user->current_streak }}-hari.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            } catch (e) {
                alert('Gagal bikin gambar. Screenshot manual aja dulu ya 😅');
            } finally {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        }

        const caption = () =>
            `🔥 Streak {{ $user->current_streak }} hari berturut-turut di HabitPet! ` +
            `Lv.{{ $user->level }}, {{ count($user->badges) }} badge, dan pet-mu makin keren 🐣\n` +
            `Berani saingin streak gue? 👀`;

        async function shareCard() {
            const data = { title: 'HabitPet', text: caption() };
            if (navigator.share) {
                try { await navigator.share(data); } catch (e) { /* user batal share, biarkan */ }
            } else {
                copyCaption(true);
            }
        }

        async function copyCaption(viaFallback = false) {
            try {
                await navigator.clipboard.writeText(caption());
                const fb = document.getElementById('copy-feedback');
                fb.style.opacity = '1';
                setTimeout(() => fb.style.opacity = '0', 2000);
                if (viaFallback) alert('HP lu gak support share menu — caption udah dicopy, tinggal paste + screenshot kartunya! 📸');
            } catch (e) {
                alert('Gagal copy. Screenshot kartunya aja terus share manual 😄');
            }
        }
    </script>
</x-app-layout>