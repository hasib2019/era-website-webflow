<?php
/**
 * Wires each page's video-lightbox JSON to its "Video Url" field.
 *
 * convert.php ships the export's `<script type="application/json" class="w-json">`
 * block for the video lightbox verbatim, hardcoding the one YouTube video the
 * export happened to link. The "Video Url" field on /admin/pages/{home,services}
 * saved to the database (it's a plain PageSection field, seed_page_fields.php
 * already declared it) but nothing ever read it back -- the lightbox kept
 * opening the export's own video regardless of what the dashboard held.
 *
 * Replaces the JSON block with `@json(cms_video(...))`; see that function's
 * own docblock in app/Support/helpers.php for why it rebuilds a plain YouTube
 * iframe instead of routing through Webflow's embed.ly proxy.
 *
 * Re-runnable: a block already reading cms_video(...) is left alone.
 *
 * Run: php tools/build.php   (or php tools/wire_video.php [--dry])
 */

define('NEEDS_EXPORT', false);
require __DIR__ . '/config.php';

$dry = in_array('--dry', $argv, true);
$views = SITE_VIEWS . 'pages/';

/** page slug => [blade view, cms() path of its video-url field] */
$targets = [
    'home' => ['view' => 'home', 'path' => 'home.home_video.video_url'],
    'services' => ['view' => 'services', 'path' => 'services.service_video.video_url'],
];

$wired = 0;
$skipped = 0;

foreach ($targets as $slug => $t) {
    $file = $views . $t['view'] . '.blade.php';

    if (! is_file($file)) {
        fwrite(STDERR, "$slug: SKIPPED -- {$t['view']}.blade.php not found\n");
        $skipped++;
        continue;
    }

    $html = file_get_contents($file);

    if (str_contains($html, "cms_video('{$t['path']}'")) {
        echo "$slug: already wired\n";
        $wired++;
        continue;
    }

    if (! preg_match('/<script type="application\/json" class="w-json">.*?<\/script>/s', $html, $m)) {
        fwrite(STDERR, "$slug: SKIPPED -- no video lightbox JSON found in {$t['view']}.blade.php\n");
        $skipped++;
        continue;
    }

    // the export's own video, kept as the last fallback
    if (! preg_match('/"url":\s*"([^"]+)"/', $m[0], $lit)) {
        fwrite(STDERR, "$slug: SKIPPED -- lightbox JSON has no \"url\" to use as a fallback\n");
        $skipped++;
        continue;
    }
    $default = $lit[1];

    $replacement = '<script type="application/json" class="w-json">'
        . "@json(cms_video('{$t['path']}', '{$default}'))"
        . '</script>';

    $html = substr_replace($html, $replacement, strpos($html, $m[0]), strlen($m[0]));

    if ($dry) {
        echo "$slug: would wire (default {$default})\n";
    } else {
        file_put_contents($file, $html);
        echo "$slug: wired (default {$default})\n";
    }
    $wired++;
}

printf("\n%d page(s) wired, %d skipped\n", $wired, $skipped);
if ($skipped > 0) {
    exit(1);
}
