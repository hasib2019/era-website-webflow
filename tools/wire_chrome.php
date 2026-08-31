<?php
/**
 * Binds the site furniture the other passes left behind.
 *
 * Four things, all of them visible on every page and none of them editable:
 *
 *  1. The visible top-bar link row. The navbar carries two navigations — the
 *     overlay menu, which wire_navbar.php already binds to cms_menu('primary'),
 *     and this row of plain links, which it never touched. Editing the Primary
 *     menu therefore changed a menu most visitors never open while the links
 *     they actually click stayed frozen in the markup.
 *  2. The header's own call-to-action button ("BUY TEMPLATE"), label and href.
 *  3. The mega-menu dropdown's toggle label ("Other page").
 *  4. The three heading words above the contact addresses, and the footer's
 *     "Powered by" credit.
 *
 * Every replacement keeps the export's literal as the fallback argument.
 *
 * Idempotent: each step checks for its own output first, so the pass can run
 * on views it has already touched.
 *
 * Run: php tools/build.php   (or php tools/wire_chrome.php [--dry])
 */

define('NEEDS_EXPORT', false);
require __DIR__ . '/config.php';
require __DIR__ . '/lib_slice.php';

$dry = in_array('--dry', $argv, true);
$navbar = SITE_VIEWS . 'partials/navbar.blade.php';
$footer = SITE_VIEWS . 'partials/footer.blade.php';
$contact = SITE_VIEWS . 'pages/contact.blade.php';

$done = [];
$skipped = [];
$failed = [];

/* ------------------------------------------------ 1. the visible link row */

$html = file_get_contents($navbar);

if (str_contains($html, "nav-link-wrap\">@foreach")) {
    $skipped[] = 'top-bar link row';
} else {
    $open = strpos($html, '<div class="nav-link-wrap">');

    if ($open === false) {
        $failed[] = 'nav-link-wrap not found';
    } else {
        $end = match_close($html, $open, 'div');

        // the anchors in this row, in document order
        $anchors = [];
        $i = $open;
        while (($i = strpos($html, '<a ', $i)) !== false && $i < $end) {
            $tagEnd = strpos($html, '>', $i);
            if (str_contains(substr($html, $i, $tagEnd - $i), 'link-wrap')) {
                $anchors[] = [$i, match_close($html, $i, 'a')];
            }
            $i = $tagEnd;
        }

        if (count($anchors) < 2) {
            $failed[] = 'expected several links in nav-link-wrap, found ' . count($anchors);
        } else {
            /*
             * Only replace a contiguous run. The dropdown toggle that follows
             * these links is a div, not an anchor, and swallowing it would take
             * the whole mega menu out of the page.
             */
            $contiguous = true;
            for ($n = 1; $n < count($anchors); $n++) {
                if (trim(substr($html, $anchors[$n - 1][1], $anchors[$n][0] - $anchors[$n - 1][1])) !== '') {
                    $contiguous = false;
                    break;
                }
            }

            if (! $contiguous) {
                $failed[] = 'links in nav-link-wrap are not adjacent';
            } else {
                $first = $anchors[0][0];
                $last = end($anchors)[1];
                $template = substr($html, $first, $anchors[0][1] - $first);

                $item = preg_replace("#nav_active\('[^']*'\)#", 'nav_active($item->url)', $template);
                $item = preg_replace('#href="[^"]*"#', 'href="{{ $item->url }}"', $item);
                $item = preg_replace(
                    '#(<div class="nav-link-text">)[^<]*(</div>)#',
                    '$1{{ $item->label }}$2',
                    $item
                );

                $loop = "@foreach (cms_menu('primary') as \$item)" . $item . '@endforeach';
                $html = substr($html, 0, $first) . $loop . substr($html, $last);
                $done[] = 'top-bar link row -> cms_menu(\'primary\')';
            }
        }
    }
}

/* ------------------------------------------------------ 2. the CTA button */

