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

if (! function_exists('cms')) {
    /**
     * One editable field of one page section.
     *
     * The second argument is the value the template shipped with. It stands in
     * only where the dashboard has no input for the field -- clear the box in
     * /admin/pages and the page renders nothing there, which is the point of
     * the box.
     */
    function cms(string $path, mixed $default = null): mixed
    {
        [$page, $section, $field] = array_pad(explode('.', $path, 3), 3, null);

        return App\Support\Content::field($page, $section, $field, $default);
    }
}

if (! function_exists('cms_image')) {
    /** A section field holding a media reference, resolved to a public URL. */
    function cms_image(string $path, ?string $default = null): ?string
    {
        [$page, $section, $field] = array_pad(explode('.', $path, 3), 3, null);

        return App\Support\Content::fieldMedia($page, $section, $field, $default);
    }
}

if (! function_exists('cms_srcset')) {
    /** The responsive srcset for a section's image field, when one exists. */
    function cms_srcset(string $path, ?string $default = null): ?string
    {
        [$page, $section, $field] = array_pad(explode('.', $path, 3), 3, null);

        return App\Support\Content::fieldSrcset($page, $section, $field, $default);
    }
}

if (! function_exists('cms_section_visible')) {
    function cms_section_visible(string $page, string $section): bool
    {
        return App\Support\Content::sectionVisible($page, $section);
    }
}

if (! function_exists('setting')) {
    function setting(string $path, mixed $default = null): mixed
    {
        return App\Support\Content::setting($path, $default);
    }
}

if (! function_exists('setting_image')) {
    function setting_image(string $path, ?string $default = null): ?string
    {
        return App\Support\Content::settingMedia($path, $default);
    }
}

if (! function_exists('cms_menu')) {
    function cms_menu(string $slug): Illuminate\Support\Collection
    {
        return App\Support\Content::menu($slug);
    }
}
