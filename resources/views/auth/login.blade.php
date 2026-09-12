<x-guest-layout>
    <h1 class="text-xl font-extrabold text-gray-900 dark:text-gray-100 mb-1">Masuk</h1>
    <p class="text-xs text-gray-400 mb-4">Lanjutin streak-mu sebelum hangus 🔥</p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <x-social-buttons />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="login" value="username atau email" />
            <x-text-input id="login" class="block mt-1.5 w-full" type="text" name="login" :value="old('login')" required autofocus autocomplete="username" placeholder="username atau email@kamu.com" />
            <x-input-error :messages="$errors->get('login')" class="mt-2" />
        </div>

        <div>
            <div class="flex justify-between items-center mb-1">
                <x-input-label for="password" :value="__('Password')" />
                <a class="text-xs font-bold text-yellow-600 hover:text-yellow-500 dark:text-yellow-400" href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            </div>
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <label class="inline-flex items-center">
            <input id="remember_me" type="checkbox" class="rounded dark:bg-neutral-800 border-gray-300 dark:border-neutral-600 text-yellow-500 focus:ring-yellow-400" name="remember">
            <span class="ms-2 text-sm text-gray-500">Ingat aku</span>
        </label>

        <div class="flex items-center justify-between pt-2">
            <a class="text-sm font-bold text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" href="{{ route('register') }}">
                Belum punya akun? Daftar
            </a>
            <x-primary-button class="!bg-yellow-400 !text-gray-900 hover:!bg-yellow-300 !rounded-full !px-6">
                Masuk
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>