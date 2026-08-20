<?php

use Illuminate\Support\Facades\Request;

if (! function_exists('nav_active')) {
    /**
     * Whether a nav/footer link points at the page being rendered.
     *
     * Webflow bakes `w--current` + `aria-current="page"` into whichever page it
     * exported; the converter strips those and calls this instead so one shared
     * partial can serve every route.
     */
    function nav_active(string $path): bool
    {
        $pattern = trim($path, '/');

        return Request::is($pattern === '' ? '/' : $pattern);
    }
}
