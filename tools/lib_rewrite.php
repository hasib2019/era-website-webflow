<?php
/**
 * URL / markup rewriting applied to the Webflow export on its way into Blade.
 *
 * Everything here is a deliberate deviation from the source bytes; anything not
 * listed is copied through untouched so the rendered DOM stays what Webflow's
 * IX2 runtime and stylesheet expect.
 */

/**
 * page file => site path.
 *
 * Lives in config/link_map.php so the app can apply the same map to links an
 * editor stores in a page section -- see App\Support\Content::url().
 */
function link_map(): array
{
    return require dirname(__DIR__) . '/config/link_map.php';
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

    // local files copied into public/site. The lookbehind also allows ", " so
    // a later candidate in a srcset list -- "a.jpg 500w, ../images/b.jpg 741w"
    // -- gets rewritten too, not just the one right after the opening quote.
    $html = preg_replace('#(?<=["\'(]|, )(?:\.\./)?css/#', '/site/css/', $html);
    $html = preg_replace('#(?<=["\'(]|, )(?:\.\./)?js/#', '/site/js/', $html);
    $html = preg_replace('#(?<=["\'(]|, )(?:\.\./)?images/#', '/site/images/', $html);

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
        'https://era.webflow.io/service/search-engine-optimization',
        'https://era.webflow.io/post/navigating-search-algorithms-for-regional-impact',
        'https://era.webflow.io/job/brand-expert',
        'https://era.webflow.io/case-study/event-planning-and-management',
    ], [
        '/services/search-engine-optimization',
        '/blog/navigating-search-algorithms-for-regional-impact',
        '/career/brand-expert',
        '/case-studies/event-planning-and-management',
    ], $html);

    // template marketplace links that shipped with the theme
    $html = str_replace([
        'https://www.flowfye.com/services#pricing',
        'https://webflow.com/templates/html/era-agency-website-template',
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

/*
 * settle_ix2() used to live here.
 *
 * It rewrote the export's frozen entry states — translate3d(0, 60px, 0) and
 * opacity: 0 — to their settled values, as a guard against the interactions
 * runtime failing to boot. Measuring the running page showed the guard was
 * pointless and harmful: IX2 re-applies its own initial state on load, so the
 * rewrite bought nothing, and its opacity pattern only matched when the
 * declarations appeared in one particular order. Elements written the other way
 * round kept opacity: 0 while losing their offset, which broke the reveal.
 *
 * The inline styles are now copied through exactly. The no-JS case is covered
 * by a <noscript> rule in resources/views/site/partials/head.blade.php.
 */


/**
 * Drops an unstyled wrapper the export left on the first testimonial only.
 *
 * `.testimonial-inside-image-parent` has no CSS rule, and neither does the bare
 * <div> Webflow nested inside it for slide one and nowhere else. Removing it
 * makes every slide the same shape so the block can be looped, and changes
 * nothing on screen.
 */
function drop_stray_testimonial_wrapper(string $html): string
{
    $needle = '<div class="testimonial-inside-image-parent">';
    $offset = 0;

    while (($start = strpos($html, $needle, $offset)) !== false) {
        $end = match_close($html, $start, 'div');
        $block = substr($html, $start, $end - $start);

        // only when the parent's single child is a class-less <div>
        if (preg_match('#^(' . preg_quote($needle, '#') . '\s*)<div>(.*)</div>(\s*</div>)$#s', $block, $m)) {
            $block = $m[1] . $m[2] . $m[3];
            $html = substr($html, 0, $start) . $block . substr($html, $end);
            $end = $start + strlen($block);
        }

        $offset = $end;
    }

    return $html;
}

/**
 * Replaces the template's "Powered by Webflow" credit with ERA's own.
 *
 * This is a content decision, not a conversion detail, so it is applied to the
 * export and to verify.php's baseline alike — that keeps the fidelity check
 * meaningful instead of permanently two text nodes out. wire_footer.php then
 * binds both halves to settings so the wording stays editable.
 */
function rebrand_footer_credit(string $html): string
{
    return str_replace(
        ['href="http://webflow.com/"', '>Webflow.</a>'],
        ['href="https://erainfotechbd.com/"', '>Era Infotech Ltd.</a>'],
        $html
    );
}
