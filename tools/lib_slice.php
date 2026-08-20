<?php
/**
 * Byte-accurate slicing helpers for the Webflow export.
 *
 * The exported markup is what the browser must receive verbatim, so every
 * helper here works on raw strings and offsets rather than a DOM round-trip
 * (DOMDocument reformats attributes and self-closing tags, which would show up
 * as visual drift once Webflow's IX2 runtime reads the markup back).
 */

/** Offset just past the close tag matching the element that starts at $start. */
function match_close(string $s, int $start, string $tag): int
{
    $len = strlen($s);
    $open = '<' . $tag;
    $close = '</' . $tag;
    $depth = 0;
    $i = $start;

    while ($i < $len) {
        $nextOpen = stripos($s, $open, $i);
        $nextClose = stripos($s, $close, $i);

        if ($nextClose === false) {
            throw new RuntimeException("unclosed <$tag> from offset $start");
        }

        if ($nextOpen !== false && $nextOpen < $nextClose) {
            $after = $s[$nextOpen + strlen($open)] ?? '';
            if ($after === '>' || $after === '/' || ctype_space($after)) {
                $depth++;
            }
            $i = $nextOpen + strlen($open);
            continue;
        }

        $depth--;
        $gt = strpos($s, '>', $nextClose);
        $i = $gt === false ? $nextClose + strlen($close) : $gt + 1;
        if ($depth === 0) {
            return $i;
        }
    }

    throw new RuntimeException("unbalanced <$tag> from offset $start");
}

/** [start, end] of the first element whose open tag matches $needle. */
function find_block(string $s, string $needle, string $tag): array
{
    $start = strpos($s, $needle);
    if ($start === false) {
        return [-1, -1];
    }
    return [$start, match_close($s, $start, $tag)];
}

/** Splits one exported page into its structural pieces. */
function slice_page(string $raw): array
{
    $out = [];

    $htmlOpenEnd = strpos($raw, '>', strpos($raw, '<html'));
    $out['doctype'] = substr($raw, 0, strpos($raw, '<html'));
    $out['html_tag'] = substr($raw, strpos($raw, '<html'), $htmlOpenEnd - strpos($raw, '<html') + 1);

    $headStart = strpos($raw, '<head>');
    $headEnd = strpos($raw, '</head>') + strlen('</head>');
    $out['head'] = substr($raw, $headStart, $headEnd - $headStart);

    $bodyOpen = strpos($raw, '<body');
    $bodyOpenEnd = strpos($raw, '>', $bodyOpen) + 1;
    $out['body_tag'] = substr($raw, $bodyOpen, $bodyOpenEnd - $bodyOpen);

    $bodyClose = strrpos($raw, '</body>');
    $inner = substr($raw, $bodyOpenEnd, $bodyClose - $bodyOpenEnd);
    $out['body_inner'] = $inner;

    // cursor-wrapper is optional and always the first child when present
    [$cs, $ce] = find_block($inner, '<div class="cursor-wrapper">', 'div');
    $out['cursor'] = $cs >= 0 ? substr($inner, $cs, $ce - $cs) : '';

    $navNeedle = '<div data-w-id="98cce219-106e-0917-6727-fde305ae5965"';
    [$ns, $ne] = find_block($inner, $navNeedle, 'div');
    if ($ns < 0) {
        throw new RuntimeException('navbar not found');
    }
    $out['navbar'] = substr($inner, $ns, $ne - $ns);

    [$fs, $fe] = find_block($inner, '<footer class="footer">', 'footer');
    if ($fs < 0) {
        throw new RuntimeException('footer not found');
    }
    $out['footer'] = substr($inner, $fs, $fe - $fs);

    $out['content'] = substr($inner, $ne, $fs - $ne);
    $out['scripts'] = substr($inner, $fe);
    $out['pre_nav'] = substr($inner, 0, $ns);

    return $out;
}
