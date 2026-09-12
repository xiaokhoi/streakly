<x-guest-layout>
    <h1 class="text-xl font-extrabold text-gray-900 dark:text-gray-100 mb-1">Lupa password?</h1>
    <p class="text-xs text-gray-400 mb-5">Tenang, streak lu tetep aman. Masukin email, nanti dikirim link buat ganti password.</p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1.5 w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="email@kamu.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div class="flex items-center justify-between pt-2">
            <a class="text-sm font-bold text-gray-500 hover:text-gray-700 dark:text-gray-400" href="{{ route('login') }}">
                ← Balik ke login
            </a>
            <x-primary-button class="!bg-yellow-400 !text-gray-900 hover:!bg-yellow-300 !rounded-full !px-6">
                Kirim link
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>