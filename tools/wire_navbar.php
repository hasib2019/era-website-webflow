<?php
/**
 * Points the navbar partial at the CMS: the two logo images come from settings,
 * and the three link groups (top bar, quick links, mega-menu dropdown) each
 * become a loop over their menu.
 *
 * Run: php tools/wire_navbar.php
 */

require __DIR__ . '/lib_slice.php';

$file = dirname(__DIR__) . '/resources/views/site/partials/navbar.blade.php';
$html = file_get_contents($file);
$before = strlen($html);

// ---------------------------------------------------------------- logos
$html = str_replace(
    'src="/storage/media/webflow/664c33abd0e16d4b14b10a0c_Logo.png"',
    'src="{{ setting_image(\'general.logo_light_id\', \'/storage/media/webflow/664c33abd0e16d4b14b10a0c_Logo.png\') }}"',
    $html
);
$html = str_replace(
    'src="/storage/media/webflow/668c2e6e687f356e879426a1_Logo-black.svg"',
    'src="{{ setting_image(\'general.logo_dark_id\', \'/storage/media/webflow/668c2e6e687f356e879426a1_Logo-black.svg\') }}"',
    $html
);

/** Turns a run of sibling anchors into a @foreach over a menu. */
function bind_anchor_run(string $html, int $firstOpen, int $lastEnd, string $menu, string $textClass): string
{
    $template = substr($html, $firstOpen, match_close($html, $firstOpen, 'a') - $firstOpen);

    $anchor = preg_replace('#nav_active\(\'[^\']*\'\)#', 'nav_active($item->url)', $template);
    $anchor = preg_replace('#href="[^"]*"#', 'href="{{ $item->url }}"', $anchor);
    $anchor = preg_replace(
        '#(<div class="' . preg_quote($textClass, '#') . '">)[^<]*(</div>)#',
        '$1{{ $item->label }}$2',
        $anchor
    );

    $loop = "@foreach (cms_menu('$menu') as \$item)" . $anchor . '@endforeach';

    return substr($html, 0, $firstOpen) . $loop . substr($html, $lastEnd);
}

/** Offsets of the first and last anchor carrying $class inside $containerOpen. */
function anchor_run(string $html, int $containerOpen, string $class): array
{
    $end = match_close($html, $containerOpen, 'div');
    $needle = '<a ';
    $offsets = [];
    $i = $containerOpen;

    while (($i = strpos($html, $needle, $i)) !== false && $i < $end) {
        $tagEnd = strpos($html, '>', $i);
        $tag = substr($html, $i, $tagEnd - $i);
        if (str_contains($tag, $class)) {
            $offsets[] = [$i, match_close($html, $i, 'a')];
        }
        $i = $tagEnd;
    }

    return $offsets;
}

// ---------------------------------------------------------------- top bar
$menuOpen = strpos($html, '<div class="nav-main-menu-wrap">');
if ($menuOpen === false) {
    fwrite(STDERR, "nav-main-menu-wrap not found\n");
    exit(1);
}

$run = anchor_run($html, $menuOpen, 'nav-main-menu-link');
if (count($run) < 2) {
    fwrite(STDERR, 'expected several top-bar links, found ' . count($run) . "\n");
    exit(1);
}
$html = bind_anchor_run($html, $run[0][0], end($run)[1], 'primary', 'main-menu-nav-link-text');

// ---------------------------------------------------------------- mega dropdown
// Three columns of links; each column keeps its wrapper and gets its own loop,
// driven by the column_heading stored on the menu items.
$columns = [];
$offset = 0;
while (($pos = strpos($html, '<div class="nav-dropdown-column">', $offset)) !== false) {
    $columns[] = $pos;
    $offset = $pos + 1;
}

if (count($columns) === 0) {
    fwrite(STDERR, "no nav-dropdown-column found\n");
    exit(1);
}

// rewrite from the last column backwards so earlier offsets stay valid
foreach (array_reverse($columns) as $index => $colOpen) {
    $number = count($columns) - $index;
    $run = anchor_run($html, $colOpen, 'link-wrap');

    if (! $run) {
        continue;
    }

    $template = substr($html, $run[0][0], match_close($html, $run[0][0], 'a') - $run[0][0]);

    $anchor = preg_replace('#nav_active\(\'[^\']*\'\)#', 'nav_active($item->url)', $template);
    $anchor = preg_replace('#href="[^"]*"#', 'href="{{ $item->url }}"', $anchor);
    $anchor = preg_replace('#(<div class="nav-link-text">)[^<]*(</div>)#', '$1{{ $item->label }}$2', $anchor);

    $loop = "@foreach (cms_menu('mega')->where('column_heading', 'Column $number') as \$item)"
        . $anchor
        . '@endforeach';

    $html = substr($html, 0, $run[0][0]) . $loop . substr($html, end($run)[1]);
}

file_put_contents($file, $html);

printf("navbar wired (%d -> %d bytes)\n", $before, strlen($html));
