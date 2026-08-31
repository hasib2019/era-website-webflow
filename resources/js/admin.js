/**
 * Dashboard behaviour. Deliberately dependency-free: the public site already
 * ships jQuery and the Webflow runtime, and the two must not meet.
 */

/* ------------------------------------------------------------------ toasts */

/*
 * Tailwind scans this file (see @source in admin.css), so every class has to
 * appear as a whole literal string. Building them from parts at runtime — even
 * something as small as `bg-${tone}-50` — produces classes the compiler never
 * sees and the toast renders unstyled.
 */
const TONES = {
    success: {
        ring: 'ring-emerald-600/20',
        icon: 'text-emerald-600',
        bar: 'bg-emerald-500',
        path: 'M4.5 12.75l6 6 9-13.5',
    },
    error: {
        ring: 'ring-red-600/20',
        icon: 'text-red-600',
        bar: 'bg-red-500',
        path: 'M12 9v3.75m0 3.75h.008M10.34 3.94l-8.07 14a1.5 1.5 0 001.3 2.25h16.14a1.5 1.5 0 001.3-2.25l-8.07-14a1.5 1.5 0 00-2.6 0z',
    },
    warning: {
        ring: 'ring-amber-600/20',
        icon: 'text-amber-600',
        bar: 'bg-amber-500',
        path: 'M12 9v3.75m0 3.75h.008M10.34 3.94l-8.07 14a1.5 1.5 0 001.3 2.25h16.14a1.5 1.5 0 001.3-2.25l-8.07-14a1.5 1.5 0 00-2.6 0z',
    },
    info: {
        ring: 'ring-sky-600/20',
        icon: 'text-sky-600',
        bar: 'bg-sky-500',
        path: 'M11.25 11.25h1.5v5.25m-1.5 0h3M12 7.5h.008',
    },
    confirm: {
        ring: 'ring-red-600/30',
        icon: 'text-red-600',
        bar: 'bg-red-500',
        path: 'M12 9v3.75m0 3.75h.008M10.34 3.94l-8.07 14a1.5 1.5 0 001.3 2.25h16.14a1.5 1.5 0 001.3-2.25l-8.07-14a1.5 1.5 0 00-2.6 0z',
    },
};

/** How long each tone stays up. Errors linger; someone has to read them. */
const LIFETIME = { success: 5000, info: 5000, warning: 7000, error: 10000 };

const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

let container = null;

function toastContainer() {
    if (container) return container;

    container = document.createElement('div');
    container.setAttribute('data-toast-container', '');
    container.setAttribute('role', 'region');
    container.setAttribute('aria-label', 'Notifications');
    /*
     * aria-live on the container, not the toast: the region has to exist in the
     * accessibility tree before a child arrives, or screen readers miss the
     * first announcement of the page.
     */
    container.setAttribute('aria-live', 'polite');
    container.className =
        'pointer-events-none fixed inset-x-0 bottom-0 z-50 flex flex-col items-center gap-3 p-4 sm:inset-x-auto sm:bottom-0 sm:right-0 sm:items-end sm:p-6';
    document.body.appendChild(container);

    return container;
}

function svgIcon(tone) {
    return `<svg class="h-5 w-5 shrink-0 ${tone.icon}" fill="none" stroke="currentColor" stroke-width="1.8"
        viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="${tone.path}"/></svg>`;
}

function escapeHtml(value) {
    const el = document.createElement('span');
    el.textContent = value == null ? '' : String(value);

    return el.innerHTML;
}

function dismiss(el) {
    if (!el.isConnected) return;

    el.style.opacity = '0';
    el.style.transform = 'translateY(0.5rem)';
    window.setTimeout(() => el.remove(), reduceMotion ? 0 : 200);
}

/**
 * Show a toast.
 *
 * @param {object}   options
 * @param {string}   options.type     success | error | warning | info | confirm
 * @param {string}   options.message
 * @param {string}  [options.title]
 * @param {string[]}[options.items]   rendered as a bullet list under the message
 * @param {boolean} [options.sticky]  never auto-dismiss
 * @param {object}  [options.action]  {label, onConfirm, cancelLabel} — turns it
 *                                    into a confirmation and implies sticky
 * @returns {HTMLElement}
 */
