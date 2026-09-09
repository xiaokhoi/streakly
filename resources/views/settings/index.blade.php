<x-app-layout>
    <div class="py-6 max-w-md mx-auto px-4">
        <h1 class="text-xl font-extrabold text-gray-800 dark:text-gray-100 mb-4">⚙️ Pengaturan</h1>

        {{-- BANNER SUKSES --}}
        @if(session('profileUpdated'))
            <div class="bg-green-50 dark:bg-green-950/50 border border-green-300 dark:border-green-700 rounded-xl p-3 mb-4 text-sm text-green-700 dark:text-green-400 text-center animate-pop">
                ✅ Profil keupdate!
            </div>
        @endif
        @if(session('passwordChanged'))
            <div class="bg-green-50 dark:bg-green-950/50 border border-green-300 dark:border-green-700 rounded-xl p-3 mb-4 text-sm text-green-700 dark:text-green-400 text-center animate-pop">
                ✅ Password keganti!
            </div>
        @endif

        {{-- TEMA --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-4 mb-4">
            <h2 class="font-bold text-gray-700 dark:text-gray-200 text-sm mb-3">🎨 Tampilan</h2>
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-500 dark:text-gray-400">Mode gelap</p>
                <button onclick="
                        const el = document.documentElement;
                        const dark = el.classList.toggle('dark');
                        localStorage.setItem('theme', dark ? 'dark' : 'light');"
                    class="relative w-14 h-8 rounded-full bg-gray-300 dark:bg-indigo-600 transition-colors">
                    <span class="absolute top-1 left-1 w-6 h-6 rounded-full bg-white shadow transition-transform dark:translate-x-6"></span>
                </button>
            </div>
        </div>

        {{-- EDIT PROFIL: AVATAR + NAMA + EMAIL --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-4 mb-4">
            <h2 class="font-bold text-gray-700 dark:text-gray-200 text-sm mb-3">👤 Profil</h2>

            <form action="{{ route('settings.profile') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <p class="text-xs font-bold text-gray-500 dark:text-gray-400 mb-2">AVATAR</p>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach(['sun', 'cat', 'robot', 'ghost', 'panda', 'alien'] as $avatarType)
                            <label class="cursor-pointer">
                                <input type="radio" name="avatar" value="{{ $avatarType }}" class="peer sr-only"
                                    @checked(old('avatar', auth()->user()->avatar) === $avatarType)>
                                <div class="rounded-2xl border-2 border-gray-100 dark:border-gray-700 p-3 flex items-center justify-center
                                    peer-checked:border-indigo-500 peer-checked:bg-indigo-50 dark:peer-checked:bg-indigo-950/50
                                    hover:border-indigo-300 transition">
                                    <x-avatar :type="$avatarType" class="w-12 h-12" />
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-500 dark:text-gray-400 mb-1 block">NAMA</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                        class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 px-3 py-3 text-sm">
                    @error('name')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-500 dark:text-gray-400 mb-1 block">EMAIL</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                        class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 px-3 py-3 text-sm">
                    @error('email')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button class="w-full bg-indigo-600 hover:bg-indigo-700 active:scale-95 transition text-white font-bold py-3 rounded-xl shadow-lg text-sm">
                    Simpan profil 💾
                </button>
            </form>
        </div>

        {{-- GANTI PASSWORD --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-4 mb-4">
            <h2 class="font-bold text-gray-700 dark:text-gray-200 text-sm mb-3">🔒 Ganti password</h2>

            <form action="{{ route('settings.password') }}" method="POST" class="space-y-3">
                @csrf
                @method('PUT')
                <div>
                    <label class="text-xs font-bold text-gray-500 dark:text-gray-400 mb-1 block">PASSWORD SEKARANG</label>
                    <input type="password" name="current_password" required
                        class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 px-3 py-3 text-sm">
                    @error('current_password')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-500 dark:text-gray-400 mb-1 block">PASSWORD BARU</label>
                    <input type="password" name="password" required
                        class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 px-3 py-3 text-sm">
                    @error('password')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-500 dark:text-gray-400 mb-1 block">ULANGI PASSWORD BARU</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 px-3 py-3 text-sm">
                </div>
                <button class="w-full bg-indigo-600 hover:bg-indigo-700 active:scale-95 transition text-white font-bold py-3 rounded-xl shadow-lg text-sm">
                    Simpan password
                </button>
            </form>
        </div>

        {{-- LOGOUT --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-4 mb-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full border-2 border-red-200 dark:border-red-900 text-red-500 font-bold py-3 rounded-xl hover:bg-red-50 dark:hover:bg-red-950/50 active:scale-95 transition text-sm">
                    🚪 Keluar dari akun
                </button>
            </form>
        </div>

        {{-- ZONA BAHAYA: HAPUS AKUN --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-4 mb-4">
            <h2 class="font-bold text-red-500 mb-2 text-sm">Zona bahaya</h2>
            <form method="post" action="{{ route('profile.destroy') }}" class="space-y-2"
                onsubmit="return confirm('Yakin mau hapus akun? Semua data hilang permanen!')">
                @csrf
                @method('delete')
                <input type="password" name="password" placeholder="Ketik password untuk konfirmasi" required
                    class="w-full rounded-xl border-red-200 dark:border-red-900 dark:bg-gray-700 dark:text-gray-100 px-3 py-2 text-sm">
                <button class="text-xs font-bold text-red-500 border-2 border-red-200 dark:border-red-900 rounded-xl px-4 py-2 hover:bg-red-50 dark:hover:bg-red-950/50 transition">
                    Hapus akun permanen
                </button>
            </form>
        </div>

        <p class="text-center text-xs text-gray-400 dark:text-gray-500 mb-4">HabitPet v0.1 · dibikin pake Laravel 🔥</p>
    </div>
</x-app-layout>