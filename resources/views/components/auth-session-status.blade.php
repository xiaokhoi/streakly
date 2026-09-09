@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-950/50 border border-green-300 dark:border-green-700 rounded-xl p-3 text-center']) }}>
        {{ $status }}
    </div>
@endif