if (str_contains($html, "navbar.cta_label")) {
    $skipped[] = 'header CTA button';
} else {
    $count = 0;
    $html = preg_replace(
        '#(<div class="text-block">)BUY TEMPLATE(</div>)\s*(<div>)BUY TEMPLATE(</div>)#',
        '$1{{ setting(\'navbar.cta_label\', \'BUY TEMPLATE\') }}$2' . "\n" . '                                                        $3{{ setting(\'navbar.cta_label\', \'BUY TEMPLATE\') }}$4',
        $html,
        1,
        $count
    );
    $count ? $done[] = 'header CTA label' : $failed[] = 'header CTA label';

    // the button's own destination, which pointed at /contact with target=_blank
    $count = 0;
    $html = preg_replace(
        '#href="/contact"(\s+)target="_blank"(\s+)class="menu-button-wrapper#',
        'href="{{ setting(\'navbar.cta_url\', \'/contact\') }}"$1target="_blank"$2class="menu-button-wrapper',
        $html,
        1,
        $count
    );
    $count ? $done[] = 'header CTA link' : $failed[] = 'header CTA link';
}

/* -------------------------------------------- 3. the dropdown toggle label */

if (str_contains($html, 'navbar.dropdown_label')) {
    $skipped[] = 'dropdown toggle label';
} else {
    $count = 0;
    $html = preg_replace(
        '#(<div class="nav-link-text">)Other page(</div>)#',
        '$1{{ setting(\'navbar.dropdown_label\', \'Other page\') }}$2',
        $html,
        -1,
        $count
    );
    $count ? $done[] = "dropdown toggle label ($count)" : $failed[] = 'dropdown toggle label';
}

if (! $dry) {
    file_put_contents($navbar, $html);
}

/* --------------------------------------------- 4. contact headings, footer */

$html = file_get_contents($contact);

if (str_contains($html, 'contact.office_label')) {
    $skipped[] = 'contact headings';
} else {
    foreach ([['office', 'office_label'], ['Sales', 'sales_label'], ['Address', 'address_label']] as [$word, $key]) {
        $count = 0;
        $html = preg_replace(
            '#(<div class="address-info-title">)' . preg_quote($word, '#') . '(</div>)#',
            '$1{{ setting(\'contact.' . $key . '\', \'' . $word . '\') }}$2',
            $html,
            1,
            $count
        );
        $count ? $done[] = "contact heading \"$word\"" : $failed[] = "contact heading \"$word\"";
    }

    if (! $dry) {
        file_put_contents($contact, $html);
    }
}

$html = file_get_contents($footer);

if (str_contains($html, 'footer.company_label')) {
    $skipped[] = 'footer company name';
} else {
    /*
     * Its own setting rather than general.site_name: that one reads
     * "ERA Infotech Ltd." and the markup already prints a full stop after the
     * link, so reusing it would render "Ltd..".
     */
    $count = 0;
    $html = preg_replace(
        '#(target="_blank">\s*)Era Infotech Ltd(</a>)#',
        '$1{{ setting(\'footer.company_label\', \'Era Infotech Ltd\') }}$2',
        $html,
        1,
        $count
    );
    $count ? $done[] = 'footer company name' : $failed[] = 'footer company name';
}

if (str_contains($html, 'footer.credit_prefix')) {
    $skipped[] = 'footer credit';
} else {
    $count = 0;
    $html = preg_replace(
        '#<p>Powered by <a#',
        '<p>{{ setting(\'footer.credit_prefix\', \'Powered by\') }} <a',
        $html,
        1,
        $count
    );
    $count ? $done[] = 'footer "Powered by"' : $failed[] = 'footer "Powered by"';
}

// one write for both footer edits: keeping it inside the credit branch meant a
// company-name change was thrown away whenever the credit was already bound
if (! $dry) {
    file_put_contents($footer, $html);
}

/* ----------------------------------------------------------------- report */

foreach ($done as $d) {
    echo "  bound   $d\n";
}
foreach ($skipped as $s) {
    echo "  already $s\n";
}
foreach ($failed as $f) {
    echo "  ! MISS  $f\n";
}

echo $dry ? "  (dry run, nothing written)\n" : '';
