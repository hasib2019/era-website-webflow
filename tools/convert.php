<?php
/**
 * Turns the static Webflow export into the Blade views the Laravel app serves.
 *
 * The shared chrome (head, navbar, cart, footer, scripts, cursor) is lifted once
 * from the cleanest page that carries it; everything between navbar and footer is
 * copied per page byte-for-byte apart from the rewrites in lib_rewrite.php.
 *
 * Run: php tools/convert.php
 */

require __DIR__ . '/lib_slice.php';
require __DIR__ . '/lib_rewrite.php';

require __DIR__ . '/config.php';

$SRC = EXPORT_PAGES;
$APP = dirname(__DIR__);
$VIEWS = $APP . '/resources/views/site';

$assetMap = load_asset_map(__DIR__ . '/asset_map.txt');

/** page file => [view name, <title>, has cursor block, has cart in nav] */
$PAGES = [
    'home.html' => ['home', 'Home'],
    'about.html' => ['about', 'About Us'],
    'service.html' => ['services', 'Services'],
    'services-details.html' => ['service-details', 'Services Details'],
    'casestudy.html' => ['case-studies', 'Case Studies'],
    'case-study-details.html' => ['case-study-details', 'Case Study Details'],
    'blog.html' => ['blog', 'Blog'],
    'blog-details.html' => ['blog-details', 'Blog Details'],
    'career.html' => ['career', 'Career'],
    'career-details.html' => ['career-details', 'Brand Expert'],
    'contact-us.html' => ['contact', 'Contact Us'],
    'faq.html' => ['faq', 'FAQ'],
    'why-choose-us.html' => ['why-choose-us', 'Why Choose Us'],
    'changelog.html' => ['changelog', 'Change Log'],
    'style-guide.html' => ['style-guide', 'Style Guide'],
    '404.html' => ['errors-404', '404'],
];

/** Marks anchors that point at a local path so Blade can flag the current page. */
function inject_active_state(string $html): string
{
    return preg_replace_callback('/<a\b([^>]*)>/s', function (array $m): string {
        $attrs = $m[1];
        if (!preg_match('/href="(\/[^"]*)"/', $attrs, $h)) {
            return $m[0];
        }
        $path = $h[1];
        if ($path === '#' || str_contains($path, '{{')) {
            return $m[0];
        }

        $attrs = preg_replace('/\s*aria-current="page"/', '', $attrs);
        $attrs = preg_replace('/(\sclass="[^"]*?)\s+w--current(\s|")/', '$1$2', $attrs);

        $cond = "nav_active('" . addslashes($path) . "')";
        $attrs = preg_replace(
            '/(\sclass=")([^"]*)(")/',
            '$1$2{{ ' . $cond . " ? ' w--current' : '' }}$3",
            $attrs,
            1
        );
        $attrs = ' {!! ' . $cond . ' ? \'aria-current="page"\' : \'\' !!}' . $attrs;

        return '<a' . $attrs . '>';
    }, $html);
}

function put(string $path, string $body): void
{
    @mkdir(dirname($path), 0777, true);
    file_put_contents($path, $body);
    echo '  wrote ' . str_replace(dirname(__DIR__) . '/', '', strtr($path, DIRECTORY_SEPARATOR, '/'))
        . ' (' . number_format(strlen($body)) . " b)\n";
}

// ---------------------------------------------------------------- shared chrome

$slices = [];
foreach ($PAGES as $file => $_) {
    $slices[$file] = slice_page(file_get_contents($SRC . $file));
}

$clean = fn(string $h): string => inject_active_state(
    rewrite_links(rewrite_assets(settle_ix2(unfreeze(drop_stray_testimonial_wrapper(unwrap_dropped_links($h)))), $assetMap))
);

echo "shared partials\n";

// blog.html sits in the 12-page group whose navbar is identical once active
// state is normalised away, and it carries the commerce cart 404 omits.
$navbar = $clean($slices['blog.html']['navbar']);
[$cartStart, $cartEnd] = find_block($navbar, '<div data-open-product=""', 'div');
if ($cartStart < 0) {
    fwrite(STDERR, "FATAL: cart block not found in navbar\n");
    exit(1);
}
$cart = substr($navbar, $cartStart, $cartEnd - $cartStart);
$navbarShell = substr($navbar, 0, $cartStart)
    . "@if (\$showCart ?? true)\n@include('site.partials.cart')\n@endif"
    . substr($navbar, $cartEnd);

put($VIEWS . '/partials/navbar.blade.php', $navbarShell . "\n");
put($VIEWS . '/partials/cart.blade.php', $cart . "\n");

// 404.html carries the only footer the export saved in a settled, un-frozen state
put($VIEWS . '/partials/footer.blade.php', $clean($slices['404.html']['footer']) . "\n");

$cursor = $clean($slices['home.html']['cursor']);
// the exported transform is wherever the pointer happened to be at save time,
// and the wrapper class differs per page, so both become parameters
$cursor = preg_replace('/translate3d\([^)]*\)/', 'translate3d(0px, 0px, 0px)', $cursor, 1);
$cursor = str_replace('class="cursor load-on-scroll"', 'class="{{ $cursorClass ?? \'cursor\' }}"', $cursor);
put($VIEWS . '/partials/cursor.blade.php', $cursor . "\n");

put($VIEWS . '/partials/scripts.blade.php', trim($clean($slices['home.html']['scripts'])) . "\n");

// ---------------------------------------------------------------- page views

echo "page views\n";
foreach ($PAGES as $file => [$view, $title]) {
    $s = $slices[$file];
    $content = $clean($s['content']);

    // three pages keep the cursor inside the content flow instead of above the
    // navbar; there it is copied through with the rest of the markup.
    $hasCursor = str_contains($s['pre_nav'], 'cursor-wrapper');
    $showCart = !str_contains($s['navbar'], '<div data-open-product=""') ? 'false' : 'true';

    $blade = "@extends('site.layouts.app')\n\n"
        . "@section('title', '" . addslashes($title) . "')\n";
    if ($hasCursor) {
        $cursorClass = str_contains($s['cursor'], 'class="cursor load-on-scroll"') ? 'cursor load-on-scroll' : 'cursor';
        $blade .= "@section('cursor')\n@include('site.partials.cursor', ['cursorClass' => '{$cursorClass}'])\n@endsection\n";
    }
    if ($showCart === 'false') {
        $blade .= "@php(\$showCart = false)\n";
    }
    $blade .= "\n@section('content')\n" . trim($content) . "\n@endsection\n";

    put($VIEWS . '/pages/' . $view . '.blade.php', $blade);
}

echo "\nunconverted markers left in output:\n";
foreach (glob($VIEWS . '/{pages,partials}/*.blade.php', GLOB_BRACE) as $f) {
    $b = file_get_contents($f);
    $hits = [];
    foreach ([
        'webflow.io' => 'edoly.webflow.io',
        'cdn.website-files' => 'cdn.prod.website-files.com',
        '.html link' => '.html"',
        'turnstile' => 'turnstile',
        'wf-page-id' => 'data-wf-page-id',
    ] as $label => $needle) {
        $n = substr_count($b, $needle);
        if ($n) $hits[] = "$label=$n";
    }
    if ($hits) echo '  ' . basename($f) . ': ' . implode(' ', $hits) . "\n";
}
echo "done\n";

// Laravel resolves the not-found page from resources/views/errors/404.blade.php
@mkdir($APP . '/resources/views/errors', 0777, true);
rename($VIEWS . '/pages/errors-404.blade.php', $APP . '/resources/views/errors/404.blade.php');
echo "  moved errors-404 -> resources/views/errors/404.blade.php\n";