export function toast(options) {
    const { type = 'info', message = '', title = '', items = [], action = null } = options;
    const tone = TONES[type] ?? TONES.info;
    const sticky = options.sticky ?? Boolean(action);

    const el = document.createElement('div');
    el.className =
        'pointer-events-auto w-full max-w-sm overflow-hidden rounded-xl bg-white shadow-lg ring-1 ' + tone.ring;
    el.style.transition = reduceMotion ? 'none' : 'opacity 200ms ease, transform 200ms ease';
    el.style.opacity = '0';
    el.style.transform = 'translateY(0.5rem)';

    // a confirmation is a dialog, not an announcement: it must take focus
    if (action) {
        el.setAttribute('role', 'alertdialog');
        el.setAttribute('aria-modal', 'false');
    }

    const list = items.length
        ? `<ul class="mt-1.5 list-inside list-disc space-y-0.5 text-slate-600">${items
              .map((i) => `<li>${escapeHtml(i)}</li>`)
              .join('')}</ul>`
        : '';

    const heading = title ? `<p class="font-semibold text-slate-900">${escapeHtml(title)}</p>` : '';

    const buttons = action
        ? `<div class="mt-3 flex gap-2">
               <button type="button" data-toast-confirm
                   class="rounded-lg bg-red-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-red-700">
                   ${escapeHtml(action.label ?? 'Delete')}
               </button>
               <button type="button" data-toast-cancel
                   class="rounded-lg px-3 py-1.5 text-xs font-semibold text-slate-600 ring-1 ring-slate-200 transition hover:bg-slate-50">
                   ${escapeHtml(action.cancelLabel ?? 'Cancel')}
               </button>
           </div>`
        : '';

    el.innerHTML = `
        <div class="flex gap-3 p-4">
            ${svgIcon(tone)}
            <div class="min-w-0 flex-1 text-sm">
                ${heading}
                ${message ? `<p class="text-slate-700">${escapeHtml(message)}</p>` : ''}
                ${list}
                ${buttons}
            </div>
            <button type="button" data-toast-close aria-label="Dismiss"
                class="-m-1 h-6 w-6 shrink-0 rounded text-slate-400 transition hover:bg-slate-100 hover:text-slate-600">&times;</button>
        </div>
        ${sticky ? '' : `<div data-toast-bar class="h-0.5 w-full origin-left ${tone.bar}"></div>`}`;

    toastContainer().appendChild(el);

    // next frame, so the entry transition actually runs
    requestAnimationFrame(() => {
        el.style.opacity = '1';
        el.style.transform = 'translateY(0)';
    });

    el.querySelector('[data-toast-close]')?.addEventListener('click', () => {
        action?.onCancel?.();
        dismiss(el);
    });

    if (action) {
        const cancel = el.querySelector('[data-toast-cancel]');
        el.querySelector('[data-toast-confirm]')?.addEventListener('click', () => {
            dismiss(el);
            action.onConfirm?.();
        });
        cancel?.addEventListener('click', () => {
            action.onCancel?.();
            dismiss(el);
        });
        // Cancel takes focus, not Delete — a stray Enter should not destroy anything
        cancel?.focus({ preventScroll: true });

        el.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                action.onCancel?.();
                dismiss(el);
            }
        });
    }

    if (!sticky) {
        const life = LIFETIME[type] ?? 5000;
        const bar = el.querySelector('[data-toast-bar]');

        if (bar && !reduceMotion) {
            bar.style.transition = `transform ${life}ms linear`;
            requestAnimationFrame(() => {
                bar.style.transform = 'scaleX(0)';
            });
        }

        let timer = window.setTimeout(() => dismiss(el), life);

        // pause while the pointer is on it, so a long message stays readable
        el.addEventListener('mouseenter', () => {
            window.clearTimeout(timer);
            if (bar) {
                const width = bar.getBoundingClientRect().width;
                bar.style.transition = 'none';
                bar.style.transform = `scaleX(${width / el.getBoundingClientRect().width})`;
            }
        });
        el.addEventListener('mouseleave', () => {
            timer = window.setTimeout(() => dismiss(el), life);
            if (bar && !reduceMotion) {
                bar.style.transition = `transform ${life}ms linear`;
                requestAnimationFrame(() => {
                    bar.style.transform = 'scaleX(0)';
                });
            }
        });
    }

    return el;
}

