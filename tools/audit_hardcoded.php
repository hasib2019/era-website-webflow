<?php
/**
 * Reports visible text and link targets the CMS does not control.
 *
 * Strips every Blade expression and directive from a generated view, then looks
 * at what visible text is left. Whatever survives is a literal nobody can edit
 * from the dashboard.
 *
 * Text inside a @foreach is reported separately: those blocks are the
 * unconverted Webflow collection lists, a different problem with a different
 * fix (a wiring pass, not a binding).
 *
 * Run: php tools/audit_hardcoded.php [--links] [--page=home]
 */

define('NEEDS_EXPORT', false);
require __DIR__ . '/config.php';

$only = null;
foreach ($argv as $arg) {
    if (str_starts_with($arg, '--page=')) {
        $only = substr($arg, 7);
    }
}
$withLinks = in_array('--links', $argv, true);

/** Text that is markup furniture rather than copy. */
function isNoise(string $t): bool
{
    $t = trim($t);

    if ($t === '' || mb_strlen($t) < 2) {
        return true;
    }
    if (! preg_match('/\p{L}{2,}/u', $t)) {
        return true;
    }
    // leftovers of stripped directives, and script/style bodies
    foreach (['@', '{', '}', 'function ', 'var ', 'window.', 'w-dyn', 'px', '__INDEX__'] as $needle) {
        if (str_contains($t, $needle)) {
            return true;
        }
    }

    return false;
}

/** Removes Blade so only the template's own literals remain. */
function stripBlade(string $html): string
{
    $html = preg_replace('/\{\{.*?\}\}/s', '~~', $html);
    $html = preg_replace('/\{!!.*?!!\}/s', '~~', $html);
    $html = preg_replace('/\{\{--.*?--\}\}/s', '', $html);
    $html = preg_replace('/<script\b[^>]*>.*?<\/script>/is', '', $html);
    $html = preg_replace('/<style\b[^>]*>.*?<\/style>/is', '', $html);

    return $html;
}

$files = $only
    ? [SITE_VIEWS . "pages/$only.blade.php"]
    : array_merge(glob(SITE_VIEWS . 'pages/*.blade.php'), glob(SITE_VIEWS . 'partials/*.blade.php'));

$totalText = 0;
$totalLoop = 0;
$totalLinks = 0;

foreach ($files as $file) {
    if (! is_file($file)) {
        continue;
    }

    $name = basename(dirname($file)) . '/' . basename($file, '.blade.php');
    $raw = file_get_contents($file);
    $lines = explode("\n", $raw);

    // which lines sit inside a @foreach / @forelse block
    $inLoop = [];
    $depth = 0;
    foreach ($lines as $i => $line) {
        $opens = preg_match_all('/@(foreach|forelse)\b/', $line);
        $closes = preg_match_all('/@(endforeach|endforelse)\b/', $line);
        $depth += $opens;
        $inLoop[$i + 1] = $depth > 0;
        $depth -= $closes;
        $depth = max(0, $depth);
    }

    $stripped = stripBlade($raw);
    $strippedLines = explode("\n", $stripped);

    $free = [];
    $loop = [];
    $links = [];

    foreach ($strippedLines as $i => $line) {
        $no = $i + 1;

        if (preg_match_all('/>([^<>]+)</', $line, $m)) {
            foreach ($m[1] as $text) {
                $text = trim(preg_replace('/\s+/', ' ', html_entity_decode($text)));
                if (isNoise($text)) {
                    continue;
                }
                $entry = sprintf('%-5d %s', $no, mb_substr($text, 0, 72));
                if ($inLoop[$no] ?? false) {
                    $loop[] = $entry;
                } else {
                    $free[] = $entry;
                }
            }
        }

        if ($withLinks && preg_match_all('/href="([^"{}]+)"/', $line, $m)) {
            foreach ($m[1] as $href) {
                if ($href === '#' || str_contains($href, '~~')) {
                    continue;
                }
                $links[] = sprintf('%-5d %s', $no, $href);
            }
        }
    }

    if (! $free && ! $loop && ! $links) {
        continue;
    }

    printf("\n=== %s ===\n", $name);

    if ($free) {
        printf("  UNBOUND TEXT (%d)\n", count($free));
        foreach ($free as $f) {
            echo "    $f\n";
        }
        $totalText += count($free);
    }

    if ($loop) {
        printf("  inside a loop, from the record (%d) — not a problem\n", count($loop));
        $totalLoop += count($loop);
    }

    if ($links) {
        printf("  HARDCODED HREFS (%d)\n", count($links));
        foreach (array_unique($links) as $l) {
            echo "    $l\n";
        }
        $totalLinks += count($links);
    }
}

printf("\n----------------------------------------\n");
printf("unbound text nodes: %d\n", $totalText);
printf("loop-sourced text:  %d\n", $totalLoop);
if ($withLinks) {
    printf("hardcoded hrefs:    %d\n", $totalLinks);
}
