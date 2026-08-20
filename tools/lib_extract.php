<?php
/**
 * Helpers for lifting the template's shipped content out of the HTML export.
 *
 * The seeded database has to reproduce the pages byte-for-byte, so values are
 * read straight from the markup rather than retyped.
 */

const SRC_DIR = 'd:/ERA/Era-WEBSITE-Templete/era-website/Pages/';

function load_doc(string $page): DOMXPath
{
    libxml_use_internal_errors(true);
    $d = new DOMDocument();
    $d->loadHTML('<?xml encoding="utf-8" ?>' . file_get_contents(SRC_DIR . $page));
    libxml_clear_errors();

    return new DOMXPath($d);
}

/** XPath predicate matching one class name among many. */
function has_class(string $class): string
{
    return "contains(concat(' ', normalize-space(@class), ' '), ' $class ')";
}

function node_text(?DOMNode $n): string
{
    if (! $n) {
        return '';
    }

    return trim(preg_replace('/\s+/', ' ', $n->textContent));
}

function first_text(DOMXPath $x, string $query, ?DOMNode $ctx = null): string
{
    $r = $ctx ? $x->query($query, $ctx) : $x->query($query);

    return $r && $r->length ? node_text($r->item(0)) : '';
}

function first_attr(DOMXPath $x, string $query, string $attr, ?DOMNode $ctx = null): string
{
    $r = $ctx ? $x->query($query, $ctx) : $x->query($query);

    return $r && $r->length ? trim($r->item(0)->getAttribute($attr)) : '';
}

/** Inner HTML of the first match, with the Webflow asset urls left intact. */
function first_html(DOMXPath $x, string $query, ?DOMNode $ctx = null): string
{
    $r = $ctx ? $x->query($query, $ctx) : $x->query($query);
    if (! $r || ! $r->length) {
        return '';
    }

    $node = $r->item(0);
    $html = '';
    foreach ($node->childNodes as $child) {
        $html .= $node->ownerDocument->saveHTML($child);
    }

    return trim(preg_replace('/\s+/', ' ', $html));
}

/** CDN url -> the filename the media library registered it under. */
function media_key(string $url): string
{
    if ($url === '') {
        return '';
    }

    $name = basename(parse_url($url, PHP_URL_PATH) ?? $url);
    $name = str_replace(['%20', '(', ')', ' '], '', $name);
    // downscale variants resolve to their parent asset
    $name = preg_replace('/-p-\d+(\.[A-Za-z0-9]+)$/', '$1', $name);
    // one asset shipped as "...-1%20(1).webp"; it was renamed on disk
    $name = str_replace('case-study-image-11', 'case-study-image-1', $name);

    return $name;
}

function slugify(string $value): string
{
    $slug = strtolower(trim($value));
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);

    return trim($slug, '-');
}

/**
 * Reads the value out of a Webflow counting animation.
 *
 * Each digit is a column of 0-9 that scrolls into place: `align-top` columns
 * park on their first character, `align-bottom` columns on their last, and a
 * column with neither class is a literal suffix such as "+" or "M+".
 *
 * @return array{0: string, 1: string} [value, suffix]
 */
function decode_counter(DOMXPath $x, DOMNode $item): array
{
    $value = '';
    $suffix = '';

    foreach ($x->query('.//div[' . has_class('couting-column') . ']', $item) as $col) {
        $class = $col->getAttribute('class');
        $chars = preg_split('/\s+/', node_text($col), -1, PREG_SPLIT_NO_EMPTY);

        if (! $chars) {
            continue;
        }

        if (str_contains($class, 'align-top')) {
            $value .= $chars[0];
        } elseif (str_contains($class, 'align-bottom')) {
            $value .= end($chars);
        } else {
            $suffix .= implode('', $chars);
        }
    }

    return [$value, $suffix];
}
