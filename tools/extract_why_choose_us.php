<?php
/**
 * Fills in the why-choose-us page, which the inventory pass did not cover.
 * Reads each band's headings, copy and images straight from the export and
 * merges the result into database/data/pages.json.
 */

require __DIR__ . '/lib_extract.php';

$x = load_doc('why-choose-us.html');

$bands = [
    'why_choose_us_hero' => 'section-common-hero',
    'our_solution' => 'section-our-solution',
    'our_evaluation' => 'section-our-evaluation',
    'our_process' => 'section-our-process',
    'testimonials' => 'section-testimonial',
    'faq' => 'section-faq',
    'latest_blog' => 'home-latest-blog',
    'cta' => 'section-cta',
];

$sections = [];
$order = 0;

foreach ($bands as $key => $class) {
    $node = $x->query('//*[' . has_class($class) . ']')->item(0);
    if (! $node) {
        continue;
    }

    $content = [];

    if ($caption = first_text($x, './/*[' . has_class('caption') . ']', $node)) {
        $content['caption'] = ['type' => 'text', 'value' => $caption];
    }

    $headings = [];
    foreach ($x->query('.//h1|.//h2|.//h3', $node) as $h) {
        $t = node_text($h);
        if ($t !== '' && ! in_array($t, $headings, true)) {
            $headings[] = $t;
        }
    }
    foreach ($headings as $i => $h) {
        $content['heading' . ($i ? '_' . ($i + 1) : '')] = ['type' => 'text', 'value' => $h];
    }

    $paras = [];
    foreach ($x->query('.//p', $node) as $p) {
        $t = node_text($p);
        if ($t !== '' && ! in_array($t, $paras, true)) {
            $paras[] = $t;
        }
    }
    foreach (array_slice($paras, 0, 4) as $i => $p) {
        $content['paragraph' . ($i ? '_' . ($i + 1) : '')] = ['type' => 'richtext', 'value' => $p];
    }

    $images = [];
    foreach ($x->query('.//img', $node) as $img) {
        $src = media_key($img->getAttribute('src'));
        if ($src !== '' && ! in_array($src, $images, true)) {
            $images[] = $src;
        }
    }
    foreach (array_slice($images, 0, 4) as $i => $src) {
        $content['image' . ($i ? '_' . ($i + 1) : '')] = ['type' => 'image', 'value' => $src];
    }

    $sections[] = [
        'key' => $key,
        'name' => ucwords(str_replace('_', ' ', $key)),
        'content' => $content,
        'sort_order' => $order++,
    ];
}

$file = __DIR__ . '/../database/data/pages.json';
$pages = json_decode(file_get_contents($file), true);

foreach ($pages as &$page) {
    if ($page['slug'] === 'why-choose-us') {
        $page['sections'] = $sections;
    }
}
unset($page);

file_put_contents($file, json_encode($pages, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

printf("why-choose-us: %d sections, %d fields\n", count($sections), array_sum(array_map(fn ($s) => count($s['content']), $sections)));
