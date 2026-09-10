@php $u = auth()->user(); @endphp
<nav class="md:hidden fixed bottom-0 inset-x-0 z-50 bg-white dark:bg-neutral-900 border-t border-gray-300 dark:border-neutral-800">
    <div class="max-w-md mx-auto flex justify-around py-1.5">
        <a href="{{ route('dashboard') }}"
            class="flex flex-col items-center gap-0.5 px-3 py-1 text-[10px] font-medium transition
                {{ request()->routeIs('dashboard') ? 'text-gray-900 dark:text-white' : 'text-gray-400' }}">
            <svg class="w-6 h-6" fill="{{ request()->routeIs('dashboard') ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75" />
            </svg>
            Home
        </a>

        <a href="{{ route('explore') }}"
            class="flex flex-col items-center gap-0.5 px-3 py-1 text-[10px] font-medium transition
                {{ request()->routeIs('explore.*') ? 'text-gray-900 dark:text-white' : 'text-gray-400' }}">
            <svg class="w-6 h-6" fill="{{ request()->routeIs('explore.*') ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m-18.432 0A8.959 8.959 0 0 1 3 12c0-.778.099-1.533.284-2.253" />
            </svg>
            Explore
        </a>

        <a href="{{ route('social.index') }}"
            class="flex flex-col items-center gap-0.5 px-3 py-1 text-[10px] font-medium transition
                {{ request()->routeIs('social.*', 'chat.*') ? 'text-gray-900 dark:text-white' : 'text-gray-400' }}">
            <div class="relative">
                <svg class="w-6 h-6" fill="{{ request()->routeIs('social.*', 'chat.*') ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                </svg>
                @if($u->hasStreakInDanger())
                    <span class="absolute -top-0.5 -right-1 w-2.5 h-2.5 rounded-full bg-red-500 border-2 border-white dark:border-neutral-900 animate-pulse"></span>
                @endif
            </div>
            Chat
        </a>

        <a href="{{ route('leaderboard.index') }}"
            class="flex flex-col items-center gap-0.5 px-3 py-1 text-[10px] font-medium transition
                {{ request()->routeIs('leaderboard.*') ? 'text-gray-900 dark:text-white' : 'text-gray-400' }}">
            <svg class="w-6 h-6" fill="{{ request()->routeIs('leaderboard.*') ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0" />
            </svg>
            Papan
        </a>

        <a href="{{ route('profile.edit') }}"
            class="flex flex-col items-center gap-0.5 px-3 py-1 text-[10px] font-medium transition
                {{ request()->routeIs('profile.*') ? 'text-gray-900 dark:text-white' : 'text-gray-400' }}">
            <svg class="w-6 h-6" fill="{{ request()->routeIs('profile.*') ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
            Profil
        </a>
    </div>
</nav>