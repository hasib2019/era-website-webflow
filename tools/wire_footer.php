<?php
/**
 * Points the footer partial at the CMS: settings for the copy and the social
 * links, and the "footer" menu for the PAGES column.
 *
 * Run: php tools/wire_footer.php
 */

require __DIR__ . '/lib_slice.php';

$file = dirname(__DIR__) . '/resources/views/site/partials/footer.blade.php';
$html = file_get_contents($file);
$before = $html;

/** Replaces a text node's contents in place. */
function bind_text(string $html, string $literal, string $expr, int $limit = -1): string
{
    $pattern = '#(?<=>)(\s*)' . preg_quote($literal, '#') . '(\s*)(?=<)#u';

    return preg_replace($pattern, '$1' . $expr . '$2', $html, $limit);
}

$html = bind_text($html, 'Ready to elevate your brand with Fables?',
    "{{ setting('footer.headline', 'Ready to elevate your brand with Fables?') }}");

$html = bind_text($html, 'BUY TEMPLATE',
    "{{ setting('footer.cta_label', 'BUY TEMPLATE') }}");

$html = bind_text($html, 'Thank you! Your submission has been received!',
    "{{ setting('footer.newsletter_success', 'Thank you! Your submission has been received!') }}");

$html = bind_text($html, 'Oops! Something went wrong while submitting the form.',
    "{{ setting('footer.newsletter_error', 'Oops! Something went wrong while submitting the form.') }}");

$html = bind_text($html, 'edoly', "{{ setting('footer.big_text', 'edoly') }}");

$html = bind_text($html, 'PAGES',
    "{{ cms_menu('footer')->first()?->column_heading ?? 'PAGES' }}");

// the template's own marketplace link becomes the editable footer CTA
$html = str_replace('href="/contact" target="_blank"',
    "href=\"{{ setting('footer.cta_url', '/contact') }}\" target=\"_blank\"", $html);

// the export shipped this with a stray space, which made the link dead
$html = str_replace('https:// erainfotechbd.com/', "{{ setting('general.website_url', 'https://erainfotechbd.com/') }}", $html);

$socials = [
    'https://www.facebook.com/' => 'facebook',
    'https://twitter.com/' => 'twitter',
    'https://www.instagram.com/' => 'instagram',
    'https://dribbble.com/' => 'dribbble',
    'https://www.behance.net/' => 'behance',
];

foreach ($socials as $url => $key) {
    $html = str_replace(
        'href="' . $url . '"',
        'href="{{ setting(\'social.' . $key . '\', \'' . $url . '\') }}"',
        $html
    );
}

// ---------------------------------------------------------------- link columns
// The footer holds three headed groups (PAGES / COMPANY / UTILITY); the whole
// block becomes one loop over the menu grouped by its column heading.
$colOpen = strpos($html, '<div class="footer-menu-column">');
if ($colOpen === false) {
    fwrite(STDERR, "footer-menu-column not found\n");
    exit(1);
}

$colEnd = match_close($html, $colOpen, 'div');
$column = substr($html, $colOpen, $colEnd - $colOpen);

$itemOpen = strpos($column, '<div class="footer-menu-item">');
$itemEnd = match_close($column, $itemOpen, 'div');
$itemTemplate = substr($column, $itemOpen, $itemEnd - $itemOpen);

$wrapOpen = strpos($itemTemplate, '<div class="footer-menu-link-wrap">');
$wrapEnd = match_close($itemTemplate, $wrapOpen, 'div');
$wrap = substr($itemTemplate, $wrapOpen, $wrapEnd - $wrapOpen);

$aStart = strpos($wrap, '<a ');
$aEnd = match_close($wrap, $aStart, 'a');
$anchor = substr($wrap, $aStart, $aEnd - $aStart);

$anchor = preg_replace('#nav_active\(\'[^\']*\'\)#', 'nav_active($item->url)', $anchor);
$anchor = preg_replace('#href="/[^"]*"#', 'href="{{ $item->url }}"', $anchor);
$anchor = preg_replace('#(<div class="nav-link-text">)[^<]*(</div>)#', '$1{{ $item->label }}$2', $anchor);

$newWrap = '<div class="footer-menu-link-wrap">@foreach ($items as $item)' . $anchor . '@endforeach</div>';
$newItem = substr($itemTemplate, 0, $wrapOpen) . $newWrap . substr($itemTemplate, $wrapEnd);
$newItem = preg_replace('#(<div class="footer-menu-title">).*?(</div>)#s', '$1{{ $heading }}$2', $newItem);

$loop = "@foreach (cms_menu('footer')->groupBy('column_heading') as \$heading => \$items)"
    . $newItem
    . '@endforeach';

// splice only the run of items, so whatever closes the list and the column
// after them survives untouched
$lastItemEnd = $itemEnd;
$scan = $itemEnd;
while (($next = strpos($column, '<div class="footer-menu-item">', $scan)) !== false) {
    $lastItemEnd = match_close($column, $next, 'div');
    $scan = $lastItemEnd;
}

$newColumn = substr($column, 0, $itemOpen) . $loop . substr($column, $lastItemEnd);
$html = substr($html, 0, $colOpen) . $newColumn . substr($html, $colEnd);

file_put_contents($file, $html);

printf("footer wired (%d -> %d bytes)\n", strlen($before), strlen($html));
