<?php
/**
 * Gives each page the `data-wf-page` id its own interactions were authored with.
 *
 * Webflow scopes a page-level interaction by addressing its target as
 * "<pageId>|<elementId>", and matches that by combining the page's
 * `data-wf-page` with the element's bare `data-w-id`. The export stamped the
 * *about* page's id onto nearly every page, so on those pages the two never
 * agree, the interaction never runs, and anything whose entry state is
 * `opacity: 0` stays invisible for good.
 *
 * That is not a subtle animation glitch. On the export as shipped it hides the
 * whole contact form and address block on /contact, the "apply for this job"
 * box and the related-jobs list on a career page, and the image blocks on
 * /why-choose-us and a service page — sixteen elements over seven pages.
 *
 * The real id is recoverable from the markup: Webflow suffixes every
 * `w-node-<uuid>-<suffix>` id with the last eight characters of the page id it
 * belongs to, so the most common suffix on a page identifies it. Those eight
 * characters are then matched against the full page ids the interactions data
 * actually references, and only an exact, unambiguous hit is written.
 *
 * Run: php tools/wire_wf_page.php   (registered in tools/build.php)
 */

$APP = dirname(__DIR__);
$VIEWS = $APP . '/resources/views/site/pages/';
$JS = $APP . '/public/site/js/schunk.js';

if (! is_file($JS)) {
    fwrite(STDERR, "  ! schunk.js not found; cannot read the interactions data\n");
    exit(1);
}

$js = file_get_contents($JS);

/** Every page id the interactions data addresses a target under. */
preg_match_all("#'([0-9a-f]{16,})\|[0-9a-f-]{20,}'#", $js, $m);
$pageIds = array_values(array_unique($m[1]));

/** last 8 characters => full page id, dropping any suffix two pages share */
$bySuffix = [];
foreach ($pageIds as $id) {
    $suffix = substr($id, -8);
    $bySuffix[$suffix] = isset($bySuffix[$suffix]) && $bySuffix[$suffix] !== $id
        ? null
        : $id;
}

$fixed = 0;
$kept = 0;
$report = [];

foreach (glob($VIEWS . '*.blade.php') as $file) {
    $blade = file_get_contents($file);
    $name = basename($file, '.blade.php');

    if (! preg_match("#@section\('wf_page', '([^']*)'\)#", $blade, $current)) {
        continue;
    }

    // the suffix Webflow stamped on this page's own generated node ids
    if (! preg_match_all('#\bw-node-[0-9a-f_-]+-([0-9a-f]{8})\b#', $blade, $nodes)) {
        $report[] = sprintf('  %-20s no w-node ids to read a page id from', $name);
        continue;
    }

    /*
     * Rank only the suffixes that are actually page ids.
     *
     * Not every w-node suffix is one — blog-details carries three ids ending
     * 635c92bf, which belongs to no page in the interactions data, and just one
     * ending 564b443a, which is the page. Taking the most common suffix outright
     * picks the wrong one; taking the most common *known* suffix picks the page.
     */
    $counts = array_count_values($nodes[1]);
    arsort($counts);

    $id = null;
    foreach (array_keys($counts) as $candidate) {
        if (! empty($bySuffix[$candidate])) {
            $id = $bySuffix[$candidate];
            break;
        }
    }

    if ($id === null) {
        $report[] = sprintf('  %-20s no w-node suffix matches a known page id', $name);
        continue;
    }

    if ($id === $current[1]) {
        $kept++;
        continue;
    }

    $blade = preg_replace(
        "#@section\('wf_page', '[^']*'\)#",
        "@section('wf_page', '" . $id . "')",
        $blade,
        1,
    );

    file_put_contents($file, $blade);

    $report[] = sprintf('  %-20s %s -> %s', $name, $current[1], $id);
    $fixed++;
}

echo implode("\n", $report), $report ? "\n" : '';
printf("  %d page id(s) corrected, %d already right\n", $fixed, $kept);
