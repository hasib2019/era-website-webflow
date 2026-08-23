@php
    $value = $record->{$column};
    $type = $spec['type'] ?? 'text';
@endphp

@if ($type === 'checkbox')
    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium {{ $value ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
        {{ $value ? 'Yes' : 'No' }}
    </span>
@elseif ($type === 'media')
    @php $media = $record->{Str::camel(Str::beforeLast($column, '_id'))} ?? null; @endphp
    @if ($media)
        <img src="{{ $media->url }}" alt="" class="h-10 w-16 rounded object-cover ring-1 ring-slate-200">
    @else
        <span class="text-slate-400">—</span>
    @endif
@elseif ($value instanceof \DateTimeInterface)
    <span class="text-slate-600">{{ $value->format('M j, Y') }}</span>
@elseif (blank($value))
    <span class="text-slate-400">—</span>
@else
    <span class="{{ $loop->first ?? false ? 'font-medium text-slate-900' : 'text-slate-600' }}">
        {{ Str::limit(strip_tags((string) $value), 70) }}
    </span>
@endif
