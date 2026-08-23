@extends('admin.layouts.app')

@section('title', $menu->name)
@section('subheading', 'Navigation')

@section('content')
    <a href="{{ route('admin.menus.index') }}" class="mb-5 inline-block text-sm font-medium text-slate-500 hover:text-slate-800">&larr; All menus</a>

    <div class="grid gap-6 lg:grid-cols-3">
        <section class="rounded-xl bg-white shadow-sm ring-1 ring-slate-900/5 lg:col-span-2">
            <header class="border-b border-slate-100 px-5 py-4">
                <h2 class="text-sm font-semibold text-slate-900">Links</h2>
            </header>

            <ul class="divide-y divide-slate-100">
                @forelse ($menu->items()->orderBy('sort_order')->get() as $item)
                    <li class="px-5 py-4">
                        <form method="POST" action="{{ route('admin.menus.items.update', [$menu, $item]) }}"
                            class="grid gap-3 sm:grid-cols-12 sm:items-end">
                            @csrf
                            @method('PUT')

                            <div class="sm:col-span-4">
                                <label class="block text-xs font-medium text-slate-500">Label</label>
                                <input type="text" name="label" value="{{ $item->label }}" required
                                    class="mt-1 block w-full rounded-lg border-0 bg-slate-50 px-3 py-2 text-sm ring-1 ring-slate-200 focus:bg-white focus:ring-2 focus:ring-brand-500">
                            </div>
                            <div class="sm:col-span-4">
                                <label class="block text-xs font-medium text-slate-500">URL</label>
                                <input type="text" name="url" value="{{ $item->url }}" required
                                    class="mt-1 block w-full rounded-lg border-0 bg-slate-50 px-3 py-2 text-sm ring-1 ring-slate-200 focus:bg-white focus:ring-2 focus:ring-brand-500">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-medium text-slate-500">Order</label>
                                <input type="number" name="sort_order" value="{{ $item->sort_order }}"
                                    class="mt-1 block w-full rounded-lg border-0 bg-slate-50 px-3 py-2 text-sm ring-1 ring-slate-200 focus:bg-white focus:ring-2 focus:ring-brand-500">
                            </div>
                            <div class="flex items-center gap-3 sm:col-span-2">
                                <label class="flex items-center gap-1.5 text-xs text-slate-600">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" value="1" @checked($item->is_active)
                                        class="h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                                    On
                                </label>
                                <button type="submit" class="text-xs font-semibold text-brand-700 hover:underline">Save</button>
                            </div>
                        </form>

                        <form method="POST" action="{{ route('admin.menus.items.destroy', [$menu, $item]) }}"
                            class="mt-2" data-confirm="Remove &quot;{{ $item->label }}&quot; from this menu?">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs font-medium text-red-600 hover:underline">Remove link</button>
                        </form>
                    </li>
                @empty
                    <li class="px-5 py-10 text-center text-sm text-slate-400">This menu has no links yet.</li>
                @endforelse
            </ul>
        </section>

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
                    <input id="new-url" type="text" name="url" value="/" required
                        class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm ring-1 ring-slate-200 focus:bg-white focus:ring-2 focus:ring-brand-500">
                </div>
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
