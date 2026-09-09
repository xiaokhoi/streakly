@if ($errors->any())
    <div {{ $attributes->merge(['class' => 'bg-red-50 dark:bg-red-950/50 border border-red-300 dark:border-red-700 rounded-xl p-3 mb-4']) }}>
        <div class="font-bold text-sm text-red-600 dark:text-red-400 mb-1">Ups, ada yang salah:</div>
        <ul class="list-disc list-inside text-sm text-red-600 dark:text-red-400">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif