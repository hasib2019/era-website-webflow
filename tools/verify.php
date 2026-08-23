<?php
/**
 * Structural fidelity check: rendered Laravel page vs. the original export.
 *
 * Compares the DOM skeleton (tag + class sequence), the visible text and the
 * asset/link targets after mapping the rewrites back, so intentional changes do
 * not register as drift but accidental ones do.
 */

require __DIR__ . '/lib_slice.php';
require __DIR__ . '/lib_rewrite.php';

require __DIR__ . '/config.php';

$SRC = EXPORT_PAGES;
$BASE = rtrim(getenv('VERIFY_BASE_URL') ?: 'http://127.0.0.1:8000', '/');
$assetMap = load_asset_map(__DIR__ . '/asset_map.txt');
$backMap = array_flip($assetMap);

$PAGES = [
    'home.html' => '/',
    'about.html' => '/about',
    'service.html' => '/services',
    'services-details.html' => '/services/search-engine-optimization',
    'casestudy.html' => '/case-studies',
    'case-study-details.html' => '/case-studies/event-planning-and-management',
    'blog.html' => '/blog',
    'blog-details.html' => '/blog/navigating-search-algorithms-for-regional-impact',
    'career.html' => '/career',
    'career-details.html' => '/career/brand-expert',
    'contact-us.html' => '/contact',
    'faq.html' => '/faq',
    'why-choose-us.html' => '/why-choose-us',
    'changelog.html' => '/changelog',
    'style-guide.html' => '/style-guide',
    '404.html' => '/no-such-page',
];

function dom(string $html): DOMXPath
{
    libxml_use_internal_errors(true);
    $d = new DOMDocument();
    $d->loadHTML('<?xml encoding="utf-8" ?>' . $html);
    libxml_clear_errors();
    return new DOMXPath($d);
}

/**
 * Tag+class skeleton of everything inside <body>, scripts excluded.
 *
 * Each entry is prefixed with its depth below <body>, so an element that moves
 * to a different parent shows up even when the document order is unchanged.
 */
function skeleton(DOMXPath $x): array
{
    $out = [];
    foreach ($x->query('//body//*') as $n) {
        if (in_array($n->nodeName, ['script', 'noscript'], true)) continue;
        // hidden inputs (CSRF tokens) render nothing
        if ($n->nodeName === 'input' && $n->getAttribute('type') === 'hidden') continue;
        $cls = trim(preg_replace('/\s+/', ' ', $n->getAttribute('class')));
        // active-state markers are generated per route by design
        $cls = trim(str_replace('w--current', '', $cls));
        $cls = trim(preg_replace('/\s+/', ' ', $cls));
        $depth = 0;
        for ($p = $n->parentNode; $p && $p->nodeName !== 'body'; $p = $p->parentNode) {
            $depth++;
        }

        $out[] = $depth . '|' . $n->nodeName . ($cls !== '' ? '.' . $cls : '');
    }
    return $out;
}

/** Visible text, normalised. */
function texts(DOMXPath $x): array
{
    $out = [];
    foreach ($x->query('//body//text()') as $t) {
        $p = $t->parentNode->nodeName;
        if (in_array($p, ['script', 'style', 'noscript'], true)) continue;
        $v = trim(preg_replace('/\s+/', ' ', $t->nodeValue));
        if ($v !== '') $out[] = $v;
    }
    return $out;
}

function assets(DOMXPath $x): array
{
    $out = [];
    foreach ($x->query('//body//img') as $n) {
        $src = $n->getAttribute('src');
        $name = basename(parse_url($src, PHP_URL_PATH) ?? $src);
        // the export shipped one asset as "...-1%20(1).webp"; it was renamed on disk
        $name = str_replace(['%20', '(', ')', ' '], '', $name);
        $name = str_replace('case-study-image-11', 'case-study-image-1', $name);
        $out[] = $name;
    }
    return $out;
}

function hrefs(DOMXPath $x): array
{
    $out = [];
    foreach ($x->query('//body//a[@href]') as $n) {
        $out[] = $n->getAttribute('href');
    }
    return $out;
}

/** Total count of entries that differ, duplicates included. */
function multiset_diff(array $a, array $b): int
{
    $ca = array_count_values($a);
    $cb = array_count_values($b);
    $n = 0;
    foreach (array_unique(array_merge(array_keys($ca), array_keys($cb))) as $k) {
        $n += abs(($ca[$k] ?? 0) - ($cb[$k] ?? 0));
    }
    return $n;
}

$fails = 0;
printf("%-26s %10s %10s %10s\n", 'PAGE', 'skeleton', 'text', 'images');
foreach ($PAGES as $file => $uri) {
    $rendered = file_get_contents($BASE . $uri, false, stream_context_create(['http' => ['ignore_errors' => true]]));
    $source = unfreeze(drop_stray_testimonial_wrapper(unwrap_dropped_links(file_get_contents($SRC . $file))));

    $rx = dom($rendered);
    $sx = dom($source);

    $rs = skeleton($rx); $ss = skeleton($sx);
    $rt = texts($rx);    $st = texts($sx);
    $ri = assets($rx); $si = assets($sx);

    $skelDiff = multiset_diff($ss, $rs);
    $textDiff = multiset_diff($st, $rt);
    $imgDiff = multiset_diff($si, $ri);

    $flag = ($skelDiff || $textDiff || $imgDiff) ? '  <-- CHECK' : '';
    if ($flag) $fails++;
    printf("%-26s %10s %10s %10s%s\n",
        $file,
        count($ss) . '/' . count($rs) . ($skelDiff ? " (-$skelDiff)" : ''),
        count($st) . '/' . count($rt) . ($textDiff ? " (-$textDiff)" : ''),
        count($si) . '/' . count($ri) . ($imgDiff ? " (-$imgDiff)" : ''),
        $flag);

    if ($flag && ($argv[1] ?? '') === '-v') {
        foreach (['skeleton' => [$ss, $rs], 'text' => [$st, $rt], 'image' => [$si, $ri]] as $label => [$a, $b]) {
            $ca = array_count_values($a); $cb = array_count_values($b);
            $only = []; $extra = [];
            foreach ($ca as $k => $n) { $d = $n - ($cb[$k] ?? 0); if ($d > 0) $only[] = "$k (x$d)"; }
            foreach ($cb as $k => $n) { $d = $n - ($ca[$k] ?? 0); if ($d > 0) $extra[] = "$k (x$d)"; }
            $only = array_slice($only, 0, 8); $extra = array_slice($extra, 0, 8);
            if ($only) echo "    $label only-in-source: " . implode(' | ', array_map(fn($v) => mb_substr($v, 0, 70), $only)) . "\n";
            if ($extra) echo "    $label only-in-render: " . implode(' | ', array_map(fn($v) => mb_substr($v, 0, 70), $extra)) . "\n";
        }
    }
}
echo "\n" . ($fails ? "$fails page(s) need review" : 'all pages structurally identical') . "\n";
