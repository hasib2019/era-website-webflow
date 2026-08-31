<?php
/**
 * Points each page's <title> at the CMS.
 *
 * convert.php emits the export's title verbatim:
 *
 *     @section('title', 'Home')
 *
 * which meant the Meta title box on /admin/pages/{slug} wrote to a column
 * nothing ever read. This rewrites it to
 *
 *     @section('title', page_title('home', 'Home'))
 *
 * keeping the export's own string as the fallback, so an empty Meta title
 * renders exactly what it always did.
 *
 * Detail pages get detail_title() instead, so /career/{slug} is titled by the
 * job in the URL rather than by whichever record the export happened to be
 * taken from — every career page shipped titled "Brand Expert".
 *
 * Description and og:image are not touched here: they arrive through the
 * `$site` composer in AppServiceProvider, which needs no markup change.
 *
 * Re-runnable: the section is matched however it currently reads, and a view
 * already carrying the wanted expression is left alone.
 *
 * Run: php tools/build.php   (or php tools/wire_seo.php [--dry])
 */

define('NEEDS_EXPORT', false);
require __DIR__ . '/config.php';

$dry = in_array('--dry', $argv, true);
$views = SITE_VIEWS . 'pages/';

/** page slug => blade file, the same map make_dynamic.php uses */
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

/** detail page => the variable its controller passes in */
$recordFor = [
    'service-details' => 'service',
    'case-study-details' => 'caseStudy',
    'blog-details' => 'post',
    'career-details' => 'job',
];

$wired = 0;
$skipped = 0;
$missing = [];

foreach ($viewFor as $slug => $view) {
    $file = $views . $view . '.blade.php';

    if (! is_file($file)) {
        $missing[] = $slug;
        continue;
    }

    $html = file_get_contents($file);

    if (! preg_match("/^([ \t]*)@section\('title',[ \t]*(.+)\)[ \t]*$/m", $html, $m)) {
        $missing[] = $slug;
        continue;
    }

    [$whole, $indent, $current] = $m;

    // the export's own literal, kept as the last fallback
    $literal = preg_match("/'((?:[^'\\\\]|\\\\.)*)'[ \t]*\)?[ \t]*$/", $current, $lit)
        ? $lit[1]
        : $slug;

    $wanted = isset($recordFor[$slug])
        ? sprintf("detail_title($%s ?? null, '%s', '%s')", $recordFor[$slug], $slug, $literal)
        : sprintf("page_title('%s', '%s')", $slug, $literal);

    if (trim($current) === $wanted) {
        $skipped++;
        continue;
    }

    if (! $dry) {
        file_put_contents($file, str_replace($whole, $indent . "@section('title', $wanted)", $html));
    }

    $wired++;
}

printf("  wired %d, already wired %d\n", $wired, $skipped);

if ($missing) {
    printf("  ! no @section('title', ...) found in: %s\n", implode(', ', $missing));
}

echo $dry ? "  (dry run, nothing written)\n" : '';
