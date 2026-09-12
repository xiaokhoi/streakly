<x-app-layout>
    <div class="max-w-2xl mx-auto px-3 pt-4">
        <h1 class="text-lg font-extrabold text-gray-900 dark:text-gray-100 mb-3">⚙️ Pengaturan</h1>

        {{-- BANNER --}}
        @if(session('profileUpdated'))
            <div class="bg-white dark:bg-neutral-900 border border-yellow-400 dark:border-yellow-600 rounded-lg p-3 mb-3 text-sm flex items-center gap-2">
                <svg class="w-5 h-5 text-yellow-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                Profil keupdate!
            </div>
        @endif
        @if(session('passwordChanged'))
            <div class="bg-white dark:bg-neutral-900 border border-yellow-400 dark:border-yellow-600 rounded-lg p-3 mb-3 text-sm flex items-center gap-2">
                <svg class="w-5 h-5 text-yellow-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                Password keganti!
            </div>
        @endif

        {{-- TEMA --}}
        <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-3.5 mb-3">
            <h2 class="text-xs font-bold uppercase tracking-wide text-gray-500 mb-3">Tampilan</h2>
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-700 dark:text-gray-200">Mode gelap</p>
                <button onclick="
                        const el = document.documentElement;
                        const dark = el.classList.toggle('dark');
                        localStorage.setItem('theme', dark ? 'dark' : 'light');"
                    class="relative w-12 h-7 rounded-full bg-gray-300 dark:bg-yellow-400 transition-colors">
                    <span class="absolute top-1 left-1 w-5 h-5 rounded-full bg-white shadow transition-transform dark:translate-x-5"></span>
                </button>
            </div>
        </div>

        {{-- PROFIL --}}
        <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-3.5 mb-3">
            <h2 class="text-xs font-bold uppercase tracking-wide text-gray-500 mb-3">Profil</h2>

            {{-- INFO AVATAR GRAVATAR --}}
            <div class="flex items-center gap-3 mb-4 bg-gray-50 dark:bg-neutral-800 rounded-lg p-3">
                <x-avatar :email="auth()->user()->email" class="w-14 h-14 shrink-0" />
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Avatar otomatis dari <a href="https://gravatar.com" target="_blank" class="underline font-bold text-yellow-600 dark:text-yellow-400">Gravatar</a> — pakai email akun lu.
                    Belum ada foto? Daftar di sana pake email yang sama, foto muncul di sini otomatis.
                </p>
            </div>

            <form action="{{ route('settings.profile') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="text-[11px] font-bold text-gray-400 mb-1 block uppercase tracking-wide">Nama</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                        class="w-full rounded-lg border-gray-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-gray-100 px-3 py-2.5 text-sm">
                    @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-[11px] font-bold text-gray-400 mb-1 block uppercase tracking-wide">Username</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">@</span>
                        <input type="text" name="username" value="{{ old('username', auth()->user()->username) }}" required
                            class="w-full rounded-lg border-gray-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-gray-100 pl-7 pr-3 py-2.5 text-sm">
                    </div>
                    @error('username')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-[11px] font-bold text-gray-400 mb-1 block uppercase tracking-wide">Email</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                        class="w-full rounded-lg border-gray-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-gray-100 px-3 py-2.5 text-sm">
                    @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    <p class="text-[10px] text-gray-400 mt-1">⚠️ Ganti email = avatar Gravatar & login email ikut berubah.</p>
                </div>

                <button class="w-full bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-bold py-3 rounded-full text-sm">Simpan profil</button>
            </form>
        </div>

        {{-- PASSWORD + ZONA BAHAYA — cuma user non-Google --}}
        @if(auth()->user()->google_id === null)
            <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-3.5 mb-3">
                <h2 class="text-xs font-bold uppercase tracking-wide text-gray-500 mb-3">Ganti password</h2>

                <form action="{{ route('settings.password') }}" method="POST" class="space-y-3">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="text-[11px] font-bold text-gray-400 mb-1 block uppercase tracking-wide">Password sekarang</label>
                        <input type="password" name="current_password" required
                            class="w-full rounded-lg border-gray-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-gray-100 px-3 py-2.5 text-sm">
                        @error('current_password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-gray-400 mb-1 block uppercase tracking-wide">Password baru</label>
                        <input type="password" name="password" required
                            class="w-full rounded-lg border-gray-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-gray-100 px-3 py-2.5 text-sm">
                        @error('password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-gray-400 mb-1 block uppercase tracking-wide">Ulangi password baru</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full rounded-lg border-gray-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-gray-100 px-3 py-2.5 text-sm">
                    </div>
                    <button class="w-full bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-bold py-3 rounded-full text-sm">Simpan password</button>
                </form>
            </div>

            {{-- LOGOUT --}}
            <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-3.5 mb-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full border border-gray-300 dark:border-neutral-700 text-gray-700 dark:text-gray-200 font-bold py-3 rounded-full hover:bg-gray-50 dark:hover:bg-neutral-800 active:scale-95 transition text-sm">
                        Keluar dari akun
                    </button>
                </form>
            </div>

            {{-- ZONA BAHAYA --}}
            <div class="bg-white dark:bg-neutral-900 border border-red-200 dark:border-red-900 rounded-lg p-3.5 mb-3">
                <h2 class="text-xs font-bold uppercase tracking-wide text-red-500 mb-3">Zona bahaya</h2>
                <form method="post" action="{{ route('profile.destroy') }}" class="space-y-2"
                    onsubmit="return confirm('Yakin mau hapus akun? Semua data hilang permanen!')">
                    @csrf
                    @method('delete')
                    <input type="password" name="password" placeholder="Ketik password untuk konfirmasi" required
                        class="w-full rounded-lg border-red-200 dark:border-red-900 dark:bg-neutral-800 dark:text-gray-100 px-3 py-2.5 text-sm">
                    <button class="text-xs font-bold text-red-500 border border-red-300 dark:border-red-800 rounded-full px-4 py-2 hover:bg-red-50 dark:hover:bg-red-950/50 transition">
                        Hapus akun permanen
                    </button>
                </form>
            </div>
        @else
            {{-- AKUN GOOGLE: cukup logout --}}
            <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-3.5 mb-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full border border-gray-300 dark:border-neutral-700 text-gray-700 dark:text-gray-200 font-bold py-3 rounded-full hover:bg-gray-50 dark:hover:bg-neutral-800 active:scale-95 transition text-sm">
                        Keluar dari akun
                    </button>
                </form>
            </div>
            <p class="text-center text-xs text-gray-400 mb-3">Akun Google-mu — password & hapus akun dikelola lewat akun Google.</p>
        @endif

        <p class="text-center text-xs text-gray-400 mb-4">streakly · dibikin pake Laravel</p>
        <div class="pb-2"></div>
    </div>
</x-app-layout>