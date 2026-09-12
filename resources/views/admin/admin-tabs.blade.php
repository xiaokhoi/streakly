@php
    $tabs = [
        ['admin.users', 'Users'],
        ['admin.posts', 'Komunitas'],
        ['admin.reports', '🚨 Laporan'],
        ['admin.categories', 'Kategori'],
        ['admin.avatars', 'Avatar'],
        ['admin.settings', '⚙️ Aturan'],
    ];
    $current = request()->route()->getName();
@endphp

<div class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-800 rounded-lg p-1.5 flex gap-1 mb-3 overflow-x-auto">
    @foreach($tabs as $tab)
        <a href="{{ route($tab[0]) }}"
            class="flex-1 text-center text-xs font-bold py-2 rounded-md transition whitespace-nowrap px-3
                {{ $current === $tab[0]
                    ? 'bg-yellow-400 text-gray-900'
                    : 'text-gray-500 hover:bg-gray-100 dark:hover:bg-neutral-800' }}">
            {{ $tab[1] }}
        </a>
    @endforeach
</div>