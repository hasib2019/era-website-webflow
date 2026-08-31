<?php
/**
 * Turns the template's repeated cards into loops over the database.
 *
 * Each entry below names the page view, the element that repeats, and how the
 * fields inside one card map onto the model. The first card in the markup is
 * used as the template, so the layout and every Webflow class survive intact.
 *
 * Run: php tools/wire_collections.php
 */

require __DIR__ . '/lib_slice.php';

$VIEWS = dirname(__DIR__) . '/resources/views/site/pages/';

/**
 * text  => class => Blade expression for the value
 * image => the expression for src
 * href  => the expression for the card's link
 */
$COLLECTIONS = [
    [
        'views' => ['home', 'services'],
        'item_class' => 'service-collection-item',
        'source' => "\App\Models\Service::published()->ordered()->get()",
        'as' => 'service',
        'text' => [
            'service-counter' => '$service->counter',
            'service-title' => '$service->title',
        ],
        'image' => "\$service->image?->url",
        'href' => "route('services.show', \$service->slug)",
    ],
    [
        'views' => ['case-studies'],
        'item_class' => 'case-study-collection-item',
        'source' => "\App\Models\CaseStudy::published()->ordered()->get()",
        'as' => 'study',
        'text' => [
            'case-study-title' => '$study->title',
            'case-study-subtitle' => '$study->subtitle',
        ],
        'image' => "\$study->image?->url",
        'href' => "route('case-studies.show', \$study->slug)",
    ],
    [
        // the home page's own separate entry: same card, but a 3-up preview
        // rather than the full (paginated) list case-studies.blade.php shows
        'views' => ['home'],
        'item_class' => 'case-study-collection-item',
        'source' => "\App\Models\CaseStudy::published()->ordered()->take(3)->get()",
        'as' => 'study',
        'text' => [
            'case-study-title' => '$study->title',
            'case-study-subtitle' => '$study->subtitle',
        ],
        'image' => "\$study->image?->url",
        'href' => "route('case-studies.show', \$study->slug)",
    ],
    [
        'views' => ['blog'],
        'item_class' => 'blog-collection-item',
        'source' => "\App\Models\Post::published()->where('is_featured', false)->latestFirst()->get()",
        'as' => 'post',
        'text' => [
            'blog-title' => '$post->title',
            'blog-post-summary' => '$post->summary',
        ],
        'image' => "\$post->image?->url",
        'image_class' => 'blog-image',
        'href' => "route('blog.show', \$post->slug)",
    ],
    [
        'views' => ['career'],
        'item_class' => 'job-collection-item',
        'source' => "\App\Models\JobOpening::published()->ordered()->get()",
        'as' => 'job',
        'text' => [
            'job-item-title' => '$job->title',
        ],
        'href' => "route('career.show', \$job->slug)",
    ],
    [
        'views' => ['faq'],
        'item_class' => 'faq-item',
        'source' => "\App\Models\Faq::published()->ordered()->get()",
        'as' => 'faq',
        'text' => [
            'faq-title' => '$faq->question',
        ],
        'raw_text' => [
            'faq-content' => '$faq->answer',
        ],
    ],
    [
        'views' => ['about'],
        'item_class' => 'our-team-item',
        'source' => "\App\Models\TeamMember::published()->ordered()->get()",
        'as' => 'member',
        'text' => [
            'team-member-name' => '$member->name',
        ],
        'image' => "\$member->image?->url",
    ],
];

/** Offsets of every element with $class that is a sibling run inside $html. */
function item_run(string $html, string $class, string $tag = 'div'): array
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

/** Rewrites one card's markup so its values come from $as. */
function bind_item(string $item, array $config): string
{
    foreach ($config['text'] ?? [] as $class => $expr) {
        $item = preg_replace(
            '#(<(?P<tag>[a-z][a-z0-9]*)[^>]*\sclass="' . preg_quote($class, '#') . '"[^>]*>)(.*?)(</(?P=tag)>)#s',
            '$1{{ ' . $expr . ' }}$4',
            $item,
            1
        );
    }

    foreach ($config['raw_text'] ?? [] as $class => $expr) {
        $item = preg_replace(
            '#(<(?P<tag>[a-z][a-z0-9]*)[^>]*\sclass="' . preg_quote($class, '#') . '"[^>]*>)(.*?)(</(?P=tag)>)#s',
            '$1{!! ' . $expr . ' !!}$4',
            $item,
            1
        );
    }

    if (! empty($config['image'])) {
        // srcset and sizes describe the template's own asset, so they go
        $item = preg_replace('#\s+srcset="[^"]*"#', '', $item);
        $item = preg_replace('#\s+sizes="[^"]*"#', '', $item);

        $imgClass = $config['image_class'] ?? null;
        $pattern = $imgClass
            ? '#<img([^>]*)src="[^"]*"([^>]*class="(?:[^"]*\s)?' . preg_quote($imgClass, '#') . '(?:\s[^"]*)?")#'
            : '#<img([^>]*)src="[^"]*"()#';

        $item = preg_replace($pattern, '<img$1src="{{ ' . $config['image'] . ' }}"$2', $item, 1);
    }

    if (! empty($config['href'])) {
        $item = preg_replace('#href="[^"]*"#', 'href="{{ ' . $config['href'] . ' }}"', $item, 1);
    }

    return $item;
}

$total = 0;

foreach ($COLLECTIONS as $config) {
    foreach ($config['views'] as $view) {
        $file = $VIEWS . $view . '.blade.php';
        if (! is_file($file)) {
            echo "  ! missing view $view\n";
            continue;
        }

        $html = file_get_contents($file);
        $run = item_run($html, $config['item_class']);

        if (count($run) < 2) {
            printf("  %-16s %-30s skipped (found %d)\n", $view, $config['item_class'], count($run));
            continue;
        }

        $template = substr($html, $run[0][0], $run[0][1] - $run[0][0]);
        $bound = bind_item($template, $config);

        $loop = '@foreach (' . $config['source'] . ' as $' . $config['as'] . ')'
            . $bound
            . '@endforeach';

        $html = substr($html, 0, $run[0][0]) . $loop . substr($html, end($run)[1]);
        file_put_contents($file, $html);

        printf("  %-16s %-30s %d cards -> loop\n", $view, $config['item_class'], count($run));
        $total++;
    }
}

echo "\n$total collection block(s) wired\n";
