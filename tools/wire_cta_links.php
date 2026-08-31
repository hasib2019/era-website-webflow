<?php
/**
 * Binds a CTA anchor's href to the section field that names its destination.
 *
 * make_dynamic.php already binds this kind of button's *label* by matching its
 * text between tags. A `url`-typed field has no text node to match -- it sits
 * inside `href="..."` -- and the rewritten value ("/contact") is shared by
 * every other link to the same page in the document (Webflow also reuses one
 * `data-w-id` across every instance of a button component, so that cannot
 * disambiguate an anchor either). A plain occurrence count, the safeguard
 * make_dynamic.php uses for text and images, would call every one of these
 * ambiguous and bind nothing.
 *
 * Each entry below instead names a marker string that *is* unique in the
 * page -- typically the `data-w-id` of the element wrapping the button, which
 * Webflow does mint fresh per instance -- and rewrites the href of the next
 * anchor after it. Uniqueness is checked at run time so a future entry that
 * turns out not to be unique fails loudly instead of mis-binding.
 *
 * Run: php tools/wire_cta_links.php
 */

require __DIR__ . '/lib_rewrite.php';

$APP = dirname(__DIR__);
$VIEWS = $APP . '/resources/views/site/pages/';

$pages = json_decode(file_get_contents($APP . '/database/data/pages.json'), true);
$sections = [];
foreach ($pages as $page) {
    foreach ($page['sections'] as $section) {
        $sections[$page['slug']][$section['key']] = $section['content'];
    }
}

/** view file => [ [unique marker before the <a>, page slug, section key, field key], ... ] */
$LINKS = [
    'home' => [
        ['data-w-id="2c20399a-82f8-c9ea-8c7f-33c1b402bb1d"', 'home', 'home_about_us', 'button_url'],
    ],
];

$map = link_map();
$total = 0;

foreach ($LINKS as $view => $anchors) {
    $file = $VIEWS . $view . '.blade.php';
    if (! is_file($file)) {
        continue;
    }

    $html = file_get_contents($file);
    $bound = 0;

    foreach ($anchors as [$marker, $slug, $sectionKey, $fieldKey]) {
        $literal = $sections[$slug][$sectionKey][$fieldKey]['value'] ?? null;
        if ($literal === null) {
            printf("  %-10s ! %s.%s.%s not in pages.json\n", $view, $slug, $sectionKey, $fieldKey);
            continue;
        }

        if (substr_count($html, $marker) !== 1) {
            printf("  %-10s ! marker for %s.%s.%s is not unique, skipped\n", $view, $slug, $sectionKey, $fieldKey);
            continue;
        }

        $markerPos = strpos($html, $marker);
        $tagStart = strpos($html, '<a', $markerPos);
        $tagEnd = $tagStart !== false ? strpos($html, '>', $tagStart) : false;

        if ($tagStart === false || $tagEnd === false) {
            printf("  %-10s ! no <a> tag found after marker for %s.%s.%s\n", $view, $slug, $sectionKey, $fieldKey);
            continue;
        }

        $tag = substr($html, $tagStart, $tagEnd - $tagStart + 1);
        $default = $map[$literal] ?? $literal;
        $path = "$slug.$sectionKey.$fieldKey";
        $call = "cms_url('$path', '" . addslashes($default) . "')";
        $newTag = preg_replace('#href="[^"]*"#', 'href="{{ ' . $call . ' }}"', $tag, 1, $count);

        if ($count !== 1) {
            printf("  %-10s ! no href on the anchor after marker for %s.%s.%s\n", $view, $slug, $sectionKey, $fieldKey);
            continue;
        }

        $html = substr($html, 0, $tagStart) . $newTag . substr($html, $tagEnd + 1);
        $bound++;
    }

    file_put_contents($file, $html);
    $total += $bound;
    printf("  %-10s %d link(s) bound\n", $view, $bound);
}

printf("\ntotal: %d link(s) bound\n", $total);
