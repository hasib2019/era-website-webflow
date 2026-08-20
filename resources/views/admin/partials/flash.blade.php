@php
    // Tailwind scans for literal class strings, so each tone is spelled out
    $tones = [
        'success' => 'bg-emerald-50 text-emerald-800 ring-emerald-600/10',
        'error' => 'bg-red-50 text-red-800 ring-red-600/10',
        'warning' => 'bg-amber-50 text-amber-800 ring-amber-600/10',
        'info' => 'bg-sky-50 text-sky-800 ring-sky-600/10',
    ];
@endphp

@foreach ($tones as $key => $classes)
    @if (session($key))
        <div data-flash class="mb-5 flex items-start gap-3 rounded-xl px-4 py-3 text-sm ring-1 {{ $classes }}">
            <span class="flex-1">{{ session($key) }}</span>
            <button type="button" data-dismiss class="opacity-60 hover:opacity-100" aria-label="Dismiss">&times;</button>
        </div>
    @endif
@endforeach

@if ($errors->any())
    <div data-flash class="mb-5 rounded-xl bg-red-50 px-4 py-3 text-sm text-red-800 ring-1 ring-red-600/10">
        <p class="font-medium">Please fix the following:</p>
        <ul class="mt-1.5 list-inside list-disc space-y-0.5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
