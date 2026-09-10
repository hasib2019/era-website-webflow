<?php
/**
 * Lets any item in the top bar be a dropdown, at any position.
 *
 * The export draws the row as a run of plain links followed by one hard-coded
 * "Other page" toggle whose three columns were a second menu. wire_chrome.php
 * binds the links to cms_menu('primary'); this pass folds the toggle into that
 * same loop, so what an item renders as is decided per item:
 *
 *   @foreach (cms_menu('primary') as $item)
 *       @if ($item->isDropdown())  ...the panel, columns from $item->columns()
 *       @else                      ...the plain link
 *
 * Both templates are lifted from the export's own markup rather than written
 * here, so the design is whatever Webflow exported.
 *
 * Two Webflow details this has to respect:
 *
 *  - the toggle and its panel are paired by id (`w-dropdown-toggle-0` /
 *    `w-dropdown-list-0`) and the runtime reads that pairing on load, so both
 *    are regenerated from $loop->index — the same reason the testimonial tabs
 *    regenerate theirs;
 *  - .nav-dropdown-list is a flex row, not a three-column grid, so one column
 *    template looped over $item->columns() gives a panel that grows and shrinks
 *    with the content instead of being stuck at three.
 *
 * Run: php tools/wire_menu.php   (registered in tools/build.php, after wire_chrome)
 */

require __DIR__ . '/lib_slice.php';

$VIEW = dirname(__DIR__) . '/resources/views/site/partials/navbar.blade.php';

if (! is_file($VIEW)) {
    fwrite(STDERR, "  ! navbar.blade.php missing; run convert.php first\n");
    exit(1);
}

$html = file_get_contents($VIEW);

if (str_contains($html, '$item->isDropdown()')) {
    echo "  already wired\n";
    exit(0);
}

/* ---------------------------------------------------------------- the row */

// the clickable row, not the overlay's `nav-link-wrap main-menu-nav-link-wrap`
$rowStart = strpos($html, '<div class="nav-link-wrap">');

if ($rowStart === false) {
    fwrite(STDERR, "  ! nav-link-wrap not found\n");
    exit(1);
}

$rowEnd = match_close($html, $rowStart, 'div');
$row = substr($html, $rowStart, $rowEnd - $rowStart);

/* ------------------------------------------------------- the link template */

$linkOpen = strpos($row, '@foreach (cms_menu(\'primary\') as $item)');

if ($linkOpen === false) {
    fwrite(STDERR, "  ! the primary loop is not in the row; run wire_chrome.php first\n");
    exit(1);
}

$linkClose = strpos($row, '@endforeach', $linkOpen);
$loopStartLen = strlen('@foreach (cms_menu(\'primary\') as $item)');
$linkTemplate = substr($row, $linkOpen + $loopStartLen, $linkClose - $linkOpen - $loopStartLen);

/* --------------------------------------------------- the dropdown template */

$dropStart = strpos($row, '<div data-hover="false"');

if ($dropStart === false) {
    fwrite(STDERR, "  ! the dropdown block is not in the row\n");
    exit(1);
}

$dropEnd = match_close($row, $dropStart, 'div');
$dropdown = substr($row, $dropStart, $dropEnd - $dropStart);

// the toggle/panel pairing has to be unique per dropdown on the page
$dropdown = str_replace(
    ['w-dropdown-toggle-0', 'w-dropdown-list-0'],
    ['w-dropdown-toggle-{{ $loop->index }}', 'w-dropdown-list-{{ $loop->index }}'],
    $dropdown,
);

// the label is the item's own now, not a single global setting
$dropdown = str_replace(
    "{{ setting('navbar.dropdown_label', 'Other page') }}",
    '{{ $item->label }}',
    $dropdown,
);

/* ------------------------------------------------------ one column, looped */

$colStart = strpos($dropdown, '<div class="nav-dropdown-column">');

if ($colStart === false) {
    fwrite(STDERR, "  ! no nav-dropdown-column to use as a template\n");
    exit(1);
}

// every column div is a sibling run; the first is the template, all go
$columns = [];
$offset = 0;
while (($s = strpos($dropdown, '<div class="nav-dropdown-column">', $offset)) !== false) {
    $e = match_close($dropdown, $s, 'div');
    $columns[] = [$s, $e];
    $offset = $e;
}

$column = substr($dropdown, $columns[0][0], $columns[0][1] - $columns[0][0]);

/*
 * Rebind the column's inner loop. It reads the old `mega` menu filtered by a
 * literal heading; it becomes the children of whichever column we are drawing.
 * $item is the dropdown itself in the outer loop, so the link variable has to
 * be renamed or the two would collide.
 */
$column = preg_replace(
    '#@foreach \(cms_menu\(\'mega\'\)->where\(\'column_heading\', \'[^\']*\'\) as \$item\)#',
    '@foreach ($links as $child)',
    $column,
    1,
);

if (! str_contains($column, '@foreach ($links as $child)')) {
    fwrite(STDERR, "  ! the column's mega loop did not match\n");
    exit(1);
}

$column = str_replace(['$item->url', '$item->label'], ['$child->url', '$child->label'], $column);

$columnLoop = '@foreach ($item->columns() as $heading => $links)' . $column . '@endforeach';

$dropdown = substr($dropdown, 0, $columns[0][0]) . $columnLoop . substr($dropdown, end($columns)[1]);

/* -------------------------------------------------------------- reassemble */

/*
 * The newline before @endforeach is load-bearing. Blade only recognises a
 * directive when the character before its @ is not a word boundary, so
 * "@endif@endforeach" leaves the second one as literal text and the loop is
 * never closed — the view then dies with "unexpected end of file".
 *
 * A newline is safe here specifically because .nav-link-wrap is display:flex:
 * a whitespace-only text node never becomes a flex item, so it adds no gap
 * between the links the way it would in an inline-block row.
 */
$loop = '@foreach (cms_menu(\'primary\') as $item)'
    . '@if ($item->isDropdown())' . $dropdown . '@else' . $linkTemplate . '@endif' . "\n"
    . '@endforeach';

// from the head of the old link loop through the end of the dropdown block
$row = substr($row, 0, $linkOpen) . $loop . substr($row, $dropEnd);

$html = substr($html, 0, $rowStart) . $row . substr($html, $rowEnd);

/* ------------------------------------------------- the burger overlay */

/*
 * The overlay has to show a dropdown's children, not the dropdown.
 *
 * .nav-menu is display:none below 992px, so on a phone the overlay is the only
 * navigation there is. Drawing only the top level would leave every link inside
 * a panel unreachable, and drawing the panel's own item would offer a link to
 * "#" that does nothing.
 *
 * Only the collection expression changes: the markup keeps using $item, so the
 * exported link design is untouched and no directive ends up adjacent to
 * another.
 */
$overlayNeedle = '<div class="nav-main-menu-wrap">@foreach (cms_menu(\'primary\') as $item)';

if (str_contains($html, $overlayNeedle)) {
    $html = str_replace(
        $overlayNeedle,
        '<div class="nav-main-menu-wrap">@foreach (cms_menu(\'primary\')'
            . '->flatMap(fn ($i) => $i->isDropdown() ? $i->children : [$i]) as $item)',
        $html,
    );
    $overlay = 'flattened';
} else {
    $overlay = 'NOT FOUND';
}

file_put_contents($VIEW, $html);

echo "  burger overlay -> $overlay\n";

printf("  top bar -> %d column template(s) folded into one loop\n", count($columns));
