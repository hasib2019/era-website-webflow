@extends('admin.layouts.app')

@section('title', $menu->name)
@section('subheading', 'Navigation')

@section('content')
    @php
        $flat = $menu->columnMode() === 'none' && ! $menu->supportsDropdowns();
        // an item whose heading is not a real column is rendered nowhere on the site
        $strayIds = $stray->pluck('id')->all();
    @endphp

    <a href="{{ route('admin.menus.index') }}" class="mb-5 inline-block text-sm font-medium text-slate-500 hover:text-slate-800">&larr; All menus</a>

    @if ($menu->help())
        <p class="mb-5 max-w-3xl text-sm text-slate-500">{{ $menu->help() }}</p>
    @endif

    <div class="grid gap-6 xl:grid-cols-4">
        <div class="xl:col-span-3">
            <div class="mb-3 flex items-center gap-3">
                <h2 class="text-sm font-semibold text-slate-900">Links</h2>
                <span class="text-xs text-slate-400">
                    Drag a link by its handle to reorder{{ $flat ? '' : ' or move it between columns' }}.
                    @if ($menu->supportsDropdowns())
                        Drop one under a dropdown to put it in that panel.
                    @endif
                    Saves as you drop.
                </span>
            </div>

            @php
                // literal classes: Tailwind cannot see a column count built at runtime
                $grid = match (true) {
                    $flat, count($board) <= 1 => '',
                    count($board) === 2 => 'lg:grid-cols-2',
                    default => 'lg:grid-cols-3',
                };
            @endphp

            <div data-menu-board data-reorder-url="{{ route('admin.menus.reorder', $menu) }}"
                class="grid gap-4 {{ $grid }}">
                @foreach ($board as $bucket)
                    <section class="rounded-xl shadow-sm ring-1 {{ ($bucket['new'] ?? false) ? 'bg-slate-50 ring-dashed ring-slate-300' : 'bg-white ring-slate-900/5' }}">
                        <header class="flex items-center justify-between border-b border-slate-100 px-4 py-3">
                            <h3 class="truncate text-xs font-semibold uppercase tracking-wide {{ ($bucket['new'] ?? false) ? 'text-slate-400' : 'text-slate-500' }}">
                                {{ $bucket['title'] }}
                                @if ($bucket['new'] ?? false)
                                    <span class="ml-1 font-normal normal-case tracking-normal">(new column)</span>
                                @endif
                            </h3>
                            <span class="text-[11px] text-slate-400" data-column-count>{{ $bucket['items']->count() }}</span>
                        </header>

                        <ul data-menu-column="{{ $bucket['column'] }}" data-menu-parent="{{ $bucket['parent'] }}"
                            class="min-h-24 space-y-2 p-3">
                            @forelse ($bucket['items'] as $item)
                                @include('admin.menus.item', ['item' => $item, 'menu' => $menu])
                            @empty
                                @include('admin.menus.empty')
                            @endforelse
                        </ul>
                    </section>
                @endforeach
            </div>

            @if ($stray->isNotEmpty())
                <section class="mt-4 rounded-xl bg-amber-50 shadow-sm ring-1 ring-amber-600/20">
                    <header class="border-b border-amber-200/60 px-4 py-3">
                        <h3 class="text-xs font-semibold uppercase tracking-wide text-amber-800">Not in any column</h3>
                        <p class="mt-1 text-xs text-amber-700">
                            These have no column the site renders, so they are invisible on the page.
                            Drag them into a column above, or set one and save.
                        </p>
                    </header>
                    <ul data-menu-column="" class="min-h-24 space-y-2 p-3">
                        @foreach ($stray as $item)
                            @include('admin.menus.item', ['item' => $item, 'menu' => $menu])
                        @endforeach
                    </ul>
                </section>
            @endif
        </div>

        <section class="h-fit rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-900/5">
            <h2 class="mb-4 text-sm font-semibold text-slate-900">Add a link</h2>
            <form method="POST" action="{{ route('admin.menus.items.store', $menu) }}" class="space-y-4">
                @csrf
                <div>
                    <label for="new-label" class="block text-sm font-medium text-slate-700">Label</label>
                    <input id="new-label" type="text" name="label" required
                        class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm ring-1 ring-slate-200 focus:bg-white focus:ring-2 focus:ring-brand-500">
                </div>
                <div>
                    <label for="new-url" class="block text-sm font-medium text-slate-700">URL</label>
                    <input id="new-url" type="text" name="url" value="/" required list="menu-urls"
                        class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm ring-1 ring-slate-200 focus:bg-white focus:ring-2 focus:ring-brand-500">
                    {{-- every published page, so a link cannot be typo'd into a 404 --}}
                    <datalist id="menu-urls">
                        @foreach (\App\Models\Page::orderBy('name')->get() as $page)
                            <option value="{{ $page->slug === 'home' ? '/' : '/' . $page->slug }}">{{ $page->name }}</option>
                        @endforeach
                    </datalist>
                </div>

                @if ($menu->supportsDropdowns())
                    <div>
                        <label for="new-type" class="block text-sm font-medium text-slate-700">Type</label>
                        <select id="new-type" name="type"
                            class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm ring-1 ring-slate-200 focus:bg-white focus:ring-2 focus:ring-brand-500">
                            <option value="link">Plain link</option>
                            <option value="dropdown">Dropdown panel</option>
                        </select>
                        <p class="mt-1 text-xs text-slate-400">A dropdown opens a panel built from the links you put under it.</p>
                    </div>

                    <div>
                        <label for="new-parent" class="block text-sm font-medium text-slate-700">Position</label>
                        <select id="new-parent" name="parent_id"
                            class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm ring-1 ring-slate-200 focus:bg-white focus:ring-2 focus:ring-brand-500">
                            <option value="">Top row</option>
                            @foreach ($dropdowns as $dropdown)
                                <option value="{{ $dropdown->id }}">Inside “{{ $dropdown->label }}”</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="new-column" class="block text-sm font-medium text-slate-700">Column</label>
                        <input id="new-column" type="text" name="column_heading" list="menu-columns" value="Column 1"
                            class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm ring-1 ring-slate-200 focus:bg-white focus:ring-2 focus:ring-brand-500">
                        <datalist id="menu-columns">
                            @foreach ($items->pluck('column_heading')->filter()->unique() as $column)
                                <option value="{{ $column }}"></option>
                            @endforeach
                        </datalist>
                        <p class="mt-1 text-xs text-slate-400">
                            Only used inside a dropdown. Links sharing a heading share a column; the heading itself is not shown on the site.
                        </p>
                    </div>
                @elseif (! $flat)
                    <div>
                        <label for="new-column" class="block text-sm font-medium text-slate-700">Column</label>
                        @if ($menu->columnMode() === 'fixed')
                            <select id="new-column" name="column_heading" required
                                class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm ring-1 ring-slate-200 focus:bg-white focus:ring-2 focus:ring-brand-500">
                                @foreach ($columns as $column)
                                    <option value="{{ $column }}">{{ $column }}</option>
                                @endforeach
                            </select>
                        @else
                            <input id="new-column" type="text" name="column_heading" required list="menu-columns"
                                value="{{ $columns[0] ?? '' }}"
                                class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm ring-1 ring-slate-200 focus:bg-white focus:ring-2 focus:ring-brand-500">
                            <datalist id="menu-columns">
                                @foreach ($columns as $column)
                                    <option value="{{ $column }}"></option>
                                @endforeach
                            </datalist>
                            <p class="mt-1 text-xs text-slate-400">A new heading creates a new footer column.</p>
                        @endif
                    </div>
                @endif

                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" checked
                        class="h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                    Active
                </label>
                <button type="submit"
                    class="w-full rounded-lg bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-700">
                    Add link
                </button>
            </form>
        </section>
    </div>
@endsection
