<?php
/**
 * Wires the four about-page bands added for ERA: core values, partners,
 * certifications & membership, and awards & achievements.
 *
 * Each band is a collection loop plus an editable caption and heading. The
 * headings go through cms() against the `about` page sections that
 * AboutSectionsSeeder registers; the rows come from the collections.
 *
 * Why these live here rather than in the existing passes:
 *
 *  - core values reuse `our-process-item`, but wire_repeaters.php maps that
 *    class to ProcessStep::forScope() and the about page is not one of its
 *    scopes;
 *  - partners and certifications reuse the client logo markup, and
 *    wire_clients.php deliberately skips their `static-logo-row` rows so the
 *    marquee's own row numbering stays intact;
 *  - awards use `award-collection-item` rather than `job-collection-item`
 *    precisely so wire_collections.php does not fold them and the real jobs
 *    list into a single run — it replaces first match through last with no
 *    contiguity check, which would swallow the testimonials band between them.
 *
 * Every band is wrapped in a count guard, so a collection nobody has filled in
 * yet hides its whole section instead of leaving a heading over empty space.
 *
 * Run: php tools/wire_about.php   (registered in tools/build.php)
 */

require __DIR__ . '/lib_slice.php';

$VIEW = dirname(__DIR__) . '/resources/views/site/pages/about.blade.php';

if (! is_file($VIEW)) {
    fwrite(STDERR, "  ! about.blade.php missing; run convert.php first\n");
    exit(1);
}

$html = file_get_contents($VIEW);

/** Replaces the contents of the first element carrying $class, whatever its tag. */
function bind_class(string $html, string $class, string $expr): string
{
    return preg_replace(
        '#(<(?P<tag>[a-z][a-z0-9]*)[^>]*\sclass="(?:[^"]*\s)?' . preg_quote($class, '#') . '(?:\s[^"]*)?"[^>]*>)(.*?)(</(?P=tag)>)#s',
        '$1' . $expr . '$4',
        $html,
        1
    );
}

/** [start, end) of the <section> whose opening run contains $marker. */
function section_bounds(string $html, string $marker): array
{
    $at = strpos($html, $marker);
    if ($at === false) {
        return [-1, -1];
    }

    $start = strrpos(substr($html, 0, $at), '<section');
    if ($start === false) {
        return [-1, -1];
    }

    return [$start, match_close($html, $start, 'section')];
}

/**
 * Rewrites one band in place.
 *
 * $marker    unique copy inside the section, used to find it
 * $itemClass the element that repeats
 * $build     receives one card's markup, returns the bound version
 * $source    the Blade expression the loop iterates
 * $as        the loop variable name
 */
function wire_band(string $html, array $band): array
{
    [$start, $end] = section_bounds($html, $band['marker']);

    if ($start < 0) {
        return [$html, sprintf('  %-22s not found', $band['label'])];
    }

    $section = substr($html, $start, $end - $start);

    if (str_contains($section, '@foreach')) {
        return [$html, sprintf('  %-22s already wired', $band['label'])];
    }

    // caption and heading become editable page-section fields
    foreach ($band['text'] as $class => [$path, $literal]) {
        $section = bind_class($section, $class, '{{ ' . sprintf("cms('%s', %s)", $path, var_export($literal, true)) . ' }}');
    }

    if ($band['heading'] ?? null) {
        [$path, $literal] = $band['heading'];
        $section = preg_replace(
            '#(<h2[^>]*>)(.*?)(</h2>)#s',
            '$1{{ ' . sprintf("cms('%s', %s)", $path, var_export($literal, true)) . ' }}$3',
            $section,
            1
        );
    }

    // collect the repeating cards, which must be a contiguous sibling run
    $run = [];
    $offset = 0;
    while (preg_match('#<div[^>]*class="(?:[^"]*\s)?' . preg_quote($band['item_class'], '#') . '(?:\s[^"]*)?"#', $section, $m, PREG_OFFSET_CAPTURE, $offset)) {
        $s = $m[0][1];
        $e = match_close($section, $s, 'div');
        $run[] = [$s, $e];
        $offset = $e;
    }

    if (! $run) {
        return [$html, sprintf('  %-22s no %s cards', $band['label'], $band['item_class'])];
    }

    for ($i = 1; $i < count($run); $i++) {
        if (trim(substr($section, $run[$i - 1][1], $run[$i][0] - $run[$i - 1][1])) !== '') {
            return [$html, sprintf('  %-22s cards are not adjacent', $band['label'])];
        }
    }

    $template = substr($section, $run[0][0], $run[0][1] - $run[0][0]);
    $item = ($band['build'])($template);

    $loop = '@foreach (' . $band['source'] . ' as $' . $band['as'] . ')' . $item . '@endforeach';
    $section = substr($section, 0, $run[0][0]) . $loop . substr($section, end($run)[1]);

    // hide the whole band while its collection is empty
    $section = '@if (' . $band['guard'] . ')' . "\n    " . $section . "\n    " . '@endif';

    $html = substr($html, 0, $start) . $section . substr($html, $end);

    return [$html, sprintf('  %-22s %d card(s) -> loop', $band['label'], count($run))];
}

