<?php
/**
 * Binds the contact details the export hardcoded to the Contact settings group.
 *
 * `contact.email`, `contact.sales_email`, `contact.phone`, `contact.office_address`
 * and `contact.sales_address` all existed in the dashboard and were read by
 * nothing: the contact page carried Webflow's own hello@edoly.com, the career
 * page a placeholder gmail address, and the footer its copyright line as plain
 * text. Editing any of them changed nothing on the site.
 *
 * Every replacement keeps the export's literal as the fallback argument, so an
 * empty setting renders what it always did.
 *
 * Idempotent — a literal already inside a setting() call is not matched again,
 * because the raw string no longer appears where the pattern looks for it.
 *
 * Run: php tools/build.php   (or php tools/wire_contact.php [--dry])
 */

define('NEEDS_EXPORT', false);
require __DIR__ . '/config.php';

$dry = in_array('--dry', $argv, true);

/**
 * file => [[description, pattern, replacement], ...]
 *
 * Patterns are whitespace-tolerant across the literals because the converter
 * wraps long lines mid-string — "714 Example\n location" is one text node.
 */
$edits = [
    'pages/contact.blade.php' => [
        [
            'office address',
            '#<p><a href="\#">714\s+Example\s+location</a></p>#',
            '<p><a href="#">{{ setting(\'contact.office_address\', \'714 Example location\') }}</a></p>',
        ],
        [
            /*
             * Matched by position, not by the address itself.
             *
             * The export shipped hello@edoly.com and the site has since been
             * given a real one; pinning the pattern to Webflow's placeholder
             * made the pass silently skip the very field it exists to bind.
             * $1 carries whatever address is there now, so it becomes the
             * fallback and the page renders unchanged.
             */
            'office email',
            '#<a href="mailto:([^"@{}]+@[^"{}]+)"(\s+)class="address-link">\1</a>#',
            '<a href="mailto:{{ setting(\'contact.email\', \'$1\') }}"$2class="address-link">{{ setting(\'contact.email\', \'$1\') }}</a>',
        ],
        [
            'sales address',
            '#<p><a href="\#">715\s+Example\s+location</a></p>#',
            '<p><a href="#">{{ setting(\'contact.sales_address\', \'715 Example location\') }}</a></p>',
        ],
        [
            // same shape; runs after the office rule, so it takes the next match
            'sales email',
            '#<a href="mailto:([^"@{}]+@[^"{}]+)"(\s+)class="address-link">\1</a>#',
            '<a href="mailto:{{ setting(\'contact.sales_email\', \'$1\') }}"$2class="address-link">{{ setting(\'contact.sales_email\', \'$1\') }}</a>',
        ],
        [
            'postal address',
            '#<p><a href="\#">716\s+Example\s+location</a></p>#',
            '<p><a href="#">{{ setting(\'contact.address\', \'716 Example location\') }}</a></p>',
        ],
        [
            'phone',
            '#<a href="tel:\+0-000-000-000"(\s+)class="address-link">\+0-000-000-000</a>#',
            '<a href="tel:{{ setting(\'contact.phone\', \'+0-000-000-000\') }}"$1class="address-link">{{ setting(\'contact.phone\', \'+0-000-000-000\') }}</a>',
        ],
    ],

    'pages/career-details.blade.php' => [
        [
            'job application address',
            '#href="mailto:applyexamplejob@gmail\.com\?subject=Job%20Apply"#',
            'href="mailto:{{ setting(\'contact.jobs_email\', \'applyexamplejob@gmail.com\') }}?subject=Job%20Apply"',
        ],
    ],

    'partials/footer.blade.php' => [
        [
            'copyright line',
            '#<p>© All rights reserved\.#u',
            '<p>{{ setting(\'footer.copyright\', \'© All rights reserved.\') }}',
        ],
    ],
];

$applied = 0;
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
        $html = preg_replace($pattern, $replacement, $html, 1, $count);

        if ($count) {
            $applied++;
        } elseif (str_contains($before, $replacementProbe = trim(explode("'", $replacement)[1] ?? '', ' '))) {
            $already++;
        } else {
            $failed[] = "$relative: $what";
        }
    }

    if (! $dry && $html !== $before) {
        file_put_contents($file, $html);
    }
}

printf("  bound %d, already bound %d\n", $applied, $already);

foreach ($failed as $f) {
    echo "  ! not found: $f\n";
}

echo $dry ? "  (dry run, nothing written)\n" : '';
