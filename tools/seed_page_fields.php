<?php
/**
 * Declares page-section fields that wire_page_text.php binds.
 *
 * cms() only returns a stored value once the section's `content` map actually
 * declares the key — an undeclared key counts as "the dashboard has no input
 * for this", so it falls through to the export's literal and the editor never
 * shows a box for it. Adding the binding without adding the field therefore
 * looks like it worked and changes nothing.
 *
 * Values are seeded to the export's own copy, so the page renders unchanged and
 * the field simply becomes editable.
 *
 * Idempotent: a field that already exists is left as it is, so a value someone
 * has since edited is never overwritten.
 *
 * Run: php tools/seed_page_fields.php [--dry]
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\PageSection;

$dry = in_array('--dry', $argv, true);

/** page slug => section key => field => [type, value] */
$FIELDS = [
    'why-choose-us' => [
        'why_choose_us_hero' => [
            'heading_line_2' => ['text', 'choose us'],
            'button_label' => ['text', 'LET’S TALK'],
        ],
        'cta' => [
            'heading_line_2' => ['text', 'PROJECT NOW'],
            'button_label' => ['text', 'GET IT TOUCH'],
        ],
    ],
];

$added = 0;
$kept = 0;
$missing = [];

foreach ($FIELDS as $pageSlug => $sections) {
    foreach ($sections as $sectionKey => $fields) {
        $section = PageSection::whereHas('page', fn ($q) => $q->where('slug', $pageSlug))
            ->where('key', $sectionKey)
            ->first();

        if (! $section) {
            $missing[] = "$pageSlug.$sectionKey";
            continue;
        }

        $content = (array) $section->content;
        $changed = false;

        foreach ($fields as $field => [$type, $value]) {
            if (array_key_exists($field, $content)) {
                $kept++;
                continue;
            }

            $content[$field] = ['type' => $type, 'value' => $value];
            $changed = true;
            $added++;
            printf("  + %s.%s.%s = %s\n", $pageSlug, $sectionKey, $field, $value);
        }

        if ($changed && ! $dry) {
            $section->update(['content' => $content]);
        }
    }
}

printf("\n  added %d field(s), left %d already present\n", $added, $kept);

foreach ($missing as $m) {
    echo "  ! no such section: $m\n";
}

echo $dry ? "  (dry run, nothing written)\n" : '';
