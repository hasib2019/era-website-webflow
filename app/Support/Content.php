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
 *
 * Every binding carries the export's own literal as its last argument. That
 * literal is a fallback for markup the dashboard cannot reach, *not* a floor
 * under whatever the dashboard holds: where an input exists, what it holds
 * wins, including when it holds nothing. Treating "empty" as "absent" is what
 * made a cleared field spring back to the Webflow copy, and made hiding a
 * section restore the very text it was meant to remove.
 *
 * The resolvers below draw that line with null vs '': null means "no input maps
 * to this", '' means "an input maps to this and it is empty".
 */
class Content
{
    private static array $sections = [];

    private static ?Collection $mediaByFilename = null;

    private static array $menus = [];

    /**
     * One field of one section.
     *
     * `$default` is the export's own copy, returned only when the CMS has
     * nothing to say about this field: no page row, no section row, or a
     * section that never declared it.
     */
    public static function field(string $pageSlug, string $sectionKey, string $fieldKey, mixed $default = null): mixed
    {
        $value = static::rawField($pageSlug, $sectionKey, $fieldKey);

        return $value === null ? $default : $value;
    }

    /** A section field holding a media reference, resolved to a public URL. */
    public static function fieldMedia(string $pageSlug, string $sectionKey, string $fieldKey, ?string $default = null): ?string
    {
        $value = static::rawField($pageSlug, $sectionKey, $fieldKey);

        if ($value === null) {
            return $default;
        }

        // Cleared, or pointing at a library row that has since been deleted --
        // either way, showing the export's original image would be a lie.
        return blank($value) ? null : static::mediaUrl($value, null);
    }

    /** The srcset for a section's image field, on the same terms as fieldMedia(). */
    public static function fieldSrcset(string $pageSlug, string $sectionKey, string $fieldKey, ?string $default = null): ?string
    {
        $value = static::rawField($pageSlug, $sectionKey, $fieldKey);

        if ($value === null) {
            return $default;
        }

        return blank($value) ? null : static::mediaSrcset($value);
    }

    /**
     * The stored value, or null when no dashboard input maps to it.
     *
     * A hidden section reports its fields as empty rather than as absent: the
     * one control meant to remove content must not hand the export's copy back.
     */
    private static function rawField(string $pageSlug, string $sectionKey, string $fieldKey): mixed
    {
        $section = static::section($pageSlug, $sectionKey);

        if ($section === null || ! array_key_exists($fieldKey, $section['content'])) {
            return null;
        }

        if (! $section['visible']) {
            return '';
        }

        return $section['content'][$fieldKey]['value'] ?? '';
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

    /**
     * A site-wide value.
     *
     * Same rule as field(): no row means the dashboard cannot set it, so the
     * template's copy stands, while a row someone emptied is a decision. The
     * settings seeder leaves the logo rows null whenever the media library is
     * empty, so "row present, value null" has to read as empty, not as absent.
     */
    public static function setting(string $path, mixed $default = null): mixed
    {
        $all = Setting::allFlat();

        if (! array_key_exists($path, $all)) {
            return $default;
        }

        return $all[$path] ?? '';
    }

    /** A settings value that holds a media id, resolved to a URL. */
    public static function settingMedia(string $path, ?string $default = null): ?string
    {
        if (! array_key_exists($path, Setting::allFlat())) {
            return $default;
        }

        $value = static::setting($path);

        return blank($value) ? null : static::mediaUrl($value, null);
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
