@extends('admin.layouts.app')

@section('title', 'Navigation')
@section('subheading', 'Menus rendered on the public site')

@section('content')
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($menus as $menu)
            <a href="{{ route('admin.menus.edit', $menu) }}"
                class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-900/5 transition hover:shadow-md hover:ring-brand-200">
                <h2 class="text-base font-semibold text-slate-900">{{ $menu->name }}</h2>
                <p class="mt-1 text-xs text-slate-500">{{ $menu->description }}</p>
                <p class="mt-4 text-xs text-slate-400">{{ $menu->items_count }} {{ Str::plural('link', $menu->items_count) }}</p>
            </a>
        @endforeach
    </div>
@endsection