/** A confirmation toast, resolved to true or false. */
export function confirmToast(message, label = 'Delete') {
    return new Promise((resolve) => {
        toast({
            type: 'confirm',
            title: 'Are you sure?',
            message,
            action: {
                label,
                onConfirm: () => resolve(true),
                onCancel: () => resolve(false),
            },
        });
    });
}

// reachable from inline scripts and future screens
window.adminToast = toast;
window.adminConfirm = confirmToast;


/* ------------------------------------------------------- menu drag & drop */

/**
 * Drag-to-arrange navigation.
 *
 * Native HTML5 drag and drop, no library: the dashboard ships no runtime and
 * the public site's jQuery must never meet it. The handle carries draggable,
 * not the card, so the label and URL inputs stay selectable.
 */
function initMenuBoard(board) {
    const url = board.dataset.reorderUrl;
    const token = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
    let dragging = null;

    const columns = () => [...document.querySelectorAll('[data-menu-column]')];

    /** The card the pointer is currently above, so the drop lands where it looks. */
    function cardAfter(list, y) {
        const cards = [...list.querySelectorAll('[data-menu-item]:not(.is-dragging)')];

        return cards.reduce(
            (closest, card) => {
                const box = card.getBoundingClientRect();
                const offset = y - box.top - box.height / 2;

                return offset < 0 && offset > closest.offset ? { offset, element: card } : closest;
            },
            { offset: Number.NEGATIVE_INFINITY, element: null },
        ).element;
    }

    function refreshPlaceholders() {
        columns().forEach((list) => {
            const count = list.querySelectorAll('[data-menu-item]').length;
            const placeholder = list.querySelector('[data-empty]');

            if (count && placeholder) placeholder.remove();
            if (!count && !placeholder) {
                list.insertAdjacentHTML(
                    'beforeend',
                    '<li data-empty class="rounded-lg border border-dashed border-slate-200 py-6 text-center text-xs text-slate-400">Drop a link here</li>',
                );
            }

            const badge = list.closest('section')?.querySelector('[data-column-count]');
            if (badge) badge.textContent = String(count);
        });
    }

    async function persist() {
        const items = [];
        columns().forEach((list) => {
            const column = list.dataset.menuColumn;
            list.querySelectorAll('[data-menu-item]').forEach((card) => {
                items.push({ id: Number(card.dataset.menuItem), column });
                // keep the card's own form in step, so a later Save agrees with the drag
                const field = card.querySelector('[data-item-column]');
                if (field) field.value = column;
            });
        });

        try {
            const res = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest',
                    Accept: 'application/json',
                },
                body: JSON.stringify({ items }),
            });

            if (!res.ok) throw new Error(`HTTP ${res.status}`);

            const body = await res.json().catch(() => ({}));
            toast({ type: 'success', message: body.message || 'Order saved.' });
        } catch (err) {
            toast({
                type: 'error',
                title: 'Order not saved',
                message: 'The new arrangement could not be stored. Reload the page to see what is actually saved.',
            });
        }
    }

    board.addEventListener('dragstart', (e) => {
        const handle = e.target.closest('[data-drag-handle]');
        if (!handle) return;

        dragging = handle.closest('[data-menu-item]');
        dragging.classList.add('is-dragging', 'opacity-40');
        e.dataTransfer.effectAllowed = 'move';
        // Firefox will not start a drag without payload
        e.dataTransfer.setData('text/plain', dragging.dataset.menuItem);
        e.dataTransfer.setDragImage(dragging, 12, 12);
    });

    document.addEventListener('dragend', () => {
        if (!dragging) return;

        dragging.classList.remove('is-dragging', 'opacity-40');
        dragging = null;
        columns().forEach((l) => l.classList.remove('bg-brand-50'));
        refreshPlaceholders();
    });

    document.addEventListener('dragover', (e) => {
        if (!dragging) return;

        const list = e.target.closest('[data-menu-column]');
        if (!list) return;

        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';

        columns().forEach((l) => l.classList.toggle('bg-brand-50', l === list));

        const after = cardAfter(list, e.clientY);
        if (after) {
            list.insertBefore(dragging, after);
        } else {
            list.appendChild(dragging);
        }
    });

    document.addEventListener('drop', (e) => {
        if (!dragging || !e.target.closest('[data-menu-column]')) return;

        e.preventDefault();
        refreshPlaceholders();
        persist();
    });
}

