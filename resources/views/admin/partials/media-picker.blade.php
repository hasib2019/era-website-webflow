@once
<dialog data-media-picker-dialog data-media-picker-upload-url="{{ route('admin.media.store') }}"
    class="m-auto w-[min(64rem,calc(100%-2rem))] max-h-[calc(100vh-2rem)] overflow-hidden rounded-2xl bg-white p-0 text-slate-800 shadow-2xl backdrop:bg-slate-950/60">
    <div class="flex max-h-[calc(100vh-2rem)] flex-col">
        <header class="flex items-start justify-between gap-4 border-b border-slate-200 px-5 py-4 sm:px-6">
            <div>
                <h2 class="text-base font-semibold text-slate-900">Choose an image</h2>
                <p class="mt-0.5 text-xs text-slate-500">Click an image to select it for this field.</p>
            </div>
            <button type="button" data-media-picker-close aria-label="Close image picker"
                class="-m-1 rounded-lg p-2 text-xl leading-none text-slate-400 transition hover:bg-slate-100 hover:text-slate-700">&times;</button>
        </header>

        <div class="flex flex-wrap items-center gap-3 border-b border-slate-100 px-5 py-3 sm:px-6">
            <label for="media-picker-search" class="sr-only">Search images</label>
            <input id="media-picker-search" type="search" data-media-picker-search placeholder="Search by image name or file name..."
                class="min-w-0 flex-1 rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm ring-1 ring-slate-200 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-brand-500">

            @if (auth()->user()->hasPermission('media.upload'))
                <label class="shrink-0 cursor-pointer rounded-lg bg-white px-3.5 py-2.5 text-sm font-semibold text-brand-700 ring-1 ring-slate-200 transition hover:bg-brand-50 aria-disabled:pointer-events-none aria-disabled:opacity-60"
                    data-media-picker-upload-label aria-disabled="false">
                    <span data-media-picker-upload-idle>Upload new image</span>
                    <span data-media-picker-upload-busy class="hidden">Uploading&hellip;</span>
                    <input type="file" accept="image/*" multiple class="sr-only" data-media-picker-upload-input>
                </label>
            @endif
        </div>
        <p data-media-picker-upload-error class="hidden border-b border-red-100 bg-red-50 px-5 py-2 text-xs text-red-700 sm:px-6"></p>

        <div class="overflow-y-auto p-5 sm:p-6">
            <div data-media-picker-grid class="grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
                @forelse ($mediaOptions->filter->is_image as $media)
                    <button type="button" data-media-picker-item data-media-id="{{ $media->id }}"
                        data-media-filename="{{ $media->filename }}" data-media-url="{{ $media->url }}"
                        data-media-name="{{ $media->original_name }}"
                        data-media-search="{{ Str::lower($media->original_name . ' ' . $media->filename . ' ' . $media->folder) }}"
                        class="overflow-hidden rounded-xl bg-white text-left ring-1 ring-slate-200 transition hover:ring-2 hover:ring-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500">
                        <span class="block aspect-square overflow-hidden bg-slate-100">
                            <img src="{{ $media->url }}" alt="" loading="lazy" class="h-full w-full object-cover">
                        </span>
                        <span class="block min-w-0 px-2.5 py-2">
                            <span class="block truncate text-xs font-semibold text-slate-700" title="{{ $media->original_name }}">{{ $media->original_name }}</span>
                            <span class="mt-0.5 block truncate font-mono text-[10px] text-slate-400" title="{{ $media->filename }}">{{ $media->filename }}</span>
                        </span>
                    </button>
                @empty
                    <p data-media-picker-no-items class="col-span-full py-12 text-center text-sm text-slate-500">No images are available in the media library.</p>
                @endforelse
            </div>
            <p data-media-picker-empty class="hidden py-12 text-center text-sm text-slate-500">No image matches your search.</p>
        </div>
    </div>
</dialog>
@endonce
