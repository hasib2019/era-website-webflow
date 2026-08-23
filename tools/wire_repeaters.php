<?php
/**
 * Wires the repeaters whose first card carries an extra layout class.
 *
 * The process strips and the career benefits give item one a `margin-left-none`
 * (or similar) that the rest do not have, so the loop has to reproduce it with
 * $loop->first rather than stamping it onto every item.
 *
 * Run: php tools/wire_repeaters.php
 */

require __DIR__ . '/lib_slice.php';

$VIEWS = dirname(__DIR__) . '/resources/views/site/pages/';

$REPEATERS = [
    ['view' => 'home', 'class' => 'our-process-item', 'scope' => 'home', 'model' => 'ProcessStep'],
    ['view' => 'services', 'class' => 'our-process-item', 'scope' => 'service', 'model' => 'ProcessStep'],
    ['view' => 'why-choose-us', 'class' => 'our-process-item', 'scope' => 'why-choose-us', 'model' => 'ProcessStep'],
];

/** Class tokens the first card has that the second one does not. */
function first_only_classes(string $a, string $b): array
{
    $split = fn (string $c) => preg_split('/\s+/', trim($c), -1, PREG_SPLIT_NO_EMPTY);

    return array_values(array_diff($split($a), $split($b)));
}

function open_tag_class(string $item): string
{
    return preg_match('#^<div[^>]*class="([^"]*)"#', $item, $m) ? $m[1] : '';
}

foreach ($REPEATERS as $config) {
    $file = $VIEWS . $config['view'] . '.blade.php';
    $html = file_get_contents($file);

    $run = [];
    $offset = 0;
    while (preg_match('#<div[^>]*class="(?:[^"]*\s)?' . preg_quote($config['class'], '#') . '(?:\s[^"]*)?"#', $html, $m, PREG_OFFSET_CAPTURE, $offset)) {
        $start = $m[0][1];
        $end = match_close($html, $start, 'div');
        $run[] = [$start, $end];
        $offset = $end;
    }

    if (count($run) < 2) {
        printf("  %-16s %-22s skipped (found %d)\n", $config['view'], $config['class'], count($run));
        continue;
    }

    if (! contiguous($html, $run)) {
        printf("  %-16s %-22s skipped (cards are not adjacent)\n", $config['view'], $config['class']);
        continue;
    }

    $first = substr($html, $run[0][0], $run[0][1] - $run[0][0]);
    $second = substr($html, $run[1][0], $run[1][1] - $run[1][0]);

    $extra = first_only_classes(open_tag_class($first), open_tag_class($second));

    // build the template from the second card, then re-add the first card's
    // extra classes behind a $loop->first check
    $item = $second;

    if ($extra) {
        $item = preg_replace(
            '#(^<div[^>]*class=")([^"]*)(")#',
            '$1$2{{ $loop->first ? \' ' . implode(' ', $extra) . '\' : \'\' }}$3',
            $item,
            1
        );
    }

    $item = bind_field($item, 'our-process-item-title', '{{ $step->title }}');
    $item = bind_counter($item, '{{ $step->number }}');

    $source = '\\App\\Models\\' . $config['model'] . "::forScope('" . $config['scope'] . "')->ordered()->get()";
    $loop = '@foreach (' . $source . ' as $step)' . $item . '@endforeach';

    $html = substr($html, 0, $run[0][0]) . $loop . substr($html, end($run)[1]);
    file_put_contents($file, $html);

    printf("  %-16s %-22s %d cards -> loop%s\n", $config['view'], $config['class'], count($run),
        $extra ? ' (first keeps: ' . implode(' ', $extra) . ')' : '');
}

/** Replaces the contents of the element carrying $class, whatever its tag. */
function bind_field(string $html, string $class, string $expr): string
{
    return preg_replace(
        '#(<(?P<tag>[a-z][a-z0-9]*)[^>]*\sclass="(?:[^"]*\s)?' . preg_quote($class, '#') . '(?:\s[^"]*)?"[^>]*>)(.*?)(</(?P=tag)>)#s',
        '$1' . $expr . '$4',
        $html,
        1
    );
}

/** True when only whitespace sits between consecutive cards. */
function contiguous(string $html, array $run): bool
{
    for ($i = 1; $i < count($run); $i++) {
        $gap = substr($html, $run[$i - 1][1], $run[$i][0] - $run[$i - 1][1]);
        if (trim($gap) !== '') {
            return false;
        }
    }

    return true;
}

/**
 * Binds the number inside a counting wrapper.
 *
 * The digit lives in a bare <div> nested in `.process-counting-wrap`; replacing
 * the wrapper's contents would delete that element along with the text.
 */
function bind_counter(string $html, string $expr): string
{
    return preg_replace(
        '#(<div[^>]*class="(?:[^"]*\s)?process-counting-wrap(?:\s[^"]*)?"[^>]*>\s*<div[^>]*>)(.*?)(</div>)#s',
        '$1' . $expr . '$3',
        $html,
        1
    );
}
