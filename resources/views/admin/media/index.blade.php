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
                    <p class="mt-1 text-xs text-slate-400">Images, MP4/WebM video and PDF. Up to 20 files, 20 MB each.</p>
                </div>
                <div class="w-40">
                    <label for="folder" class="block text-sm font-medium text-slate-700">Folder</label>
                    <input id="folder" type="text" name="folder" value="uploads"
                        class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2 text-sm ring-1 ring-slate-200 focus:bg-white focus:ring-2 focus:ring-brand-500">
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
                <option value="{{ $folder }}" @selected(request('folder') === $folder)>{{ $folder }}</option>
            @endforeach
        </select>
    </form>

    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6">
        @forelse ($files as $file)
            <figure class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-slate-900/5">
                <div class="flex aspect-4/3 items-center justify-center bg-slate-100">
                    @if ($file->is_image)
                        <img src="{{ $file->url }}" alt="{{ $file->alt }}" loading="lazy" class="h-full w-full object-cover">
                    @else
                        <span class="text-xs font-semibold uppercase text-slate-400">{{ $file->extension }}</span>
                    @endif
                </div>
                <figcaption class="space-y-2 p-3">
                    <p class="truncate text-xs font-medium text-slate-900" title="{{ $file->filename }}">{{ $file->original_name }}</p>
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
