@extends('admin.layouts.app')

@section('title', 'Site settings')
@section('subheading', 'Values the whole site reads')

@section('content')
    <form method="POST" action="{{ route('admin.settings.update') }}" class="max-w-3xl space-y-6">
        @csrf
        @method('PUT')

        @foreach ($groups as $group => $settings)
            <section class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-900/5">
                <h2 class="mb-5 text-sm font-semibold uppercase tracking-wide text-slate-500">{{ Str::headline($group) }}</h2>
                <div class="grid gap-5 sm:grid-cols-2">
                    @foreach ($settings as $setting)
                        @php
                            $name = "settings[{$setting->group}][{$setting->key}]";
                            $id = 'set-' . $setting->group . '-' . $setting->key;
                            $wide = in_array($setting->type, ['textarea', 'media'], true);
                            $input = 'mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm ring-1 ring-slate-200 focus:bg-white focus:ring-2 focus:ring-brand-500';
                        @endphp

                        <div class="{{ $wide ? 'sm:col-span-2' : '' }}">
                            <label for="{{ $id }}" class="block text-sm font-medium text-slate-700">
                                {{ $setting->label ?? Str::headline($setting->key) }}
                            </label>

                            @if ($setting->type === 'media')
                                @php $selected = $mediaOptions->firstWhere('id', (int) $setting->value); @endphp
                                <div class="mt-1.5 flex items-start gap-3">
                                    <div class="flex h-16 w-24 shrink-0 items-center justify-center overflow-hidden rounded-lg bg-slate-100 ring-1 ring-slate-200">
                                        @if ($selected)
                                            <img src="{{ $selected->url }}" alt="" class="max-h-full max-w-full object-contain">
                                        @endif
                                    </div>
                                    <select id="{{ $id }}" name="{{ $name }}" class="{{ $input }} mt-0">
                                        <option value="">— none —</option>
                                        @foreach ($mediaOptions as $media)
                                            <option value="{{ $media->id }}" @selected((int) $setting->value === $media->id)>
                                                {{ $media->original_name }} ({{ $media->filename }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @elseif ($setting->type === 'textarea')
                                <textarea id="{{ $id }}" name="{{ $name }}" rows="3" class="{{ $input }}">{{ $setting->value }}</textarea>
                            @else
                                <input id="{{ $id }}" type="text" name="{{ $name }}" value="{{ $setting->value }}" class="{{ $input }}">
                            @endif
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach

        <button type="submit" class="rounded-lg bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-700">
            Save settings
        </button>
    </form>
@endsection
