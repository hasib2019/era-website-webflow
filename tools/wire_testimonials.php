<?php
/**
 * Wires the testimonial slider.
 *
 * It is a Webflow tab group: each quote is a tab link and each portrait a pane,
 * tied together by generated ids. Looping it means regenerating those ids from
 * the loop index, which is why it needs its own pass.
 *
 * Run: php tools/wire_testimonials.php
 */

require __DIR__ . '/lib_slice.php';

$VIEWS = dirname(__DIR__) . '/resources/views/site/pages/';
$PAGES = ['home', 'about', 'case-studies', 'case-study-details', 'career', 'why-choose-us'];

/** Offsets of every element with $class, in document order. */
function run_of(string $html, string $class, string $tag): array
{
    $run = [];
    $offset = 0;

    while (preg_match('#<' . $tag . '[^>]*class="(?:[^"]*\s)?' . preg_quote($class, '#') . '(?:\s[^"]*)?"#', $html, $m, PREG_OFFSET_CAPTURE, $offset)) {
        $start = $m[0][1];
        $end = match_close($html, $start, $tag);
        $run[] = [$start, $end];
        $offset = $end;
    }

    return $run;
}

/** Rewrites the generated tab ids to come from the loop index. */
function retarget_tab(string $markup): string
{
    $markup = preg_replace('#data-w-tab="Tab \d+"#', 'data-w-tab="Tab {{ $loop->iteration }}"', $markup);
    $markup = preg_replace('#id="w-tabs-0-data-w-tab-\d+"#', 'id="w-tabs-0-data-w-tab-{{ $loop->index }}"', $markup);
    $markup = preg_replace('#id="w-tabs-0-data-w-pane-\d+"#', 'id="w-tabs-0-data-w-pane-{{ $loop->index }}"', $markup);
    $markup = preg_replace('#href="\#w-tabs-0-data-w-pane-\d+"#', 'href="#w-tabs-0-data-w-pane-{{ $loop->index }}"', $markup);
    $markup = preg_replace('#aria-controls="w-tabs-0-data-w-pane-\d+"#', 'aria-controls="w-tabs-0-data-w-pane-{{ $loop->index }}"', $markup);
    $markup = preg_replace('#aria-selected="(?:true|false)"#', 'aria-selected="{{ $loop->index === $activeTab ? \'true\' : \'false\' }}"', $markup);

    return $markup;
}

/** Adds a class token only on the active tab. */
function active_class(string $markup, string $token): string
{
    return preg_replace_callback(
        '#class="([^"]*)"#',
        function (array $m) use ($token): string {
            $tokens = preg_split('/\s+/', $m[1], -1, PREG_SPLIT_NO_EMPTY);
            $rest = implode(' ', array_values(array_diff($tokens, [$token])));

            return 'class="' . $rest . '{{ $loop->index === $activeTab ? \' ' . $token . '\' : \'\' }}"';
        },
        $markup,
        1
    );
}

$SOURCE = "\App\Models\Testimonial::published()->ordered()->get()";

foreach ($PAGES as $view) {
    $file = $VIEWS . $view . '.blade.php';
    if (! is_file($file)) {
        continue;
    }

    $html = file_get_contents($file);

    $links = run_of($html, 'w-tab-link', 'a');
    $panes = run_of($html, 'w-tab-pane', 'div');

    if (count($links) < 2 || count($links) !== count($panes)) {
        printf("  %-20s skipped (%d links, %d panes)\n", $view, count($links), count($panes));
        continue;
    }

    // the export leaves the third tab open; keep that, but never past the end
    $active = 0;
    foreach ($links as $i => [$s, $e]) {
        if (str_contains(substr($html, $s, $e - $s), 'w--current')) {
            $active = $i;
        }
    }

    $preamble = '@php($activeTab = min(' . $active . ', \App\Models\Testimonial::published()->count() - 1))';

    // ---------------------------------------------------------------- panes first
    $pane = substr($html, $panes[0][0], $panes[0][1] - $panes[0][0]);
    $pane = retarget_tab($pane);
    $pane = active_class($pane, 'w--tab-active');
    $pane = preg_replace('#\s+srcset="[^"]*"#', '', $pane);
    $pane = preg_replace('#\s+sizes="[^"]*"#', '', $pane);
    $pane = preg_replace('#src="[^"]*"#', 'src="{{ $testimonial->image?->url }}"', $pane, 1);
    $pane = preg_replace('#alt="[^"]*"#', 'alt="{{ $testimonial->image_alt }}"', $pane, 1);

    $paneLoop = '@foreach (' . $SOURCE . ' as $testimonial)' . $pane . '@endforeach';
    $html = substr($html, 0, $panes[0][0]) . $paneLoop . substr($html, end($panes)[1]);

    // ---------------------------------------------------------------- then links
    $links = run_of($html, 'w-tab-link', 'a');
    $link = substr($html, $links[0][0], $links[0][1] - $links[0][0]);
    $link = retarget_tab($link);
    $link = active_class($link, 'w--current');

    // the title line is "NAME - ROLE <span>COMPANY</span>"
    $link = preg_replace(
        '#(<div class="testimonial-title"[^>]*>).*?(<span\s[^>]*class="lowercase-regular"[^>]*>).*?(</span>\s*</div>)#s',
        '$1{{ $testimonial->author_line }} $2{{ $testimonial->company }}$3',
        $link,
        1
    );
    $link = preg_replace(
        '#(<blockquote class="testimonial-description"[^>]*>)(.*?)(</blockquote>)#s',
        '$1{{ $testimonial->quote }}$3',
        $link,
        1
    );
    $link = preg_replace('#\s+srcset="[^"]*"#', '', $link);
    $link = preg_replace('#\s+sizes="[^"]*"#', '', $link);
    $link = preg_replace('#src="[^"]*"#', 'src="{{ $testimonial->image?->url }}"', $link, 1);
    $link = preg_replace('#alt="[^"]*"#', 'alt="{{ $testimonial->image_alt }}"', $link, 1);

    $linkLoop = $preamble . '@foreach (' . $SOURCE . ' as $testimonial)' . $link . '@endforeach';
    $html = substr($html, 0, $links[0][0]) . $linkLoop . substr($html, end($links)[1]);

    file_put_contents($file, $html);
    printf("  %-20s %d testimonials -> loop (active tab %d)\n", $view, count($links), $active);
}
