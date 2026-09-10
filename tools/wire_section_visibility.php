<?php
/**
 * Wraps each page's top-level content sections in a cms_section_visible() check.
 *
 * cms_section_visible() and PageSection::is_visible already existed -- the
 * "visible on site" toggle in /admin/pages/{slug} saved to the database and
 * blanked the section's own cms() fields (Content::rawField() returns '' for
 * a hidden section), but nothing ever removed the section's markup itself, so
 * an empty shell (icons, static labels, layout wrappers) kept rendering and
 * the toggle looked like it had no effect on the live site.
 *
 * This wraps each section's whole block --
 *
 *     @if(cms_section_visible('home', 'home_hero'))<header class="section-home-hero">
 *     ...
 *     </header>@endif
 *
 * -- gluing the directives to the tag the way wire_collections.php glues
 * @foreach, so no stray whitespace text node shows up in the render.
 *
 * Sections are matched by position: database/data/pages.json lists each
 * page's PageSection rows in the same order convert.php laid the markup out
 * in, which make_dynamic.php also relies on. A couple of pages (case-studies,
 * services) open with a decorative `cursor-wrapper` div that isn't a
 * PageSection at all; that one block is left unwrapped and the count is
 * matched starting from the next one. Anywhere the block count still doesn't
 * line up with the section count, the page is skipped and reported rather
 * than guessed at.
 *
 * Re-runnable: a page already carrying cms_section_visible('slug', ...) is
 * left alone.
 *
 * Run: php tools/build.php   (or php tools/wire_section_visibility.php [--dry])
 */

define('NEEDS_EXPORT', false);
require __DIR__ . '/config.php';
require __DIR__ . '/lib_slice.php';

$dry = in_array('--dry', $argv, true);
$views = SITE_VIEWS . 'pages/';

/** page slug => blade file, the same map wire_seo.php uses (404 has no PageSection-backed blade view) */
$viewFor = [
    'home' => 'home',
    'about' => 'about',
    'services' => 'services',
    'service-details' => 'service-details',
    'case-studies' => 'case-studies',
    'case-study-details' => 'case-study-details',
    'blog' => 'blog',
    'blog-details' => 'blog-details',
    'career' => 'career',
    'career-details' => 'career-details',
    'contact' => 'contact',
    'faq' => 'faq',
    'why-choose-us' => 'why-choose-us',
    'changelog' => 'changelog',
    'style-guide' => 'style-guide',
];

$pagesData = json_decode(file_get_contents(APP_ROOT . '/database/data/pages.json'), true);
$sectionsBySlug = [];
foreach ($pagesData as $p) {
    $sectionsBySlug[$p['slug']] = array_column($p['sections'] ?? [], 'key');
}

/** Top-level sibling blocks of a content region: [start, end, tag]. */
function top_level_blocks(string $content): array
{
    $blocks = [];
    $pos = 0;
    $len = strlen($content);

    while (true) {
        while ($pos < $len && ctype_space($content[$pos])) {
            $pos++;
        }
        if ($pos >= $len) {
            break;
        }
        if (! preg_match('/\G<([a-zA-Z][a-zA-Z0-9]*)/', $content, $m, 0, $pos)) {
            throw new RuntimeException("cannot parse a tag at offset $pos");
        }
        $tag = $m[1];
        $end = match_close($content, $pos, $tag);
        $blocks[] = [$pos, $end, $tag];
        $pos = $end;
    }

    return $blocks;
}

$wired = 0;
$skipped = 0;
$missing = [];

foreach ($viewFor as $slug => $view) {
    $sections = $sectionsBySlug[$slug] ?? [];
    if (! $sections) {
        $missing[] = "$slug (no PageSection rows in pages.json)";
        continue;
    }

    $file = $views . $view . '.blade.php';
    if (! is_file($file)) {
        $missing[] = "$slug (view not found)";
        continue;
    }

    $raw = file_get_contents($file);

    if (str_contains($raw, "cms_section_visible('$slug'")) {
        echo "$slug: already wired\n";
        $wired++;
        continue;
    }

    $marker = "@section('content')";
    $contentPos = strpos($raw, $marker);
    if ($contentPos === false) {
        $missing[] = "$slug (no @section('content'))";
        continue;
    }
    $start = $contentPos + strlen($marker);
    $end = strrpos($raw, '@endsection');
    $content = substr($raw, $start, $end - $start);

    $blocks = top_level_blocks($content);

    $offset = 0;
    if (count($blocks) === count($sections) + 1) {
        [$bs, $be] = $blocks[0];
        $lead = substr($content, $bs, min(120, $be - $bs));
        if (preg_match('/class="[^"]*\bcursor-wrapper\b[^"]*"/', $lead)) {
            $offset = 1;
        }
    }

    $mapped = array_slice($blocks, $offset);
    if (count($mapped) !== count($sections)) {
        fwrite(STDERR, "$slug: SKIPPED -- {$view}.blade.php has " . count($mapped) . " top-level block(s) after the leading cursor-wrapper check, pages.json has " . count($sections) . " section(s)\n");
        $skipped++;
        continue;
    }

    $newContent = $content;
    for ($i = count($mapped) - 1; $i >= 0; $i--) {
        [$bs, $be] = $mapped[$i];
        $key = $sections[$i];
        $newContent = substr($newContent, 0, $be) . '@endif' . substr($newContent, $be);
        $newContent = substr($newContent, 0, $bs) . "@if(cms_section_visible('$slug', '$key'))" . substr($newContent, $bs);
    }

    $newRaw = substr($raw, 0, $start) . $newContent . substr($raw, $end);

    if ($dry) {
        echo "$slug: would wrap " . count($mapped) . " section(s)\n";
    } else {
        file_put_contents($file, $newRaw);
        echo "$slug: wrapped " . count($mapped) . " section(s)\n";
    }
    $wired++;
}

printf("\n%d page(s) wired, %d skipped, %d missing\n", $wired, $skipped, count($missing));
foreach ($missing as $m) {
    echo "  missing: $m\n";
}
if ($skipped > 0) {
    exit(1);
}
