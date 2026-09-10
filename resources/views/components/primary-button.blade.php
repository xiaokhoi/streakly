<button {{ $attributes->merge(['class' => 'inline-flex items-center justify-center px-6 py-3 bg-gray-900 dark:bg-gray-100 border border-transparent rounded-full font-bold text-sm text-white dark:text-gray-900 hover:opacity-90 active:scale-95 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>