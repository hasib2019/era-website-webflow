@php
    /*
     * Flash messages and validation errors are not drawn here any more; they are
     * handed to the toast layer in admin.js.
     *
     * Rendering them inline pushed the page down on every save and left the
     * notice sitting above content the user had already moved on from. A toast
     * announces and then gets out of the way.
     */
    $toasts = [];

    foreach (['success', 'error', 'warning', 'info'] as $tone) {
        if (filled(session($tone))) {
            $toasts[] = ['type' => $tone, 'message' => (string) session($tone)];
        }
    }

    if ($errors->any()) {
        $toasts[] = [
            'type' => 'error',
            'title' => 'Please fix the following',
            'items' => $errors->all(),
        ];
    }
@endphp

@if ($toasts)
    {{-- Blade escapes the attribute, so a message containing quotes or markup
         cannot break out of it; admin.js JSON.parses it back on load. --}}
    <div data-toasts="{{ json_encode($toasts, JSON_UNESCAPED_UNICODE) }}" hidden></div>
@endif
