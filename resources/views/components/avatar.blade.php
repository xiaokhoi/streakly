@props(['type' => 'sun', 'class' => 'w-10 h-10'])

@switch($type)
    @case('sun')
        <svg {{ $attributes->merge(['class' => $class]) }} viewBox="0 0 64 64" fill="none">
            <g stroke="#FBBF24" stroke-width="3" stroke-linecap="round">
                <path d="M32 3v7M32 54v7M3 32h7M54 32h7M11 11l5 5M48 48l5 5M53 11l-5 5M16 48l-5 5"/>
            </g>
            <circle cx="32" cy="32" r="18" fill="#FBBF24"/>
            <circle cx="26" cy="29" r="2.5" fill="#92400E"/>
            <circle cx="38" cy="29" r="2.5" fill="#92400E"/>
            <path d="M25 37q7 6 14 0" stroke="#92400E" stroke-width="2.5" stroke-linecap="round"/>
        </svg>
    @break

    @case('cat')
        <svg {{ $attributes->merge(['class' => $class]) }} viewBox="0 0 64 64" fill="none">
            <path d="M15 24 12 7l14 9z" fill="#F9A8D4"/>
            <path d="M49 24 52 7l-14 9z" fill="#F9A8D4"/>
            <circle cx="32" cy="36" r="19" fill="#F9A8D4"/>
            <circle cx="25" cy="33" r="2.5" fill="#831843"/>
            <circle cx="39" cy="33" r="2.5" fill="#831843"/>
            <path d="M28 41h8M32 41v3M29 46q3 2.5 6 0" stroke="#831843" stroke-width="2.2" stroke-linecap="round"/>
        </svg>
    @break

    @case('robot')
        <svg {{ $attributes->merge(['class' => $class]) }} viewBox="0 0 64 64" fill="none">
            <path d="M32 4v8" stroke="#94A3B8" stroke-width="3"/>
            <circle cx="32" cy="5" r="3.5" fill="#38BDF8"/>
            <rect x="12" y="14" width="40" height="38" rx="10" fill="#94A3B8"/>
            <rect x="20" y="25" width="8" height="8" rx="2" fill="#38BDF8"/>
            <rect x="36" y="25" width="8" height="8" rx="2" fill="#38BDF8"/>
            <path d="M25 42h14" stroke="#475569" stroke-width="2.5" stroke-linecap="round"/>
        </svg>
    @break

    @case('ghost')
        <svg {{ $attributes->merge(['class' => $class]) }} viewBox="0 0 64 64" fill="none">
            <path d="M32 6c12 0 20 9 20 20v24l-6.7-5-6.6 5-6.7-5-6.7 5-6.6-5-6.7 5V26C12 15 20 6 32 6z" fill="#A78BFA"/>
            <circle cx="25" cy="28" r="3" fill="#312E81"/>
            <circle cx="39" cy="28" r="3" fill="#312E81"/>
            <path d="M27 36q5 4 10 0" stroke="#312E81" stroke-width="2.2" stroke-linecap="round"/>
        </svg>
    @break

    @case('panda')
        <svg {{ $attributes->merge(['class' => $class]) }} viewBox="0 0 64 64" fill="none">
            <circle cx="14" cy="18" r="9" fill="#334155"/>
            <circle cx="50" cy="18" r="9" fill="#334155"/>
            <circle cx="32" cy="36" r="20" fill="#F8FAFC"/>
            <ellipse cx="24" cy="32" rx="6" ry="7" fill="#334155" transform="rotate(-15 24 32)"/>
            <ellipse cx="40" cy="32" rx="6" ry="7" fill="#334155" transform="rotate(15 40 32)"/>
            <circle cx="24.5" cy="32" r="2" fill="#F8FAFC"/>
            <circle cx="39.5" cy="32" r="2" fill="#F8FAFC"/>
            <path d="M28 44h8" stroke="#334155" stroke-width="2.5" stroke-linecap="round"/>
        </svg>
    @break

    @case('alien')
        <svg {{ $attributes->merge(['class' => $class]) }} viewBox="0 0 64 64" fill="none">
            <path d="M20 16 15 7M44 16l5-9" stroke="#4ADE80" stroke-width="3" stroke-linecap="round"/>
            <circle cx="14" cy="5" r="3.5" fill="#4ADE80"/>
            <circle cx="50" cy="5" r="3.5" fill="#4ADE80"/>
            <ellipse cx="32" cy="38" rx="21" ry="22" fill="#4ADE80"/>
            <ellipse cx="24" cy="33" rx="5" ry="7" fill="#052E16"/>
            <ellipse cx="40" cy="33" rx="5" ry="7" fill="#052E16"/>
            <path d="M29 47q3 2 6 0" stroke="#052E16" stroke-width="2.2" stroke-linecap="round"/>
        </svg>
    @break

    @default
        <svg {{ $attributes->merge(['class' => $class]) }} viewBox="0 0 64 64" fill="none">
            <circle cx="32" cy="32" r="18" fill="#FBBF24"/>
            <circle cx="26" cy="29" r="2.5" fill="#92400E"/>
            <circle cx="38" cy="29" r="2.5" fill="#92400E"/>
            <path d="M25 37q7 6 14 0" stroke="#92400E" stroke-width="2.5" stroke-linecap="round"/>
        </svg>
@endswitch