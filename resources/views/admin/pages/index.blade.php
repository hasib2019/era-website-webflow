@extends('admin.layouts.app')

@section('title', 'Pages')
@section('subheading', 'Edit the content of each public page')

@section('content')
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($pages as $page)
            <a href="{{ route('admin.pages.edit', $page) }}"
                class="group rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-900/5 transition hover:shadow-md hover:ring-brand-200">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <h2 class="truncate text-base font-semibold text-slate-900">{{ $page->name }}</h2>
                        <p class="mt-0.5 truncate text-xs text-slate-500">/{{ $page->slug === 'home' ? '' : $page->slug }}</p>
                    </div>
                    <span class="shrink-0 rounded-full px-2 py-0.5 text-xs font-medium {{ $page->is_published ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                        {{ $page->is_published ? 'Live' : 'Hidden' }}
                    </span>
                </div>
                <p class="mt-4 text-xs text-slate-500">
                    {{ $page->sections_count }} editable {{ Str::plural('section', $page->sections_count) }}
                </p>
            </a>
        @endforeach
    </div>
@endsection
