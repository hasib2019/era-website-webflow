<?php
/**
 * Converts the page inventory produced during the conversion audit into
 * database/data/pages.json, which PageContentSeeder loads.
 */

$INVENTORY = __DIR__ . '/inventory/page-inventory.json';

$groupToPage = [
    'home' => ['home', 'Home', 'home'],
    'about' => ['about', 'About Us', 'about'],
    'service' => ['services', 'Services', 'services.index'],
    'services-details' => ['service-details', 'Service Details', 'services.show'],
    'casestudy' => ['case-studies', 'Case Studies', 'case-studies.index'],
    'case-study-details' => ['case-study-details', 'Case Study Details', 'case-studies.show'],
    'blog' => ['blog', 'Blog', 'blog.index'],
    'blog-details' => ['blog-details', 'Blog Details', 'blog.show'],
    'career' => ['career', 'Career', 'career.index'],
    'career-details' => ['career-details', 'Career Details', 'career.show'],
    'contact-us' => ['contact', 'Contact Us', 'contact'],
    'faq' => ['faq', 'FAQ', 'faq'],
    'why-choose-us' => ['why-choose-us', 'Why Choose Us', 'why-choose-us'],
];

$raw = json_decode(file_get_contents($INVENTORY), true);
$inventories = $raw['inventories'] ?? [];

$pages = [];

foreach ($inventories as $inv) {
    $group = $inv['group'] ?? null;

    // the misc agent covered three small pages at once
    if ($group === 'misc') {
        foreach (['changelog' => ['changelog', 'Changelog', 'changelog'],
                  'style_guide' => ['style-guide', 'Style Guide', 'style-guide'],
                  'notfound' => ['404', 'Not Found', 'not-found']] as $prefix => $meta) {
            $sections = array_values(array_filter(
                $inv['sections'] ?? [],
                fn ($s) => str_starts_with($s['key'], $prefix)
            ));
            if ($sections) {
                $pages[] = build_page($meta, $sections);
            }
        }
        continue;
    }

    if (! isset($groupToPage[$group])) {
        continue;
    }

    $pages[] = build_page($groupToPage[$group], $inv['sections'] ?? []);
}

function build_page(array $meta, array $sections): array
{
    [$slug, $name, $routeName] = $meta;

    return [
        'slug' => $slug,
        'name' => $name,
        'route_name' => $routeName,
        'sections' => array_map(function (array $s, int $i) {
            $content = [];
            foreach ($s['fields'] ?? [] as $field) {
                $content[$field['key']] = [
                    'type' => $field['type'] ?? 'text',
                    'value' => $field['current_value'] ?? '',
                ];
            }

            return [
                'key' => $s['key'],
                'name' => ucwords(str_replace('_', ' ', $s['key'])),
                'content' => $content,
                'sort_order' => $i,
            ];
        }, $sections, array_keys($sections)),
    ];
}

@mkdir(__DIR__ . '/../database/data', 0777, true);
file_put_contents(
    __DIR__ . '/../database/data/pages.json',
    json_encode($pages, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
);

$fields = 0;
foreach ($pages as $p) {
    printf("%-22s %2d sections\n", $p['slug'], count($p['sections']));
    foreach ($p['sections'] as $s) {
        $fields += count($s['content']);
    }
}
echo count($pages) . " pages, $fields editable fields\n";
