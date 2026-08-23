<?php
/**
 * Lifts the template's shipped content into database/data/content.json, which
 * the seeders then load. Run: php tools/extract_content.php
 */

require __DIR__ . '/lib_extract.php';

$out = [];

// ---------------------------------------------------------------- services
$x = load_doc('home.html');
foreach ($x->query('//div[' . has_class('service-collection-item') . ']') as $i => $item) {
    $out['services'][] = [
        'counter' => first_text($x, './/div[' . has_class('service-counter') . ']', $item),
        'title' => first_text($x, './/div[' . has_class('service-title') . ']', $item),
        'image' => media_key(first_attr($x, './/img', 'src', $item)),
        'image_alt' => first_attr($x, './/img', 'alt', $item),
        'sort_order' => $i,
    ];
}

// ---------------------------------------------------------------- case studies
$x = load_doc('casestudy.html');
foreach ($x->query('//div[' . has_class('case-study-collection-item') . ']') as $i => $item) {
    $out['case_studies'][] = [
        'title' => first_text($x, './/*[' . has_class('case-study-title') . ']', $item),
        'subtitle' => first_text($x, './/*[' . has_class('case-study-subtitle') . ']', $item),
        'image' => media_key(first_attr($x, './/img', 'src', $item)),
        'image_alt' => first_attr($x, './/img', 'alt', $item),
        'sort_order' => $i,
    ];
}

// ---------------------------------------------------------------- blog posts
$x = load_doc('blog.html');
$seen = [];
foreach (['feature-blog-collection-item', 'blog-collection-item'] as $cls) {
    foreach ($x->query('//div[' . has_class($cls) . ']') as $item) {
        $title = first_text($x, './/*[' . has_class('blog-title') . ']', $item);
        if ($title === '' || isset($seen[$title])) {
            continue;
        }
        $seen[$title] = true;

        $info = [];
        foreach (['blog-info-text', 'blog-info'] as $metaClass) {
            foreach ($x->query('.//*[' . has_class($metaClass) . ']', $item) as $n) {
                $info[] = node_text($n);
            }
            if ($info) {
                break;
            }
        }

        $out['posts'][] = [
            'title' => $title,
            'summary' => first_text($x, './/*[' . has_class('blog-post-summary') . ']', $item),
            'image' => media_key(first_attr($x, './/img[' . has_class('blog-image') . ']', 'src', $item)),
            'image_alt' => first_attr($x, './/img[' . has_class('blog-image') . ']', 'alt', $item),
            'info' => $info,
            'is_featured' => $cls === 'feature-blog-collection-item',
            'sort_order' => count($out['posts'] ?? []),
        ];
    }
}

// ---------------------------------------------------------------- testimonials
// each tab link is one testimonial; the company name is a span inside the title
$x = load_doc('home.html');
foreach ($x->query('//*[' . has_class('testimonial-content-wrap') . ']') as $i => $item) {
    $company = first_text($x, './/span[' . has_class('lowercase-regular') . ']', $item);
    $titleLine = first_text($x, './/*[' . has_class('testimonial-title') . ']', $item);
    $authorRole = trim(str_replace($company, '', $titleLine));

    $out['testimonials'][] = [
        'author_line' => $authorRole,
        'company' => $company,
        'quote' => first_text($x, './/*[' . has_class('testimonial-description') . ']', $item),
        'image' => media_key(first_attr($x, './/img', 'src', $item)),
        'image_alt' => first_attr($x, './/img', 'alt', $item),
        'sort_order' => $i,
    ];
}

// ---------------------------------------------------------------- team + clients
$x = load_doc('about.html');
foreach ($x->query('//div[' . has_class('our-team-item') . ']') as $i => $item) {
    $socials = [];
    foreach ($x->query('.//a[@href]', $item) as $a) {
        $socials[] = $a->getAttribute('href');
    }
    $out['team_members'][] = [
        'name' => first_text($x, './/*[' . has_class('team-member-name') . ']', $item),
        'image' => media_key(first_attr($x, './/img', 'src', $item)),
        'image_alt' => first_attr($x, './/img', 'alt', $item),
        'socials' => array_values(array_unique($socials)),
        'sort_order' => $i,
    ];
}

