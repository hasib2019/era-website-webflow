@php
    $type = $spec['type'] ?? 'text';
    $label = $spec['label'] ?? Str::headline($name);
    $id = 'field-' . Str::slug($name);
    $options = $spec['options'] ?? [];
    if ($options instanceof Closure) {
        $options = $options();
    }
    // page sections reuse this partial with a spec that carries no rules at all
    $rules = $spec['rules'] ?? '';
    $rules = is_string($rules) ? $rules : implode('|', (array) $rules);
    $required = str_contains($rules, 'required');
    $input = 'mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 ring-1 ring-slate-200 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-brand-500';
@endphp

<div>
    @if ($type !== 'checkbox')
        <label for="{{ $id }}" class="block text-sm font-medium text-slate-700">
            {{ $label }}@if ($required)<span class="text-red-500" title="Required">*</span>@endif
        </label>
    @endif

    @switch($type)
        @case('textarea')
            <textarea id="{{ $id }}" name="{{ $name }}" rows="3" class="{{ $input }}">{{ $value }}</textarea>
            @break

        @case('richtext')
            <textarea id="{{ $id }}" name="{{ $name }}" rows="10" class="{{ $input }} font-mono text-xs leading-relaxed">{{ $value }}</textarea>
            <p class="mt-1 text-xs text-slate-400">HTML is allowed here.</p>
            @break

        @case('select')
            {{-- a required select must not offer an empty choice: picking it only
                 buys a validation error on submit --}}
            <select id="{{ $id }}" name="{{ $name }}" class="{{ $input }}">
                @unless ($required)
                    <option value="">— none —</option>
                @endunless
                @foreach ($options as $optionValue => $optionLabel)
                    <option value="{{ $optionValue }}" @selected((string) $value === (string) $optionValue)>{{ $optionLabel }}</option>
                @endforeach
            </select>
            @break

        @case('media')
            @php $selected = $mediaOptions->firstWhere('id', (int) $value); @endphp
            <div class="mt-1.5" data-media-picker-field data-media-value-type="id">
                <input id="{{ $id }}" type="hidden" name="{{ $name }}" value="{{ $value }}" data-media-picker-value>
                <div class="flex items-start gap-4">
                    <button type="button" data-media-picker-open
                        class="group relative h-20 w-28 shrink-0 overflow-hidden rounded-lg bg-slate-100 ring-1 ring-slate-200 transition hover:ring-2 hover:ring-brand-500"
                        aria-label="Choose {{ $label }}">
                        <img src="{{ $selected?->url ?? '' }}" alt="" data-media-picker-preview
                            class="h-full w-full object-cover {{ $selected ? '' : 'hidden' }}">
                        <span data-media-picker-placeholder
                            class="absolute inset-0 {{ $selected ? 'hidden' : 'flex' }} items-center justify-center text-xs font-medium text-slate-400">No image</span>
                    </button>
                    <div class="min-w-0 flex-1">
                        <p data-media-picker-name class="truncate text-sm text-slate-700">
                            {{ $selected ? $selected->original_name . ' (' . $selected->filename . ')' : 'No image selected' }}
                        </p>
                        <div class="mt-2 flex flex-wrap gap-2">
                            <button type="button" data-media-picker-open
                                class="rounded-lg bg-white px-3 py-1.5 text-xs font-semibold text-brand-700 ring-1 ring-slate-200 transition hover:bg-brand-50">
                                {{ $selected ? 'Change image' : 'Choose image' }}
                            </button>
                            <button type="button" data-media-picker-clear
                                class="rounded-lg px-3 py-1.5 text-xs font-semibold text-slate-500 transition hover:bg-slate-100 {{ $selected ? '' : 'hidden' }}">Remove</button>
                        </div>
                        <a href="{{ route('admin.media.index') }}" target="_blank" rel="noopener"
                            class="mt-2 inline-block text-xs font-medium text-brand-700 hover:underline">Upload to media library</a>
                    </div>
                </div>
            </div>
            @break

        @case('checkbox')
            <label class="flex items-center gap-2.5 text-sm font-medium text-slate-700">
                <input type="hidden" name="{{ $name }}" value="0">
                <input id="{{ $id }}" type="checkbox" name="{{ $name }}" value="1" @checked($value)
                    class="h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                {{ $label }}
            </label>
            @break

        @case('number')
            <input id="{{ $id }}" type="number" name="{{ $name }}" value="{{ $value }}" class="{{ $input }}">
            @break

        @case('date')
            <input id="{{ $id }}" type="date" name="{{ $name }}"
                value="{{ $value instanceof \DateTimeInterface ? $value->format('Y-m-d') : $value }}" class="{{ $input }}">
            @break

        @case('datetime')
            <input id="{{ $id }}" type="datetime-local" name="{{ $name }}"
                value="{{ $value instanceof \DateTimeInterface ? $value->format('Y-m-d\TH:i') : $value }}" class="{{ $input }}">
            @break

        @default
            <input id="{{ $id }}" type="text" name="{{ $name }}" value="{{ $value }}" class="{{ $input }}">
    @endswitch

    @if (! empty($spec['help']))
        <p class="mt-1 text-xs text-slate-400">{{ $spec['help'] }}</p>
    @endif

    @error($name)
        <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
    @enderror
</div>
