@php
    $content = $section->content ?? [];
    // an image field stores a media filename; show what it currently resolves to
    $resolve = fn ($value) => $mediaOptions->firstWhere('filename', $value)
        ?? $mediaOptions->firstWhere('id', is_numeric($value) ? (int) $value : null);
@endphp

<section class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-slate-900/5">
    <header class="flex items-center justify-between gap-3 border-b border-slate-100 px-6 py-4">
        <div class="min-w-0">
            <h2 class="truncate text-sm font-semibold text-slate-900">{{ $section->name }}</h2>
            <p class="truncate font-mono text-[11px] text-slate-400">{{ $section->key }}</p>
        </div>
        <span class="shrink-0 text-xs text-slate-400">{{ count($content) }} {{ Str::plural('field', count($content)) }}</span>
    </header>

    @if (empty($content))
        <p class="px-6 py-8 text-center text-sm text-slate-400">
            This section has no editable fields — its content comes from a collection.
        </p>
    @else
        <form method="POST" action="{{ route('admin.pages.sections.update', [$page, $section]) }}" class="px-6 py-5">
            @csrf
            @method('PUT')

            <div class="grid gap-5 md:grid-cols-2">
                @foreach ($content as $key => $definition)
                    @php
                        $type = $definition['type'] ?? 'text';
                        $value = $definition['value'] ?? '';
                        $wide = in_array($type, ['richtext', 'textarea', 'html'], true) || Str::length($value) > 90;
                        $id = 'sec-' . $section->id . '-' . Str::slug($key);
                    @endphp

                    <div class="{{ $wide ? 'md:col-span-2' : '' }}">
                        <label for="{{ $id }}" class="flex items-baseline justify-between text-sm font-medium text-slate-700">
                            <span>{{ Str::headline($key) }}</span>
                            <span class="font-mono text-[10px] uppercase tracking-wide text-slate-400">{{ $type }}</span>
                        </label>

                        @if ($type === 'image' || $type === 'icon')
                            @php $media = $resolve($value); @endphp
                            <div class="mt-1.5 flex items-start gap-3">
                                <div class="h-16 w-24 shrink-0 overflow-hidden rounded-lg bg-slate-100 ring-1 ring-slate-200">
                                    @if ($media)
                                        <img src="{{ $media->url }}" alt="" class="h-full w-full object-cover">
                                    @endif
                                </div>
                                <select id="{{ $id }}" name="content[{{ $key }}]"
                                    class="mt-0 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm ring-1 ring-slate-200 focus:bg-white focus:ring-2 focus:ring-brand-500">
                                    <option value="">— none —</option>
                                    @foreach ($mediaOptions as $option)
                                        <option value="{{ $option->filename }}" @selected($value === $option->filename)>
                                            {{ $option->original_name }} ({{ $option->filename }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @elseif (in_array($type, ['richtext', 'html'], true))
                            <textarea id="{{ $id }}" name="content[{{ $key }}]" rows="5"
                                class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 font-mono text-xs leading-relaxed ring-1 ring-slate-200 focus:bg-white focus:ring-2 focus:ring-brand-500">{{ $value }}</textarea>
                        @elseif ($wide)
                            <textarea id="{{ $id }}" name="content[{{ $key }}]" rows="3"
                                class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm ring-1 ring-slate-200 focus:bg-white focus:ring-2 focus:ring-brand-500">{{ $value }}</textarea>
                        @else
                            <input id="{{ $id }}" type="text" name="content[{{ $key }}]" value="{{ $value }}"
                                class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm ring-1 ring-slate-200 focus:bg-white focus:ring-2 focus:ring-brand-500">
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="mt-5 flex items-center gap-4 border-t border-slate-100 pt-4">
                <button type="submit"
                    class="rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-700">
                    Save section
                </button>
                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="hidden" name="is_visible" value="0">
                    <input type="checkbox" name="is_visible" value="1" @checked($section->is_visible)
                        class="h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                    Visible on the site
                </label>
            </div>
        </form>
    @endif
</section>
