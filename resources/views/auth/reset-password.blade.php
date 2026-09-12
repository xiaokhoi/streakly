<x-guest-layout>
    <h1 class="text-xl font-extrabold text-gray-900 dark:text-gray-100 mb-1">Password baru</h1>
    <p class="text-xs text-gray-400 mb-5">Bikin password baru buat akun lu.</p>

    <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ request()->route('token') }}">

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1.5 w-full" type="email" name="email" :value="old('email', request()->route('email'))" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password baru')" />
            <x-text-input id="password" class="block mt-1.5 w-full" type="password" name="password" required autocomplete="new-password" placeholder="Min. 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Ulangi password baru')" />
            <x-text-input id="password_confirmation" class="block mt-1.5 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between pt-2">
            <a class="text-sm font-bold text-gray-500" href="{{ route('login') }}">← Login</a>
            <x-primary-button class="!bg-yellow-400 !text-gray-900 hover:!bg-yellow-300 !rounded-full !px-6">
                Simpan password
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>