<?php
/**
 * Rebuilds the public site views from the Webflow export.
 *
 * The views under resources/views/site/pages are GENERATED. Editing them by hand
 * works until the next rebuild throws the edit away, so a change belongs in the
 * export (for markup) or in one of the wiring passes below (for bindings).
 *
 *   php tools/build.php            rebuild the views
 *   php tools/build.php --data     re-extract the seed data first, then rebuild
 *   php tools/build.php --verify   rebuild, then compare every page to the export
 *
 * --verify needs the site running; start it with `php artisan serve` first.
 */

require __DIR__ . '/config.php';

$args = array_slice($argv, 1);
$withData = in_array('--data', $args, true);
$withVerify = in_array('--verify', $args, true);

/** Seed-data extraction. Only needed when the export itself changed. */
$data = [
    'extract_content.php' => 'collections -> database/data/content.json',
    'build_pages_json.php' => 'page sections -> database/data/pages.json',
    'extract_why_choose_us.php' => 'fills in the one page the inventory missed',
    'decode_entities.php' => 'normalises &amp; and &nbsp; in page copy',
    'seed_page_fields.php' => 'declares the section fields wire_page_text.php binds',
];

/**
 * View generation. Order matters: convert.php rewrites the views from scratch,
 * and every pass after it edits what the previous one produced.
 */
$views = [
    'convert.php' => 'export HTML -> Blade views and shared partials',
    'make_dynamic.php' => 'binds page-section fields',
    'wire_footer.php' => 'footer -> settings + footer menu',
    'wire_navbar.php' => 'navbar -> settings + primary and mega menus',
    'wire_collections.php' => 'repeated cards -> collection loops',
    'wire_repeaters.php' => 'process strips (first card keeps its extra class)',
    'wire_clients.php' => 'client marquee, both copies of each row',
    'wire_stats.php' => 'animated counters',
    'wire_cta_links.php' => 'CTA button hrefs make_dynamic.php cannot disambiguate',
    'wire_testimonials.php' => 'tab slider, ids regenerated per item',
    'wire_details.php' => 'detail pages read the record in the URL',
    'wire_forms.php' => 'contact and newsletter forms post to Laravel',
    'wire_seo.php' => 'page titles read the page Meta title field',
    'wire_contact.php' => 'contact details and copyright read the settings',
    'wire_chrome.php' => 'top-bar links, header button and remaining labels',
    'wire_page_text.php' => 'job hero fields, footer wordmark, remaining page labels',
];

function run(string $script, string $why): void
{
    printf("\n\033[1m%s\033[0m  %s\n", $script, $why);

    $command = escapeshellarg(PHP_BINARY) . ' ' . escapeshellarg(__DIR__ . '/' . $script);
    passthru($command, $status);

    if ($status !== 0) {
        fwrite(STDERR, "\n$script failed (exit $status); stopping.\n");
        exit($status);
    }
}

echo "Export: " . EXPORT_ROOT . "\n";

if ($withData) {
    echo "\n=== seed data ===\n";
    foreach ($data as $script => $why) {
        run($script, $why);
    }
    echo "\nRun `php artisan db:seed` to load the refreshed data.\n";
}

echo "\n=== views ===\n";
foreach ($views as $script => $why) {
    run($script, $why);
}

echo "\n=== clearing the compiled view cache ===\n";
passthru(escapeshellarg(PHP_BINARY) . ' ' . escapeshellarg(APP_ROOT . '/artisan') . ' view:clear');

if ($withVerify) {
    echo "\n=== verifying against the export ===\n";
    run('verify.php', 'every page must come back identical');
}

echo "\nDone.\n";