/* ---------------------------------------------------------- media picker */

function initMediaPicker(dialog) {
    const search = dialog.querySelector('[data-media-picker-search]');
    const grid = dialog.querySelector('[data-media-picker-grid]');
    const empty = dialog.querySelector('[data-media-picker-empty]');
    let items = [...dialog.querySelectorAll('[data-media-picker-item]')];
    let activeField = null;

    function filterItems() {
        const query = (search?.value ?? '').trim().toLowerCase();
        let visible = 0;

        items.forEach((item) => {
            const matches = !query || item.dataset.mediaSearch.includes(query);
            item.classList.toggle('hidden', !matches);
            if (matches) visible++;
        });

        empty?.classList.toggle('hidden', visible !== 0 || items.length === 0);
    }

    function markSelected() {
        const input = activeField?.querySelector('[data-media-picker-value]');
        const type = activeField?.dataset.mediaValueType;

        items.forEach((item) => {
            const value = type === 'id' ? item.dataset.mediaId : item.dataset.mediaFilename;
            const selected = Boolean(input?.value) && input.value === value;
            item.classList.toggle('ring-2', selected);
            item.classList.toggle('ring-brand-600', selected);
            item.classList.toggle('ring-slate-200', !selected);
            item.setAttribute('aria-pressed', selected ? 'true' : 'false');
        });
    }

    function refreshField(field, media = null) {
        const preview = field.querySelector('[data-media-picker-preview]');
        const placeholder = field.querySelector('[data-media-picker-placeholder]');
        const name = field.querySelector('[data-media-picker-name]');
        const clear = field.querySelector('[data-media-picker-clear]');
        const openButtons = field.querySelectorAll('[data-media-picker-open]');

        if (media) {
            preview.src = media.url;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
            name.textContent = `${media.name} (${media.filename})`;
            clear.classList.remove('hidden');
            openButtons.forEach((button) => {
                if (button.textContent.trim() === 'Choose image') button.textContent = 'Change image';
            });
        } else {
            preview.removeAttribute('src');
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');
            placeholder.classList.add('flex');
            name.textContent = 'No image selected';
            clear.classList.add('hidden');
            openButtons.forEach((button) => {
                if (button.textContent.trim() === 'Change image') button.textContent = 'Choose image';
            });
        }
    }

    document.querySelectorAll('[data-media-picker-field]').forEach((field) => {
        field.querySelectorAll('[data-media-picker-open]').forEach((button) => {
            button.addEventListener('click', () => {
                activeField = field;
                if (search) search.value = '';
                filterItems();
                markSelected();
                dialog.showModal();
                window.setTimeout(() => search?.focus(), 0);
            });
        });

        field.querySelector('[data-media-picker-clear]')?.addEventListener('click', () => {
            field.querySelector('[data-media-picker-value]').value = '';
            refreshField(field);
        });
    });

    function selectItem(item) {
        if (!activeField) return;

        const type = activeField.dataset.mediaValueType;
        activeField.querySelector('[data-media-picker-value]').value =
            type === 'id' ? item.dataset.mediaId : item.dataset.mediaFilename;
        refreshField(activeField, {
            url: item.dataset.mediaUrl,
            name: item.dataset.mediaName,
            filename: item.dataset.mediaFilename,
        });
        dialog.close();
    }

    function bindItem(item) {
        item.addEventListener('click', () => selectItem(item));
    }

    items.forEach(bindItem);

    /**
     * Adds one freshly-uploaded file to the grid, in the same shape the
     * server renders so search, selection and the "already selected" ring
     * all treat it identically to a pre-existing item.
     */
    function addItem(media) {
        grid?.querySelector('[data-media-picker-no-items]')?.remove();

        const searchText = `${media.name} ${media.filename}`.toLowerCase();
        grid?.insertAdjacentHTML(
            'afterbegin',
            `<button type="button" data-media-picker-item data-media-id="${media.id}"
                data-media-filename="${escapeHtml(media.filename)}" data-media-url="${escapeHtml(media.url)}"
                data-media-name="${escapeHtml(media.name)}" data-media-search="${escapeHtml(searchText)}"
                class="overflow-hidden rounded-xl bg-white text-left ring-1 ring-slate-200 transition hover:ring-2 hover:ring-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500">
                <span class="block aspect-square overflow-hidden bg-slate-100">
                    <img src="${escapeHtml(media.url)}" alt="" loading="lazy" class="h-full w-full object-cover">
                </span>
                <span class="block min-w-0 px-2.5 py-2">
                    <span class="block truncate text-xs font-semibold text-slate-700">${escapeHtml(media.name)}</span>
                    <span class="mt-0.5 block truncate font-mono text-[10px] text-slate-400">${escapeHtml(media.filename)}</span>
                </span>
            </button>`,
        );

        const item = grid?.querySelector('[data-media-picker-item]');
        if (!item) return null;

        items = [item, ...items];
        bindItem(item);

        return item;
    }

    const uploadInput = dialog.querySelector('[data-media-picker-upload-input]');
    const uploadLabel = dialog.querySelector('[data-media-picker-upload-label]');
    const uploadIdle = dialog.querySelector('[data-media-picker-upload-idle]');
    const uploadBusy = dialog.querySelector('[data-media-picker-upload-busy]');
    const uploadError = dialog.querySelector('[data-media-picker-upload-error]');
    const uploadUrl = dialog.dataset.mediaPickerUploadUrl;
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    uploadInput?.addEventListener('change', async () => {
        const files = [...(uploadInput.files ?? [])];
        if (!files.length || !uploadUrl) return;

        uploadError?.classList.add('hidden');
        uploadLabel?.setAttribute('aria-disabled', 'true');
        uploadIdle?.classList.add('hidden');
        uploadBusy?.classList.remove('hidden');

        const body = new FormData();
        files.forEach((file) => body.append('files[]', file));

        try {
            const res = await fetch(uploadUrl, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest', Accept: 'application/json' },
                body,
            });

            const payload = await res.json().catch(() => ({}));

            if (!res.ok && !payload.media?.length) {
                const firstError = payload.errors ? Object.values(payload.errors)[0]?.[0] : null;
                const message = firstError ?? payload.message ?? payload.failed?.join(', ') ?? `Upload failed (HTTP ${res.status}).`;
                if (uploadError) {
                    uploadError.textContent = message;
                    uploadError.classList.remove('hidden');
                }
                return;
            }

            const added = (payload.media ?? []).filter((m) => m.is_image).map(addItem).filter(Boolean);

            if (payload.failed?.length && uploadError) {
                uploadError.textContent = `Could not upload: ${payload.failed.join(', ')}`;
                uploadError.classList.remove('hidden');
            }

            filterItems();

            if (added[0]) selectItem(added[0]);
        } catch {
            if (uploadError) {
                uploadError.textContent = 'Upload failed -- check your connection and try again.';
                uploadError.classList.remove('hidden');
            }
        } finally {
            uploadLabel?.setAttribute('aria-disabled', 'false');
            uploadIdle?.classList.remove('hidden');
            uploadBusy?.classList.add('hidden');
            uploadInput.value = '';
        }
    });

    search?.addEventListener('input', filterItems);
    dialog.querySelector('[data-media-picker-close]')?.addEventListener('click', () => dialog.close());
    dialog.addEventListener('click', (event) => {
        const box = dialog.getBoundingClientRect();
        const outside =
            event.clientX < box.left || event.clientX > box.right || event.clientY < box.top || event.clientY > box.bottom;
        if (outside) dialog.close();
    });
}


