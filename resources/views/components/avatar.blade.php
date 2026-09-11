@php
    // valid: 00 sampai 19 (file public/avatars/avatar-XX.png)
    // nilai lama (sun, cat, dll) atau aneh-aneh -> fallback ke 01
    $valid = is_string($type) && preg_match('/^(0[0-9]|1[0-9])$/', $type);
    $file = $valid ? 'avatar-' . $type : 'avatar-01';
@endphp

<img src="{{ asset('avatars/' . $file . '.png') }}" alt="Avatar" {{ $attributes->merge(['class' => 'w-10 h-10 rounded-full object-cover object-top']) }}>