/** One logo chip: the uploaded logo when there is one, the styled name if not. */
$logoChip = <<<'BLADE'
@if ($client->logo)<img src="{{ $client->logo->url }}" loading="lazy" alt="{{ $client->logo_alt ?: $client->name }}" class="client-logo-image{{ $client->variant ? ' ' . $client->variant : '' }}">@else<div class="client-logo{{ $client->variant ? ' ' . $client->variant : '' }}">{{ $client->name }}</div>@endif
BLADE;

$bindLogo = function (string $item) use ($logoChip): string {
    return preg_replace(
        '#<div class="client-logo(?:\s[^"]*)?">.*?</div>#s',
        $logoChip,
        $item,
        1
    );
};

$BANDS = [
    [
        'label' => 'core values',
        'marker' => 'CORE VALUES',
        'item_class' => 'our-process-item',
        'source' => '\App\Models\CoreValue::published()->ordered()->get()',
        'as' => 'value',
        'guard' => '\App\Models\CoreValue::published()->exists()',
        'text' => [
            'caption' => ['about.core_values.caption', 'CORE VALUES'],
        ],
        'heading' => ['about.core_values.heading', 'THE PRINCIPLES BEHIND EVERY ENGAGEMENT'],
        'build' => function (string $item): string {
            // the first circle carries margin-left-none; rebuild it per $loop->first
            $item = preg_replace(
                '#(^<div[^>]*class="our-process-item)\s+margin-left-none(")#',
                '$1{{ $loop->first ? \' margin-left-none\' : \'\' }}$2',
                $item,
                1
            );
            $item = bind_class($item, 'our-process-item-title', '{{ $value->title }}');

            // the description is a sibling after the title, not inside it
            $item = preg_replace(
                '#(<div class="our-process-item-title">.*?</div>)#s',
                '$1@if ($value->description)<p>{{ $value->description }}</p>@endif',
                $item,
                1
            );

            return preg_replace(
                '#(<div[^>]*class="(?:[^"]*\s)?process-counting-wrap(?:\s[^"]*)?"[^>]*>\s*<div[^>]*>)(.*?)(</div>)#s',
                '$1{{ $value->number ?: $loop->iteration }}$3',
                $item,
                1
            );
        },
    ],
    [
        'label' => 'our partners',
        'marker' => 'OUR PARTNERS',
        'item_class' => 'client-logo-wrap',
        'source' => "\App\Models\Client::published()->forScope('partner')->ordered()->get()",
        'as' => 'client',
        'guard' => "\App\Models\Client::published()->forScope('partner')->exists()",
        'text' => [
            'caption' => ['about.our_partners.caption', 'OUR PARTNERS'],
        ],
        'heading' => ['about.our_partners.heading', 'TECHNOLOGY PARTNERSHIPS THAT EXTEND WHAT WE DELIVER'],
        'build' => $bindLogo,
    ],
    [
        'label' => 'certifications',
        'marker' => 'CERTIFICATIONS',
        'item_class' => 'client-logo-wrap',
        'source' => "\App\Models\Client::published()->forScope('certification')->ordered()->get()",
        'as' => 'client',
        'guard' => "\App\Models\Client::published()->forScope('certification')->exists()",
        'text' => [
            'caption' => ['about.certifications.caption', 'CERTIFICATIONS & MEMBERSHIP'],
        ],
        'heading' => ['about.certifications.heading', 'THE STANDARDS WE HOLD AND THE BODIES WE BELONG TO'],
        'build' => $bindLogo,
    ],
    [
        'label' => 'awards',
        'marker' => 'AWARDS',
        'item_class' => 'award-collection-item',
        'source' => '\App\Models\Award::published()->ordered()->get()',
        'as' => 'award',
        'guard' => '\App\Models\Award::published()->exists()',
        'text' => [
            'caption' => ['about.awards.caption', 'AWARDS & ACHIEVEMENTS'],
        ],
        'heading' => ['about.awards.heading', 'RECOGNISED FOR THE WORK WE DELIVER'],
        'build' => function (string $item): string {
            $item = bind_class($item, 'job-item-title', '{{ $award->title }}');

            /*
             * job-info holds nested divs, so its extent comes from brace
             * matching. A lazy regex would stop at the inner job-info-text's
             * own close tag and leave the original year sitting next to the
             * bound one.
             */
            $open = '<div class="job-info">';
            $at = strpos($item, $open);

            if ($at === false) {
                return $item;
            }

            /*
             * The two conditionals must not touch. Blade only recognises a
             * directive when the character before its @ is not a word
             * boundary, so "@endif@if" leaves the second one as literal text
             * and its @endif then closes nothing — "unexpected token endif".
             */
            $inner = "\n"
                . '                                        @if ($award->year)<div class="job-info-text">{{ $award->year }}</div>@endif' . "\n"
                . '                                        @if ($award->awarded_by)<div class="job-info-text">{{ $award->awarded_by }}</div>@endif' . "\n"
                . '                                    ';

            return substr($item, 0, $at) . $open . $inner . '</div>'
                . substr($item, match_close($item, $at, 'div'));
        },
    ],
];

$report = [];

foreach ($BANDS as $band) {
    [$html, $line] = wire_band($html, $band);
    $report[] = $line;
}

file_put_contents($VIEW, $html);

echo implode("\n", $report), "\n";
