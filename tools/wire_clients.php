<?php
/**
 * Wires the client marquee.
 *
 * The band is three rows, and each row repeats its list twice so the scroll can
 * loop seamlessly — so every `client-logo-item` gets the same loop, and the row
 * number comes from its position.
 *
 * Run: php tools/wire_clients.php
 */

require __DIR__ . '/lib_slice.php';

$VIEWS = dirname(__DIR__) . '/resources/views/site/pages/';

foreach (['about', 'services'] as $view) {
    $file = $VIEWS . $view . '.blade.php';
    if (! is_file($file)) {
        continue;
    }

    $html = file_get_contents($file);

    // find the rows first; each holds two identical copies of its list
    $rows = [];
    $offset = 0;
    while (preg_match('#<div[^>]*class="(?:[^"]*\s)?client-logo-list-inner(?:\s[^"]*)?"#', $html, $m, PREG_OFFSET_CAPTURE, $offset)) {
        $start = $m[0][1];
        $end = match_close($html, $start, 'div');
        $rows[] = [$start, $end];
        $offset = $end;
    }

    if (! $rows) {
        printf("  %-12s no client rows found\n", $view);
        continue;
    }

    $wired = 0;

    // rewrite back to front so earlier offsets stay valid
    foreach (array_reverse($rows) as $index => [$rowStart, $rowEnd]) {
        $rowNumber = count($rows) - $index;
        $row = substr($html, $rowStart, $rowEnd - $rowStart);

        // every copy of the row gets the same loop
        $copies = [];
        $o = 0;
        while (preg_match('#<div[^>]*class="(?:[^"]*\s)?client-logo-item(?:\s[^"]*)?"#', $row, $m, PREG_OFFSET_CAPTURE, $o)) {
            $s = $m[0][1];
            $e = match_close($row, $s, 'div');
            $copies[] = [$s, $e];
            $o = $e;
        }

        foreach (array_reverse($copies) as [$copyStart, $copyEnd]) {
            $copy = substr($row, $copyStart, $copyEnd - $copyStart);

            $wraps = [];
            $o = 0;
            while (preg_match('#<div[^>]*class="(?:[^"]*\s)?client-logo-wrap(?:\s[^"]*)?"#', $copy, $m, PREG_OFFSET_CAPTURE, $o)) {
                $s = $m[0][1];
                $e = match_close($copy, $s, 'div');
                $wraps[] = [$s, $e];
                $o = $e;
            }

            if (count($wraps) < 2) {
                continue;
            }

            $template = substr($copy, $wraps[0][0], $wraps[0][1] - $wraps[0][0]);

            // the name is styled text, and some entries carry a light variant
            $bound = preg_replace(
                '#(<div class="client-logo)((?:\s[^"]*)?)(">)(.*?)(</div>)#s',
                '$1{{ $client->variant ? \' \' . $client->variant : \'\' }}$3{{ $client->name }}$5',
                $template,
                1
            );

            $loop = "@foreach (\App\Models\Client::published()->where('row_group', $rowNumber)->ordered()->get() as \$client)"
                . $bound
                . '@endforeach';

            $copy = substr($copy, 0, $wraps[0][0]) . $loop . substr($copy, end($wraps)[1]);
            $row = substr($row, 0, $copyStart) . $copy . substr($row, $copyEnd);
            $wired++;
        }

        $html = substr($html, 0, $rowStart) . $row . substr($html, $rowEnd);
    }

    file_put_contents($file, $html);
    printf("  %-12s %d row(s), %d marquee copies wired\n", $view, count($rows), $wired);
}
