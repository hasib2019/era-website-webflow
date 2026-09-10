@extends('admin.layouts.app')

@section('title', $labels['plural'])
@section('subheading', $records->total() . ' ' . Str::lower(Str::plural(Str::singular($labels['plural']), $records->total())))

@section('content')
    <div class="mb-5 flex flex-wrap items-center gap-3">
        <form method="GET" class="flex-1 min-w-56">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Search {{ Str::lower($labels['plural']) }}…"
                class="w-full max-w-sm rounded-lg border-0 bg-white px-3.5 py-2 text-sm ring-1 ring-slate-200 placeholder:text-slate-400 focus:ring-2 focus:ring-brand-500">
        </form>

        <a href="{{ route("admin.{$key}.create") }}"
            class="inline-flex items-center gap-1.5 rounded-lg bg-brand-600 px-3.5 py-2 text-sm font-semibold text-white transition hover:bg-brand-700">
            @include('admin.partials.icon', ['name' => 'plus', 'class' => 'h-4 w-4'])
            New {{ Str::lower($labels['singular']) }}
        </a>
    </div>

    {{-- Screens holding more than one kind of row get a tab per kind. --}}
    @if (!empty($filters))
        @php $activeFilter = (string) request($filterKey ?? 'scope', ''); @endphp
        <nav class="mb-5 flex flex-wrap gap-1.5">
            @foreach (['' => 'All'] + $filters as $value => $label)
                @php $isActive = $activeFilter === (string) $value; @endphp
                <a href="{{ request()->fullUrlWithQuery([($filterKey ?? 'scope') => $value ?: null, 'page' => null]) }}"
                    @if ($isActive) aria-current="page" @endif
                    class="rounded-lg px-3 py-1.5 text-sm font-medium transition {{ $isActive
                        ? 'bg-brand-600 text-white'
                        : 'text-slate-600 ring-1 ring-slate-200 hover:bg-white' }}">
                    {{ $label }}
                    <span class="ml-1 text-xs {{ $isActive ? 'text-white/70' : 'text-slate-400' }}">{{ $filterCounts[$value] ?? 0 }}</span>
                </a>
            @endforeach
        </nav>
    @endif

    <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-slate-900/5">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        @foreach ($columns as $column)
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                {{ $fields[$column]['label'] ?? Str::headline($column) }}
                            </th>
                        @endforeach
                        <th class="w-px px-4 py-3"><span class="sr-only">Actions</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @php $currentGroup = null; @endphp
                    @forelse ($records as $record)
                        {{-- A heading row each time the grouping column changes. The listing
                             must be ordered by that column for this to read correctly, which
                             is what the controller's defaultOrder() override arranges. --}}
                        @if ($groupBy ?? null)
                            @php $group = (string) ($record->{$groupBy} ?? ''); @endphp
                            @if ($group !== $currentGroup)
                                @php $currentGroup = $group; @endphp
                                <tr class="bg-slate-50/80">
                                    <th colspan="{{ count($columns) + 1 }}"
                                        class="px-4 py-2.5 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                        {{ $groupLabels[$group] ?? Str::headline($group) }}
                                    </th>
                                </tr>
                            @endif
                        @endif

                        <tr class="hover:bg-slate-50/70">
                            @foreach ($columns as $column)
                                <td class="px-4 py-3 align-middle">
                                    @include('admin.resource.cell', [
                                        'record' => $record,
                                        'column' => $column,
                                        'spec' => $fields[$column] ?? [],
                                    ])
                                </td>
                            @endforeach
                            <td class="whitespace-nowrap px-4 py-3 text-right">
                                {{-- getKey(), not the record itself: Service, Post, CaseStudy and
                                     JobOpening expose `slug` as their route key so the public site
                                     gets pretty URLs, and route() would serialise that slug into an
                                     admin URL whose controller resolves by primary key. --}}
                                <a href="{{ route("admin.{$key}.edit", $record->getKey()) }}"
                                    class="rounded-md px-2.5 py-1.5 text-xs font-semibold text-brand-700 hover:bg-brand-50">Edit</a>
                                <form method="POST" action="{{ route("admin.{$key}.destroy", $record->getKey()) }}" class="inline"
                                    data-confirm="Delete this {{ Str::lower($labels['singular']) }}? This cannot be undone.">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="rounded-md px-2.5 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($columns) + 1 }}" class="px-4 py-12 text-center text-slate-500">
                                Nothing here yet.
                                <a href="{{ route("admin.{$key}.create") }}" class="font-medium text-brand-700 hover:underline">
                                    Add the first one</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($records->hasPages())
        <div class="mt-5">{{ $records->links() }}</div>
    @endif
@endsection
