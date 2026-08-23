<?php
/**
 * Rewrites the converted Blade pages so their copy and images come from the CMS.
 *
 * Every replacement keeps the template's own value as the fallback argument, so
 * a page renders exactly as before until someone edits it in the dashboard —
 * which is what tools/verify.php then checks.
 *
 * Must run directly after convert.php, on freshly generated views. Run alone
 * against already-wired views and it reports everything as "not found", because
 * the literals it looks for have already become Blade expressions.
 *
 * Run: php tools/build.php   (or php tools/make_dynamic.php [--dry] after convert)
 */

$APP = dirname(__DIR__);
$VIEWS = $APP . '/resources/views/site/pages/';
$dry = in_array('--dry', $argv, true);

$pages = json_decode(file_get_contents($APP . '/database/data/pages.json'), true);

/** page slug => blade file */
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

/** A whitespace-tolerant pattern for a text node's contents. */
function text_pattern(string $value): string
{
    $parts = preg_split('/\s+/', trim($value), -1, PREG_SPLIT_NO_EMPTY);
    if (! $parts) {
        return '';
    }

    return implode('\s+', array_map('preg_quote_slash', $parts));
}

function preg_quote_slash(string $s): string
{
    return preg_quote($s, '#');
}

/** PHP single-quoted literal for the fallback argument. */
function php_literal(string $value): string
{
    $value = preg_replace('/\s+/', ' ', trim($value));

    return "'" . str_replace(["\\", "'"], ["\\\\", "\'"], $value) . "'";
}

/** Blade needs raw output when the value carries markup or entities. */
function blade_expr(string $call, string $original): string
{
    $needsRaw = str_contains($original, '<');

    return $needsRaw ? '{!! ' . $call . ' !!}' : '{{ ' . $call . ' }}';
}

function e(string $v): string
{
    return htmlspecialchars($v, ENT_QUOTES, 'UTF-8', false);
}

$assetMap = [];
foreach (file(__DIR__ . '/asset_map.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    [$cdn, $local] = explode('|', $line, 2);
    $assetMap[basename(parse_url($cdn, PHP_URL_PATH))] = $local;
}

/** The URL an image field's stored value renders to in the converted markup. */
function image_url(string $value, array $assetMap): ?string
{
    $value = trim($value);
    if ($value === '') {
        return null;
    }

    // the inventory captured srcs verbatim, including the export's ../ prefixes
    if (str_starts_with($value, '../images/') || str_starts_with($value, 'images/')) {
        return '/site/' . ltrim(preg_replace('#^\.\./#', '', $value), '/');
    }

    if (str_starts_with($value, 'http')) {
        $value = basename(parse_url($value, PHP_URL_PATH));
    }

    $value = str_replace(['%20', '(', ')', ' '], '', $value);
    $value = str_replace('case-study-image-11', 'case-study-image-1', $value);

    return $assetMap[$value] ?? null;
}

$totals = ['replaced' => 0, 'ambiguous' => 0, 'missing' => 0];
$report = [];

foreach ($pages as $page) {
    $slug = $page['slug'];
    if (! isset($viewFor[$slug])) {
        continue;
    }

    $file = $VIEWS . $viewFor[$slug] . '.blade.php';
    if (! is_file($file)) {
        $report[] = "  ! no view for page $slug";
        continue;
    }

    $blade = file_get_contents($file);
    $replaced = $ambiguous = $missing = 0;

    foreach ($page['sections'] as $section) {
        foreach ($section['content'] as $key => $definition) {
            $type = $definition['type'] ?? 'text';
            $value = (string) ($definition['value'] ?? '');
            if (trim($value) === '') {
                continue;
            }

            $path = $slug . '.' . $section['key'] . '.' . $key;

            if (in_array($type, ['image', 'icon', 'video'], true)) {
                $url = image_url($value, $assetMap);
                if ($url === null) {
                    $missing++;
                    continue;
                }

                $needle = 'src="' . $url . '"';
                $count = substr_count($blade, $needle);

                if ($count === 0) {
                    // the captured src may have been a -p-500 downscale
                    $base = preg_replace('/-p-\d+(\.[A-Za-z0-9]+)$/', '$1', $url);
                    $needle = 'src="' . $base . '"';
                    $count = substr_count($blade, $needle);
                    $url = $base;
                }

                if ($count !== 1) {
                    $count === 0 ? $missing++ : $ambiguous++;
                    continue;
                }

                $call = "cms_image('$path', '" . $url . "')";
                $blade = str_replace($needle, 'src="{{ ' . $call . ' }}"', $blade);
                $replaced++;
                continue;
            }

            // text lives between tags; anchoring on > and < keeps attributes safe
            $pattern = text_pattern($value);
            if ($pattern === '') {
                continue;
            }

            $regex = '#(?<=>)(\s*)' . $pattern . '(\s*)(?=<)#u';
            $count = preg_match_all($regex, $blade, $m);

            if ($count === 0) {
                // the markup may still hold the entity-encoded form of this copy
                $encoded = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
                $encoded = str_replace(" ", '&nbsp;', $encoded);
                if ($encoded !== $value) {
                    $altPattern = text_pattern($encoded);
                    $altRegex = '#(?<=>)(\s*)' . $altPattern . '(\s*)(?=<)#u';
                    $altCount = preg_match_all($altRegex, $blade, $m);
                    if ($altCount > 0) {
                        $regex = $altRegex;
                        $count = $altCount;
                    }
                }
            }

            if ($count === 0) {
                $missing++;
                continue;
            }

            // more than a handful of hits means the string is too generic to bind
            if ($count > 3) {
                $ambiguous++;
                continue;
            }

            $call = "cms('$path', " . php_literal($value) . ')';
            $blade = preg_replace($regex, '$1' . blade_expr($call, $value) . '$2', $blade);
            $replaced++;
        }
    }

    $totals['replaced'] += $replaced;
    $totals['ambiguous'] += $ambiguous;
    $totals['missing'] += $missing;

    if (! $dry) {
        file_put_contents($file, $blade);
    }

    $report[] = sprintf('  %-20s wired %3d   ambiguous %2d   not-found %2d', $slug, $replaced, $ambiguous, $missing);
}

echo ($dry ? "DRY RUN\n" : "WROTE VIEWS\n"), implode("\n", $report), "\n\n";
printf("total: %d wired, %d ambiguous, %d not found\n", $totals['replaced'], $totals['ambiguous'], $totals['missing']);
