@extends('admin.layouts.app')

@section('title', 'Media library')
@section('subheading', $files->total() . ' files')

@section('content')

    @if (auth()->user()->hasPermission('media.upload'))
        <form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data"
            class="mb-6 rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-900/5">
            @csrf
            <div class="flex flex-wrap items-end gap-4">
                <div class="min-w-56 flex-1">
                    <label for="files" class="block text-sm font-medium text-slate-700">Upload files</label>
                    <input id="files" type="file" name="files[]" multiple required
                        accept="image/*,video/mp4,video/webm,application/pdf"
                        class="mt-1.5 block w-full text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-brand-50 file:px-3.5 file:py-2 file:text-sm file:font-semibold file:text-brand-700 hover:file:bg-brand-100">
                    <p class="mt-1 text-xs text-slate-400">
                        Images, MP4/WebM video and PDF. Select several at once to upload in bulk &mdash;
                        up to {{ $maxFiles }} files, {{ $maxUploadMb }} MB each.
                    </p>
                </div>
                <div class="w-56">
                    <label for="folder" class="block text-sm font-medium text-slate-700">
                        Folder <span class="font-normal text-slate-400">(optional)</span>
                    </label>
                    {{-- a datalist, so an existing folder is one click and a new one is just typed --}}
                    <input id="folder" type="text" name="folder" list="media-folders" autocomplete="off"
                        placeholder="none — straight into /era"
                        class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2 text-sm ring-1 ring-slate-200 focus:bg-white focus:ring-2 focus:ring-brand-500">
                    <datalist id="media-folders">
                        @foreach ($folders as $folder)
                            <option value="{{ $folder }}"></option>
                        @endforeach
                    </datalist>
                    <p class="mt-1 text-xs text-slate-400">Leave empty for <code>public/era</code>.</p>
                </div>
                <button type="submit"
                    class="rounded-lg bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-700">
                    Upload
                </button>
            </div>
        </form>
    @endif

    <form method="GET" class="mb-5 flex flex-wrap gap-3">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Search files…"
            class="w-full max-w-xs rounded-lg border-0 bg-white px-3.5 py-2 text-sm ring-1 ring-slate-200 focus:ring-2 focus:ring-brand-500">
        <select name="folder" onchange="this.form.submit()"
            class="rounded-lg border-0 bg-white px-3.5 py-2 text-sm ring-1 ring-slate-200 focus:ring-2 focus:ring-brand-500">
            <option value="">All folders</option>
            @foreach ($folders as $folder)
                <option value="{{ $folder }}" @selected(request('folder') === $folder)>
                    {{ $folder === 'era' ? 'era (no subfolder)' : $folder }}
                </option>
            @endforeach
        </select>
    </form>

    @if (auth()->user()->hasPermission('media.delete') && $files->count())
        <div class="mb-4 flex flex-wrap items-center gap-x-4 gap-y-2 rounded-xl bg-white px-4 py-3 shadow-sm ring-1 ring-slate-900/5">
            <label class="flex items-center gap-2 text-sm font-medium text-slate-700">
                <input type="checkbox" data-bulk-all
                    class="h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                Select all on this page
            </label>
            <span data-bulk-count class="text-xs text-slate-400">None selected</span>

            {{-- Standalone on purpose. Each card already contains its own update and
                 delete forms, and forms cannot nest, so the checkboxes join this one
                 through their form="media-bulk" attribute instead of by ancestry. --}}
            <form id="media-bulk" method="POST" action="{{ route('admin.media.bulk-destroy') }}"
                class="ml-auto" data-confirm="Delete the selected files? Pages using them will lose the image."
                data-confirm-label="Delete">
                @csrf
                @method('DELETE')
                <button type="submit" data-bulk-submit disabled
                    class="rounded-lg bg-red-600 px-3.5 py-2 text-sm font-semibold text-white transition hover:bg-red-700 disabled:cursor-not-allowed disabled:bg-slate-200 disabled:text-slate-400">
                    Delete selected
                </button>
            </form>
        </div>
    @endif

    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6">
        @forelse ($files as $file)
            <figure class="relative overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-slate-900/5">
                @if (auth()->user()->hasPermission('media.delete'))
                    <label class="absolute left-2 top-2 z-10 flex cursor-pointer items-center rounded-md bg-white/90 p-1 shadow-sm ring-1 ring-slate-900/10 backdrop-blur">
                        <input type="checkbox" form="media-bulk" name="ids[]" value="{{ $file->id }}" data-bulk-item
                            aria-label="Select {{ $file->original_name }}"
                            class="h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                    </label>
                @endif
                <div class="flex aspect-4/3 items-center justify-center bg-slate-100">
                    @if ($file->is_image)
                        <img src="{{ $file->url }}" alt="{{ $file->alt }}" loading="lazy" class="h-full w-full object-cover">
                    @else
                        <span class="text-xs font-semibold uppercase text-slate-400">{{ $file->extension }}</span>
                    @endif
                </div>
                <figcaption class="space-y-2 p-3">
                    <p class="truncate text-xs font-medium text-slate-900" title="{{ $file->path }}">{{ $file->original_name }}</p>
                    <p class="truncate text-[11px] text-slate-400" title="{{ $file->url }}">{{ $file->folder }}</p>
                    <p class="text-[11px] text-slate-400">
                        {{ $file->human_size }}@if ($file->width) &middot; {{ $file->width }}&times;{{ $file->height }} @endif
                    </p>

                    @if (auth()->user()->hasPermission('media.upload'))
                        <form method="POST" action="{{ route('admin.media.update', $file) }}" class="space-y-1.5">
                            @csrf
                            @method('PUT')
                            <input type="text" name="alt" value="{{ $file->alt }}" placeholder="Alt text"
                                class="block w-full rounded-md border-0 bg-slate-50 px-2 py-1 text-[11px] ring-1 ring-slate-200 focus:bg-white focus:ring-2 focus:ring-brand-500">
                            <button type="submit" class="text-[11px] font-semibold text-brand-700 hover:underline">Save</button>
                        </form>
                    @endif

                    <div class="flex items-center gap-3 pt-1">
                        <a href="{{ $file->url }}" target="_blank" rel="noopener"
                            class="text-[11px] font-medium text-slate-500 hover:text-slate-800">Open</a>
                        @if (auth()->user()->hasPermission('media.delete'))
                            <form method="POST" action="{{ route('admin.media.destroy', $file) }}"
                                data-confirm="Delete {{ $file->filename }}? Pages using it will lose the image.">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-[11px] font-medium text-red-600 hover:underline">Delete</button>
                            </form>
                        @endif
                    </div>
                </figcaption>
            </figure>
        @empty
            <p class="col-span-full rounded-xl bg-white py-12 text-center text-slate-500 shadow-sm ring-1 ring-slate-900/5">
                No files match.
            </p>
        @endforelse
    </div>

    @if ($files->hasPages())
        <div class="mt-6">{{ $files->links() }}</div>
    @endif
@endsection
