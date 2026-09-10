<x-app-layout>
    <div class="max-w-md mx-auto px-4 pt-16">
        <div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-8 text-center">
            <h1 class="text-4xl font-extrabold text-gray-900 dark:text-gray-100">404</h1>
            <p class="text-sm text-gray-500 mt-2 mb-6">Halaman gak ketemu. Mungkin streak-nya yang putus 😅</p>
            <a href="{{ url('/') }}" class="inline-block bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-bold py-3 px-8 rounded-full text-sm transition">
                Balik ke home
            </a>
        </div>
    </div>
</x-app-layout>