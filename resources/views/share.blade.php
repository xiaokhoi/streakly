<x-app-layout>
    <style>
        @keyframes floaty { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        .animate-floaty { animation: floaty 3s ease-in-out infinite; }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

    <div class="max-w-2xl mx-auto px-3 pt-4">
        <h1 class="text-lg font-extrabold text-gray-900 dark:text-gray-100 mb-1">Pamerin streak lu</h1>
        <p class="text-xs text-gray-400 mb-3">Simpan sebagai gambar atau share langsung</p>

        {{-- ===== KARTU SHARE (kuning pekat, buat screenshot) ===== --}}
        <div id="share-card" class="rounded-lg overflow-hidden shadow-2xl mb-4 bg-yellow-400 p-6 text-gray-900 text-center">
            <p class="text-[11px] font-extrabold uppercase tracking-widest opacity-70">streakly</p>

            <div class="text-6xl my-4 animate-floaty">{{ $user->pet?->emoji() ?? '🥚' }}</div>

            <p class="text-5xl font-extrabold leading-none">{{ $user->current_streak }}</p>
            <p class="text-[11px] font-extrabold uppercase tracking-widest opacity-70 mt-1">hari streak</p>

            <div class="mt-5 bg-gray-900 rounded-full px-4 py-3 flex items-center justify-around text-white">
                <div>
                    <p class="text-base font-extrabold leading-none">Lv.{{ $user->level }}</p>
                    <p class="text-[9px] opacity-60 uppercase mt-0.5">Level</p>
                </div>
                <div class="w-px h-7 bg-white/20"></div>
                <div>
                    <p class="text-base font-extrabold leading-none">{{ $user->longest_streak }}</p>
                    <p class="text-[9px] opacity-60 uppercase mt-0.5">Rekor</p>
                </div>
                <div class="w-px h-7 bg-white/20"></div>
                <div>
                    <p class="text-base font-extrabold leading-none">{{ count($user->badges) }}</p>
                    <p class="text-[9px] opacity-60 uppercase mt-0.5">Badge</p>
                </div>
            </div>

            <p class="mt-4 font-extrabold text-sm">
                {{ $user->name }}
                @if($user->title)
                    · {{ $user->title->icon }} {{ $user->title->name }}
                @endif
            </p>
            <p class="text-[10px] opacity-60 mt-2">Bikin streak lu sendiri → streakly</p>
        </div>
        {{-- ===== /KARTU ===== --}}

        {{-- TOMBOL AKSI --}}
        <button onclick="downloadCard()"
            class="w-full bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-bold py-3.5 rounded-full mb-2 active:scale-95 transition text-sm">
            Simpan sebagai gambar
        </button>

        <div class="grid grid-cols-2 gap-2 mb-4">
            <button onclick="shareCard()"
                class="border border-gray-300 dark:border-neutral-700 text-gray-700 dark:text-gray-200 font-bold py-3.5 rounded-full hover:bg-gray-100 dark:hover:bg-neutral-800 active:scale-95 transition text-sm">
                Bagikan
            </button>
            <button onclick="copyCaption()"
                class="border border-gray-300 dark:border-neutral-700 text-gray-700 dark:text-gray-200 font-bold py-3.5 rounded-full hover:bg-gray-100 dark:hover:bg-neutral-800 active:scale-95 transition text-sm">
                Salin caption
            </button>
        </div>

        <p id="copy-feedback" class="text-center text-xs font-bold text-yellow-500 opacity-0 transition-opacity mb-4">
            ✓ Caption tersalin!
        </p>

        <a href="{{ route('dashboard') }}" class="block text-center text-xs text-gray-400">← Balik ke dashboard</a>
    </div>

    <script>
        async function downloadCard() {
            const el = document.getElementById('share-card');
            const btn = event.target.closest('button');
            const originalText = btn.innerHTML;
            btn.innerHTML = 'Nyiapin gambar...';
            btn.disabled = true;
            try {
                const canvas = await html2canvas(el, { scale: 2, backgroundColor: null, useCORS: true });
                const link = document.createElement('a');
                link.download = 'streakly-{{ $user->current_streak }}-hari.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            } catch (e) {
                alert('Gagal bikin gambar. Screenshot manual aja ya 😅');
            } finally {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        }

        const caption = () =>
            `🔥 Streak {{ $user->current_streak }} hari di streakly! Lv.{{ $user->level }}, {{ count($user->badges) }} badge. Berani saingin? 👀`;

        async function shareCard() {
            const data = { title: 'streakly', text: caption() };
            if (navigator.share) {
                try { await navigator.share(data); } catch (e) {}
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
                if (viaFallback) alert('HP lu gak support share menu — caption udah dicopy!');
            } catch (e) {
                alert('Gagal copy. Screenshot kartunya aja 😄');
            }
        }
    </script>
</x-app-layout>