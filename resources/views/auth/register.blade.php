<x-guest-layout>
    <h1 class="text-xl font-extrabold text-gray-900 dark:text-gray-100 mb-1">Buat akun</h1>
    <p class="text-xs text-gray-400 mb-5">Daftar sekarang — telur-mu nunggu buat menetas 🥚</p>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input id="name" class="block mt-1.5 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama lu" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1.5 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="email@kamu.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1.5 w-full" type="password" name="password" required autocomplete="new-password" placeholder="Min. 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Ulangi password')" />
            <x-text-input id="password_confirmation" class="block mt-1.5 w-full" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between pt-2">
            <a class="text-sm font-bold text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" href="{{ route('login') }}">
                Udah punya akun? Masuk
            </a>
            <x-primary-button class="!bg-yellow-400 !text-gray-900 hover:!bg-yellow-300 !rounded-full !px-6">
                Daftar
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>