/* ---------------------------------------------------------- bulk selection */

/**
 * Checkbox selection for the media grid.
 *
 * The boxes live inside each card but belong to the toolbar's form through
 * their form="media-bulk" attribute, so nothing here has to move them around;
 * it only keeps the count, the select-all state and the confirm wording in
 * step with what is ticked.
 */
function initBulkSelection() {
    const form = document.getElementById('media-bulk');
    const all = document.querySelector('[data-bulk-all]');
    const counter = document.querySelector('[data-bulk-count]');
    const submit = document.querySelector('[data-bulk-submit]');

    if (!form || !submit) return;

    const boxes = () => [...document.querySelectorAll('[data-bulk-item]')];

    function sync() {
        const items = boxes();
        const picked = items.filter((b) => b.checked);

        submit.disabled = picked.length === 0;

        if (counter) {
            counter.textContent = picked.length
                ? `${picked.length} of ${items.length} selected`
                : 'None selected';
        }

        if (all) {
            all.checked = picked.length > 0 && picked.length === items.length;
            // the in-between state, so "select all" is not misreported as empty
            all.indeterminate = picked.length > 0 && picked.length < items.length;
        }

        // the toast confirm reads this at submit time
        form.dataset.confirm =
            picked.length === 1
                ? 'Delete 1 file? Pages using it will lose the image.'
                : `Delete ${picked.length} files? Pages using them will lose the image.`;
    }

    all?.addEventListener('change', () => {
        boxes().forEach((b) => {
            b.checked = all.checked;
        });
        sync();
    });

    document.addEventListener('change', (e) => {
        if (e.target.matches('[data-bulk-item]')) sync();
    });

    sync();
}

