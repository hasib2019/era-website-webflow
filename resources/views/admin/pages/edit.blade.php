@extends('admin.layouts.app')

@section('title', $page->name)
@section('subheading', 'Page content')

@section('content')
    <div class="mb-5 flex flex-wrap items-center gap-3">
        <a href="{{ route('admin.pages.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-800">&larr; All pages</a>
        @if ($page->route_name && Route::has($page->route_name))
            <a href="{{ route($page->route_name, $page->route_name === 'services.show' ? ['slug' => 'search-engine-optimization'] : []) }}"
                target="_blank" rel="noopener"
                class="ml-auto rounded-lg px-3 py-1.5 text-sm font-medium text-slate-600 ring-1 ring-slate-200 hover:bg-white">
                Preview page
            </a>
        @endif
    </div>

    <section class="mb-6 rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-900/5">
        <h2 class="mb-5 text-sm font-semibold uppercase tracking-wide text-slate-500">Page settings</h2>
        <form method="POST" action="{{ route('admin.pages.update', $page) }}" class="grid gap-5 sm:grid-cols-2">
            @csrf
            @method('PUT')

            @include('admin.resource.field', ['name' => 'name', 'spec' => ['label' => 'Page name', 'type' => 'text'], 'value' => old('name', $page->name), 'mediaOptions' => $mediaOptions])
            @include('admin.resource.field', ['name' => 'meta_title', 'spec' => ['label' => 'Meta title', 'type' => 'text'], 'value' => old('meta_title', $page->meta_title), 'mediaOptions' => $mediaOptions])

            <div class="sm:col-span-2">
                @include('admin.resource.field', ['name' => 'meta_description', 'spec' => ['label' => 'Meta description', 'type' => 'textarea'], 'value' => old('meta_description', $page->meta_description), 'mediaOptions' => $mediaOptions])
            </div>

            <div class="sm:col-span-2">
                @include('admin.resource.field', ['name' => 'og_image_id', 'spec' => ['label' => 'Share image', 'type' => 'media'], 'value' => old('og_image_id', $page->og_image_id), 'mediaOptions' => $mediaOptions])
            </div>

            @include('admin.resource.field', ['name' => 'is_published', 'spec' => ['label' => 'Published', 'type' => 'checkbox'], 'value' => old('is_published', $page->is_published), 'mediaOptions' => $mediaOptions])

            <div class="sm:col-span-2">
                <button type="submit" class="rounded-lg bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-700">
                    Save page settings
                </button>
            </div>
        </form>
    </section>

    <div class="space-y-5">
        @forelse ($page->sections as $section)
            @include('admin.pages.section', ['section' => $section, 'page' => $page, 'mediaOptions' => $mediaOptions])
        @empty
            <div class="rounded-xl bg-white p-10 text-center text-slate-500 shadow-sm ring-1 ring-slate-900/5">
                This page has no editable sections registered yet.
            </div>
        @endforelse
    </div>

    @include('admin.partials.media-picker', ['mediaOptions' => $mediaOptions])
@endsection
