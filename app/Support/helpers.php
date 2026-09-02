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

if (! function_exists('cms_url')) {
    /** A section field holding a link, e.g. a CTA button's destination. */
    function cms_url(string $path, ?string $default = null): ?string
    {
        [$page, $section, $field] = array_pad(explode('.', $path, 3), 3, null);

        return App\Support\Content::url($page, $section, $field, $default);
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

if (! function_exists('youtube_id')) {
    /** The 11-character video id inside a youtube.com/watch, youtu.be, embed or shorts URL. */
    function youtube_id(string $url): ?string
    {
        if (preg_match('/(?:youtube(?:-nocookie)?\.com\/(?:watch\?(?:.*&)?v=|embed\/|shorts\/)|youtu\.be\/)([A-Za-z0-9_-]{11})/', $url, $m)) {
            return $m[1];
        }

        return null;
    }
}

if (! function_exists('cms_video')) {
    /**
     * A section's video-url field, resolved to the JSON its `w-json` script
     * tag needs. public/site/js/lightbox-video.js reads `items[0].html`
     * verbatim, so this builds a plain YouTube iframe rather than routing
     * through Webflow's embed.ly proxy, which is keyed to Webflow's own
     * hosting and has no reason to keep working once a site leaves it.
     *
     * YouTube only, matching every video field the export shipped. A value
     * that isn't a YouTube URL renders no video rather than guessing.
     */
    function cms_video(string $path, string $default): array
    {
        $url = cms($path, $default);
        $id = filled($url) ? youtube_id($url) : null;

        return [
            'items' => $id ? [[
                'url' => $url,
                'originalUrl' => $url,
                'width' => 940,
                'height' => 528,
                'thumbnailUrl' => "https://i.ytimg.com/vi/{$id}/hqdefault.jpg",
                'html' => '<iframe class="embedly-embed" src="https://www.youtube.com/embed/' . $id . '" width="940" height="528" scrolling="no" title="YouTube embed" frameborder="0" allow="autoplay; fullscreen; encrypted-media; picture-in-picture;" allowfullscreen="true"></iframe>',
                'type' => 'video',
            ]] : [],
            'group' => '',
        ];
    }
}

if (! function_exists('page_title')) {
    /**
     * The <title> for a page.
     *
     * `$default` is the title the export baked into the view, which stands until
     * someone fills in Meta title on the page's own screen. Before this, every
     * page hardcoded its title and that field reached nothing.
     */
    function page_title(string $slug, string $default = ''): string
    {
        return App\Support\Content::pageMeta($slug, 'meta_title') ?? $default;
    }
}

if (! function_exists('detail_title')) {
    /**
     * The <title> for a detail page.
     *
     * A job or service page should be titled by the record in the URL, not by
     * the template it renders through: the export baked in whichever record it
     * happened to be taken from ("Brand Expert" on every career page). Falls
     * back to the page-level Meta title, then the export's literal.
     */
    function detail_title(?object $record, string $slug, string $default = ''): string
    {
        foreach (['meta_title', 'title', 'name'] as $column) {
            $value = $record->{$column} ?? null;

            if (filled($value)) {
                return (string) $value;
            }
        }

        return page_title($slug, $default);
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
