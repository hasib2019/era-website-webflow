@extends('admin.layouts.app')

@section('title', $record->exists ? 'Edit ' . Str::lower($labels['singular']) : 'New ' . Str::lower($labels['singular']))
@section('subheading', $labels['plural'])

@section('content')
    @php
        /*
         * fields without a group render first, then each named group as its own card
         *
         * preserveKeys matters: groupBy() reindexes by default, which turned every
         * field name into 0, 1, 2 ... so the whole form posted `name="0"` and not one
         * value ever reached the model.
         */
        $groups = collect($fields)->groupBy(fn ($spec) => $spec['group'] ?? 'Content', preserveKeys: true);
    @endphp

    <form method="POST"
        action="{{ $record->exists ? route("admin.{$key}.update", $record->getKey()) : route("admin.{$key}.store") }}"
        class="max-w-3xl space-y-6">
        @csrf
        @if ($record->exists)
            @method('PUT')
        @endif

        @foreach ($groups as $group => $groupFields)
            <section class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-900/5">
                <h2 class="mb-5 text-sm font-semibold uppercase tracking-wide text-slate-500">{{ $group }}</h2>
                <div class="space-y-5">
                    @foreach ($groupFields as $name => $spec)
                        @include('admin.resource.field', [
                            'name' => $name,
                            'spec' => $spec,
                            'value' => old($name, data_get($record, $name)),
                            'mediaOptions' => $mediaOptions ?? collect(),
                        ])
                    @endforeach
                </div>
            </section>
        @endforeach

        <div class="flex items-center gap-3">
            <button type="submit"
                class="rounded-lg bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-700">
                {{ $record->exists ? 'Save changes' : 'Create ' . Str::lower($labels['singular']) }}
            </button>
            <a href="{{ route("admin.{$key}.index") }}"
                class="rounded-lg px-4 py-2.5 text-sm font-medium text-slate-600 ring-1 ring-slate-200 transition hover:bg-white">
                Cancel
            </a>

            @if ($record->exists)
                <span class="ml-auto text-xs text-slate-400">
                    Last updated {{ $record->updated_at?->diffForHumans() }}
                </span>
            @endif
        </div>
    </form>

    @if (collect($fields)->contains(fn ($spec) => ($spec['type'] ?? 'text') === 'media'))
        @include('admin.partials.media-picker', ['mediaOptions' => $mediaOptions ?? collect()])
    @endif
@endsection
