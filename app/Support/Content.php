<?php

namespace App\Support;

use App\Models\Media;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

/**
 * Read side of the CMS.
 *
 * The public views call these through the helpers in helpers.php. Everything is
 * memoised per request because the layout touches settings and menus on every
 * page, and a section's fields are read many times over.
 */
class Content
{
    private static array $sections = [];

    private static ?Collection $mediaByFilename = null;

    private static array $menus = [];

    /** One field of one section, falling back to the template's own copy. */
    public static function field(string $pageSlug, string $sectionKey, string $fieldKey, mixed $default = null): mixed
    {
        $section = static::section($pageSlug, $sectionKey);

        if ($section === null || ! $section['visible']) {
            return $default;
        }

        $value = $section['content'][$fieldKey]['value'] ?? null;

        return ($value === null || $value === '') ? $default : $value;
    }

    /** Whether a section should render at all. */
    public static function sectionVisible(string $pageSlug, string $sectionKey): bool
    {
        return static::section($pageSlug, $sectionKey)['visible'] ?? true;
    }

    private static function section(string $pageSlug, string $sectionKey): ?array
    {
        if (! isset(static::$sections[$pageSlug])) {
            $page = Page::with('sections')->where('slug', $pageSlug)->first();

            static::$sections[$pageSlug] = $page
                ? $page->sections->mapWithKeys(fn ($s) => [
                    $s->key => ['content' => (array) $s->content, 'visible' => (bool) $s->is_visible],
                ])->all()
                : [];
        }

        return static::$sections[$pageSlug][$sectionKey] ?? null;
    }

    /**
     * Resolves a media reference to a public URL.
     *
     * Accepts a media id, a stored filename, or an already-usable path, so a
     * section field keeps working whether it was seeded from the export or
     * re-pointed at an upload from the dashboard.
     */
    public static function mediaUrl(mixed $reference, ?string $default = null): ?string
    {
        if (blank($reference)) {
            return $default;
        }

        if (is_string($reference) && (str_starts_with($reference, '/') || str_starts_with($reference, 'http'))) {
            return $reference;
        }

        static::$mediaByFilename ??= Media::all()->keyBy('filename');

        $media = is_numeric($reference)
            ? static::$mediaByFilename->firstWhere('id', (int) $reference)
            : static::$mediaByFilename->get($reference);

        return $media ? $media->url : $default;
    }

    /** The srcset Webflow shipped for an image, when the variants came across. */
    public static function mediaSrcset(mixed $reference): ?string
    {
        if (blank($reference)) {
            return null;
        }

        static::$mediaByFilename ??= Media::all()->keyBy('filename');

        $media = is_numeric($reference)
            ? static::$mediaByFilename->firstWhere('id', (int) $reference)
            : static::$mediaByFilename->get($reference);

        return $media?->srcset;
    }

    public static function setting(string $path, mixed $default = null): mixed
    {
        $value = Setting::get($path);

        return ($value === null || $value === '') ? $default : $value;
    }

    /** A settings value that holds a media id, resolved to a URL. */
    public static function settingMedia(string $path, ?string $default = null): ?string
    {
        return static::mediaUrl(static::setting($path), $default);
    }

    /** Active items of a menu, ordered, with children eager-loaded. */
    public static function menu(string $slug): Collection
    {
        return static::$menus[$slug] ??= Menu::where('slug', $slug)->first()?->tree() ?? collect();
    }

    /** Clears the per-request caches; used by the tooling and tests. */
    public static function flush(): void
    {
        static::$sections = [];
        static::$mediaByFilename = null;
        static::$menus = [];
    }
}
