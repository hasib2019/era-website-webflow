<?php
/**
 * Binds the page copy the other passes left as literals.
 *
 *  1. The job hero on /career/{slug} printed the location and contract type of
 *     whichever job the export was taken from — every job page said "new york,
 *     Full time" regardless of the record in the URL.
 *  2. The footer's large wordmark.
 *  3. The remaining button labels and headings on /why-choose-us and
 *     /services/{slug}, which become page-section fields.
 *
 * Section fields only render through cms() once the section actually declares
 * them, so tools/seed_page_fields.php adds them to the database. Running this
 * pass without that leaves the export's literal showing — wrong, but harmless.
 *
 * Idempotent: every rule checks for its own output first.
 *
 * Run: php tools/build.php   (or php tools/wire_page_text.php [--dry])
 */

define('NEEDS_EXPORT', false);
require __DIR__ . '/config.php';

$dry = in_array('--dry', $argv, true);

/** file => [[what, pattern, replacement], ...] */
$edits = [
    'pages/career-details.blade.php' => [
        [
            'job location',
            '#(<div class="job-info-text color-white">)new york(</div>)#',
            '$1{{ $job->location }}$2',
        ],
        [
            'job contract type',
            '#(<div class="job-info-text color-white">)Full time(</div>)#',
            '$1{{ $job->employment_type }}$2',
        ],
    ],

    'partials/footer.blade.php' => [
        [
            'footer wordmark',
            '#(<div class="footer-big-text">)era(</div>)#',
            '$1{{ setting(\'footer.big_text\', \'era\') }}$2',
        ],
    ],

    'pages/service-details.blade.php' => [
        [
            'reason 1',
            '#(<h2>)1\. Proven Expertise(</h2>)#',
            '$1{{ cms(\'service-details.why_choose_us.reason_1\', \'1. Proven Expertise\') }}$2',
        ],
        [
            'reason 2',
            '#(<h2>)2\. Customized Strategies(</h2>)#',
            '$1{{ cms(\'service-details.why_choose_us.reason_2\', \'2. Customized Strategies\') }}$2',
        ],
        [
            'reason 3',
            '#(<h2>)3\. direct Communication(</h2>)#',
            '$1{{ cms(\'service-details.why_choose_us.reason_3\', \'3. direct Communication\') }}$2',
        ],
    ],

    'pages/why-choose-us.blade.php' => [
        [
            'hero second line',
            '#(<div class="display-large">)choose us(</div>)#',
            '$1{{ cms(\'why-choose-us.why_choose_us_hero.heading_line_2\', \'choose us\') }}$2',
        ],
        [
            'hero button label',
            '#(<div class="text-block">)LET’S TALK(</div>)(\s*)(<div>)LET’S TALK(</div>)#u',
            '$1{{ cms(\'why-choose-us.why_choose_us_hero.button_label\', \'LET’S TALK\') }}$2$3$4{{ cms(\'why-choose-us.why_choose_us_hero.button_label\', \'LET’S TALK\') }}$5',
        ],
        [
            'cta second line',
            '#(<div class="display-medium">)PROJECT NOW(</div>)#',
            '$1{{ cms(\'why-choose-us.cta.heading_line_2\', \'PROJECT NOW\') }}$2',
        ],
        [
            'cta button label',
            '#(<div class="text-block">)GET IT TOUCH(</div>)(\s*)(<div>)GET IT TOUCH(</div>)#',
            '$1{{ cms(\'why-choose-us.cta.button_label\', \'GET IT TOUCH\') }}$2$3$4{{ cms(\'why-choose-us.cta.button_label\', \'GET IT TOUCH\') }}$5',
        ],
    ],
];

$bound = 0;
$already = 0;
$failed = [];

foreach ($edits as $relative => $rules) {
    $file = SITE_VIEWS . $relative;

    if (! is_file($file)) {
        $failed[] = "$relative (no such view)";
        continue;
    }

    $html = file_get_contents($file);
    $before = $html;

    foreach ($rules as [$what, $pattern, $replacement]) {
        $count = 0;
        $html = preg_replace($pattern, $replacement, $html, 1, $count);

        if ($count) {
            $bound++;
            continue;
        }

        /*
         * No match can mean two things: the pass already ran, or the markup
         * moved. Telling them apart matters — a silent "no match" is how a
         * binding quietly stops being applied after an export change.
         */
        preg_match('#\'([a-z0-9_.\-]+)\'#', $replacement, $key);
        if (isset($key[1]) && str_contains($before, $key[1])) {
            $already++;
        } elseif (str_contains($replacement, '$job->') && str_contains($before, '$job->')) {
            $already++;
        } else {
            $failed[] = "$relative: $what";
        }
    }

    if (! $dry && $html !== $before) {
        file_put_contents($file, $html);
    }
}

printf("  bound %d, already bound %d\n", $bound, $already);

foreach ($failed as $f) {
    echo "  ! not found: $f\n";
}

echo $dry ? "  (dry run, nothing written)\n" : '';
