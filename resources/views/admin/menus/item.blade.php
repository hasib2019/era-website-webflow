@php
    /*
     * One draggable link.
     *
     * The card is a form so label, URL and active state save explicitly, while
     * position and column are written by the drag handler the moment you drop —
     * two paths to the same row, but only the cheap one is automatic.
     */
    $field = 'block w-full rounded-md border-0 bg-slate-50 px-2.5 py-1.5 text-xs ring-1 ring-slate-200 focus:bg-white focus:ring-2 focus:ring-brand-500';
@endphp

<li data-menu-item="{{ $item->id }}"
    class="rounded-lg bg-white ring-1 ring-slate-200 transition {{ $item->is_active ? '' : 'opacity-60' }}">
    <div class="flex items-start gap-2 p-2.5">
        <button type="button" data-drag-handle draggable="true" aria-label="Drag {{ $item->label }}"
            class="mt-0.5 cursor-grab rounded p-1 text-slate-300 transition hover:bg-slate-100 hover:text-slate-500 active:cursor-grabbing">
            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <circle cx="7" cy="5" r="1.5" /><circle cx="13" cy="5" r="1.5" />
                <circle cx="7" cy="10" r="1.5" /><circle cx="13" cy="10" r="1.5" />
                <circle cx="7" cy="15" r="1.5" /><circle cx="13" cy="15" r="1.5" />
            </svg>
        </button>

        <form method="POST" action="{{ route('admin.menus.items.update', [$menu, $item]) }}" class="min-w-0 flex-1 space-y-1.5">
            @csrf
            @method('PUT')

            <input type="text" name="label" value="{{ $item->label }}" required aria-label="Label" class="{{ $field }} font-medium">
            <input type="text" name="url" value="{{ $item->url }}" required aria-label="URL" class="{{ $field }} text-slate-500">

            {{-- mirrors the card's column so a plain Save cannot wipe what a drag set --}}
            <input type="hidden" name="column_heading" value="{{ $item->column_heading }}" data-item-column>

            <div class="flex items-center justify-between gap-2 pt-0.5">
                <label class="flex items-center gap-1.5 text-[11px] text-slate-600">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" @checked($item->is_active)
                        class="h-3.5 w-3.5 rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                    Visible
                </label>
                <button type="submit" class="text-[11px] font-semibold text-brand-700 hover:underline">Save</button>
            </div>
        </form>

        <form method="POST" action="{{ route('admin.menus.items.destroy', [$menu, $item]) }}"
            data-confirm="Remove &quot;{{ $item->label }}&quot; from {{ $menu->name }}?" data-confirm-label="Remove">
            @csrf
            @method('DELETE')
            <button type="submit" aria-label="Remove {{ $item->label }}"
                class="rounded p-1 text-slate-300 transition hover:bg-red-50 hover:text-red-600">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </form>
    </div>
</li>