/* ------------------------------------------------------------------- boot */

document.addEventListener('DOMContentLoaded', () => {
    // sidebar toggle on narrow screens
    const sidebar = document.querySelector('[data-sidebar]');
    document.querySelectorAll('[data-sidebar-toggle]').forEach((btn) => {
        btn.addEventListener('click', () => {
            if (!sidebar) return;

            const opening = sidebar.classList.contains('hidden');
            sidebar.classList.toggle('hidden', !opening);
            sidebar.classList.toggle('flex', opening);
        });
    });

    // flash messages and validation errors, handed over from the Blade partial
    const payload = document.querySelector('[data-toasts]');
    if (payload) {
        try {
            JSON.parse(payload.dataset.toasts || '[]').forEach((t) => toast(t));
        } catch {
            // a malformed payload must not take the rest of the page down
        }
    }

    /*
     * Confirm before destructive form posts.
     *
     * The toast resolves after the handler has returned, so the submit is
     * cancelled first and replayed on confirmation. `data-confirmed` marks the
     * replay; without it the second pass would ask again, forever.
     */
    document.querySelectorAll('form[data-confirm]').forEach((form) => {
        form.addEventListener('submit', (e) => {
            if (form.dataset.confirmed === 'true') return;

            e.preventDefault();

            confirmToast(form.dataset.confirm, form.dataset.confirmLabel || 'Delete').then((ok) => {
                if (!ok) return;

                form.dataset.confirmed = 'true';
                // requestSubmit keeps native validation; submit() is the old fallback
                if (typeof form.requestSubmit === 'function') {
                    form.requestSubmit();
                } else {
                    form.submit();
                }
            });
        });
    });

    // media grid multi-select
    initBulkSelection();

    // drag-to-arrange navigation
    document.querySelectorAll('[data-menu-board]').forEach(initMenuBoard);

    // thumbnail-based image selection for page content fields
    document.querySelectorAll('[data-media-picker-dialog]').forEach(initMediaPicker);

    // repeatable rows in the section editors
    document.querySelectorAll('[data-repeater]').forEach((repeater) => {
        const list = repeater.querySelector('[data-repeater-list]');
        const template = repeater.querySelector('template');

        repeater.querySelector('[data-repeater-add]')?.addEventListener('click', () => {
            const index = list.children.length;
            list.insertAdjacentHTML('beforeend', template.innerHTML.replaceAll('__INDEX__', index));
        });

        list?.addEventListener('click', (e) => {
            if (e.target.closest('[data-repeater-remove]')) {
                e.target.closest('[data-repeater-row]')?.remove();
            }
        });
    });
});
