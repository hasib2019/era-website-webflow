<?php
/**
 * Makes the four detail pages render the record in the URL.
 *
 * Only the fields that genuinely belong to one record are switched over; the
 * captions, CTA and section headings stay page-section fields because they are
 * the same whichever record is being shown. Each binding keeps the section value
 * as its fallback, so a record with that field still empty renders as before.
 *
 * Run: php tools/wire_details.php
 */

$VIEWS = dirname(__DIR__) . '/resources/views/site/pages/';

$BINDINGS = [
    'blog-details' => [
        'blog_details_hero.post_title' => '$post->title',
        'blog_details_hero.author_name' => '$post->author_name',
        'blog_details_hero.published_date' => '$post->published_at?->format(\'F j, Y\')',
        'blog_details_hero.read_time_value' => '$post->read_time',
        'blog_details_hero.read_time_label' => '$post->read_time_unit',
        'blog_details_hero.author_image@image' => '$post->authorImage?->url',
    ],
    'service-details' => [
        'service_details_hero.hero_title' => '$service->hero_heading ?: $service->title',
        'service_details_hero.hero_description' => '$service->hero_intro ?: $service->excerpt',
        'service_details_hero.hero_image@image' => '$service->heroImage?->url ?: $service->image?->url',
    ],
    'case-study-details' => [
        'case_study_details_hero.case_study_title' => '$caseStudy->title',
        'case_study_info.client_name' => '$caseStudy->client',
        'case_study_info.date_value' => '$caseStudy->duration',
        'case_study_info.services_value' => '$caseStudy->category',
    ],
    'career-details' => [
        'career_hero.job_title' => '$job->title',
    ],
];

$total = 0;

foreach ($BINDINGS as $view => $fields) {
    $file = $VIEWS . $view . '.blade.php';
    if (! is_file($file)) {
        echo "  ! missing view $view\n";
        continue;
    }

    $html = file_get_contents($file);
    $bound = 0;

    foreach ($fields as $path => $expression) {
        $isImage = str_ends_with($path, '@image');
        if ($isImage) {
            $path = substr($path, 0, -strlen('@image'));
        }

        $helper = $isImage ? 'cms_image' : 'cms';
        // rebuild the call with the record first and the section value behind it
        $pattern = '#' . preg_quote($helper . "('" . $view . '.' . $path . "', ", '#') . '#';

        $replacement = $isImage
            ? '(' . $expression . ') ?: cms_image(\'' . $view . '.' . $path . '\', '
            : '(' . $expression . ') ?: cms(\'' . $view . '.' . $path . '\', ';

        $count = 0;
        $html = preg_replace($pattern, $replacement, $html, -1, $count);

        if ($count === 0) {
            printf("    ! %s not found\n", $path);
            continue;
        }

        $bound += $count;
    }

    file_put_contents($file, $html);
    printf("  %-22s %d binding(s)\n", $view, $bound);
    $total += $bound;
}

echo "\n$total detail binding(s) applied\n";