// the marquee repeats each row, so only the first copy is real content
foreach ($x->query('//div[' . has_class('client-logo-list-inner') . ']') as $row => $rowNode) {
    $firstCopy = $x->query('.//div[' . has_class('client-logo-item') . ']', $rowNode)->item(0);
    if (! $firstCopy) {
        continue;
    }
    foreach ($x->query('.//div[' . has_class('client-logo') . ']', $firstCopy) as $i => $logo) {
        $classes = preg_split('/\s+/', trim($logo->getAttribute('class')), -1, PREG_SPLIT_NO_EMPTY);
        $variant = implode(' ', array_values(array_diff($classes, ['client-logo'])));

        $out['clients'][] = [
            'name' => node_text($logo),
            'variant' => $variant ?: null,
            'row_group' => $row + 1,
            'sort_order' => $i,
        ];
    }
}

// ---------------------------------------------------------------- jobs + benefits
$x = load_doc('career.html');
foreach ($x->query('//div[' . has_class('job-collection-item') . ']') as $i => $item) {
    $info = [];
    foreach ($x->query('.//*[' . has_class('job-info-text') . ']', $item) as $n) {
        $info[] = node_text($n);
    }
    $meta = [];
    foreach ($x->query('.//*[' . has_class('job-info-text') . ']', $item) as $n) {
        $meta[] = node_text($n);
    }

    $out['jobs'][] = [
        'title' => first_text($x, './/*[' . has_class('job-item-title') . ']', $item),
        'location' => $meta[0] ?? '',
        'employment_type' => $meta[1] ?? '',
        'sort_order' => $i,
    ];
}

foreach ($x->query('//div[' . has_class('our-benefits-item') . ']') as $i => $item) {
    $out['benefits'][] = [
        'scope' => 'career',
        'number' => first_text($x, './/*[' . has_class('process-counting-wrap') . ']', $item),
        'title' => first_text($x, './/*[' . has_class('our-process-item-title') . ']', $item),
        'sort_order' => $i,
    ];
}
foreach ($x->query('//div[' . has_class('our-benefits-image-item') . ']') as $item) {
    $out['benefit_images'][] = media_key(first_attr($x, './/img', 'src', $item));
}

// ---------------------------------------------------------------- faqs
$x = load_doc('faq.html');
foreach ($x->query('//div[' . has_class('faq-item') . ']') as $i => $item) {
    $out['faqs'][] = [
        'question' => first_text($x, './/*[' . has_class('faq-title') . ']', $item),
        'answer' => first_html($x, './/*[' . has_class('faq-content') . ']', $item),
        'sort_order' => $i,
    ];
}

// ---------------------------------------------------------------- process steps + stats
$scopes = [
    ['home.html', 'home'],
    ['service.html', 'service'],
    ['services-details.html', 'service-details'],
    ['why-choose-us.html', 'why-choose-us'],
    ['about.html', 'about'],
    ['career.html', 'career'],
];

foreach ($scopes as [$page, $scope]) {
    $x = load_doc($page);

    foreach ($x->query('//div[' . has_class('our-process-item') . ']') as $i => $item) {
        $title = first_text($x, './/*[' . has_class('our-process-item-title') . ']', $item);
        $number = first_text($x, './/*[' . has_class('process-counting-wrap') . ']', $item);
        $rest = trim(str_replace([$title, $number], '', node_text($item)));

        $out['process_steps'][] = [
            'scope' => $scope,
            'number' => $number,
            'title' => $title,
            'description' => $rest,
            'sort_order' => $i,
        ];
    }

    foreach ($x->query('//div[' . has_class('about-us-info-item') . ']') as $i => $item) {
        [$value, $suffix, $suffixHtml] = decode_counter($x, $item);

        $out['stats'][] = [
            'scope' => $scope,
            'value' => $value,
            'suffix' => $suffix,
            'suffix_html' => $suffixHtml,
            'label' => first_text($x, './/*[' . has_class('gray-text') . ']', $item),
            'sort_order' => $i,
        ];
    }
}

@mkdir(__DIR__ . '/../database/data', 0777, true);
file_put_contents(
    __DIR__ . '/../database/data/content.json',
    json_encode($out, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
);

foreach ($out as $key => $rows) {
    printf("%-18s %d\n", $key, count($rows));
}
