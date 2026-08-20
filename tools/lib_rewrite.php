<?php
/**
 * URL / markup rewriting applied to the Webflow export on its way into Blade.
 *
 * Everything here is a deliberate deviation from the source bytes; anything not
 * listed is copied through untouched so the rendered DOM stays what Webflow's
 * IX2 runtime and stylesheet expect.
 */

/** page file => site path. Detail pages keep the slugs the export already linked to. */
function link_map(): array
{
    return [
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
        '404.html' => '/404',
    ];
}

/** Pages the project drops; their anchors are unwrapped rather than left dangling. */
function dropped_pages(): array
{
    return ['pricing.html', 'terms&conditions.html', 'terms&amp;conditions.html'];
}

function load_asset_map(string $file): array
{
    $map = [];
    foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        [$cdn, $local] = explode('|', $line, 2);
        $map[$cdn] = $local;
    }
    // longest first so no URL is rewritten by a prefix of another
    uksort($map, fn($a, $b) => strlen($b) <=> strlen($a));
    return $map;
}

function rewrite_assets(string $html, array $assetMap): string
{
    $html = strtr($html, $assetMap);

    // Webflow inlines whole templates as percent-encoded blobs, so the same
    // asset urls appear a second time in escaped form.
    $encoded = [];
    foreach ($assetMap as $cdn => $local) {
        $encoded[str_replace([':', '/'], ['%3A', '%2F'], $cdn)] = str_replace('/', '%2F', $local);
    }
    $html = strtr($html, $encoded);

    // local files copied into public/site
    $html = preg_replace('#(?<=["\'(])(?:\.\./)?css/#', '/site/css/', $html);
    $html = preg_replace('#(?<=["\'(])(?:\.\./)?js/#', '/site/js/', $html);
    $html = preg_replace('#(?<=["\'(])(?:\.\./)?images/#', '/site/images/', $html);

    return $html;
}

function rewrite_links(string $html): string
{
    $map = link_map();

    // ../Pages/x.html and Pages/x.html and bare x.html
    foreach ($map as $file => $path) {
        $enc = str_replace('&', '&amp;', $file);
        foreach ([$file, $enc] as $needle) {
            $html = str_replace(
                ['href="../Pages/' . $needle . '"', 'href="Pages/' . $needle . '"', 'href="' . $needle . '"'],
                'href="' . $path . '"',
                $html
            );
        }
    }

    // the template author's own webflow.io demo, which carried the real slugs
    $html = str_replace([
        'https://edoly.webflow.io/service/search-engine-optimization',
        'https://edoly.webflow.io/post/navigating-search-algorithms-for-regional-impact',
        'https://edoly.webflow.io/job/brand-expert',
        'https://edoly.webflow.io/case-study/event-planning-and-management',
    ], [
        '/services/search-engine-optimization',
        '/blog/navigating-search-algorithms-for-regional-impact',
        '/career/brand-expert',
        '/case-studies/event-planning-and-management',
    ], $html);

    // template marketplace links that shipped with the theme
    $html = str_replace([
        'https://www.flowfye.com/services#pricing',
        'https://webflow.com/templates/html/edoly-agency-website-template',
        'https://welifye.webflow.io/contact-us#w-tabs-0-data-w-pane-0',
        'https://welifye.webflow.io/contact-us#w-tabs-0-data-w-pane-1',
    ], ['/contact', '/contact', '#', '#'], $html);

    return $html;
}

/**
 * Unwraps anchors that pointed at pages the project drops: the inner markup
 * (and therefore the layout) survives, only the dead link is removed.
 */
function unwrap_dropped_links(string $html): string
{
    foreach (dropped_pages() as $page) {
        foreach (['href="' . $page . '"', 'href="../Pages/' . $page . '"', 'href="Pages/' . $page . '"'] as $needle) {
            while (($hit = strpos($html, $needle)) !== false) {
                $open = strrpos(substr($html, 0, $hit), '<a');
                if ($open === false) {
                    $html = str_replace($needle, 'href="#"', $html);
                    continue 2;
                }
                $end = match_close($html, $open, 'a');
                $html = substr($html, 0, $open) . substr($html, $end);
            }
        }
    }
    return $html;
}

/**
 * Clears state Webflow froze into the export at save time.
 *
 * The export captured mid-flight IX2 transforms and a mid-submit form, so 14 of
 * the 16 pages ship a permanently disabled newsletter button and blocks stuck at
 * opacity 0. IX2 re-drives the transforms on load; the form state it does not.
 */
function unfreeze(string $html): string
{
    $html = preg_replace('/\s*data-wf-page-id="[^"]*"/', '', $html);
    $html = preg_replace('/\s*data-turnstile-sitekey="[^"]*"/', '', $html);
    $html = preg_replace('/\s+class="([^"]*?)\s*w-form-loading\s*([^"]*)"/', ' class="$1$2"', $html);
    $html = preg_replace('/(<input[^>]*type="submit"[^>]*?)\s+disabled=""/', '$1', $html);
    // the token sits in a bare div-in-div the rest of the pages never had
    $html = preg_replace('#<div>\s*<div>\s*<input[^>]*name="cf-turnstile-response"[^>]*>\s*</div>\s*</div>#', '', $html);
    $html = preg_replace('/<input[^>]*name="cf-turnstile-response"[^>]*>/', '', $html);
    $html = str_replace('<script src="https://challenges.cloudflare.com/turnstile/v0/api.js"></script>', '', $html);
    return $html;
}

/** Settles IX2's frozen entry state so content is visible if the runtime never boots. */
function settle_ix2(string $html): string
{
    $html = preg_replace('/translate3d\(0px, 60px, 0px\)/', 'translate3d(0px, 0px, 0px)', $html);
    $html = preg_replace('/(transform-style: preserve-3d;)\s*opacity: 0;/', '$1 opacity: 1;', $html);
    return $html;
}
