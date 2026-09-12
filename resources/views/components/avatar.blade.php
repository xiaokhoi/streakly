@props(['email' => null, 'class' => 'w-10 h-10'])

@php
    // gravatar: hash md5 dari email lowercase + ukuran 128px
    $hash = md5(strtolower(trim($email ?? '')));
    $url = 'https://gravatar.com/avatar/' . $hash . '?s=128&d=identicon';
@endphp

<img src="{{ $url }}" alt="Avatar" loading="lazy"
    {{ $attributes->merge(['class' => $class . ' rounded-full object-cover bg-gray-200 dark:bg-neutral-800']) }}>