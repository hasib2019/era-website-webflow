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

    /*
     * The blocks below repeat models the pass already knows, on pages it did not
     * originally list. Left out, every one of them rendered the export's own
     * sample cards, so publishing or unpublishing a post, case study or job
     * changed nothing outside its own index page.
     */
    [
        // the single highlighted post at the top of /blog
        'views' => ['blog'],
        'item_class' => 'feature-blog-collection-item',
        'source' => "\App\Models\Post::published()->where('is_featured', true)->latestFirst()->take(1)->get()",
        'as' => 'post',
        'min' => 1,
        'text' => [
            'blog-title' => '$post->title',
            'blog-post-summary' => '$post->summary',
            // three nodes share this class: date, read time, unit
            'blog-info-text' => [
                "\$post->published_at?->format('M j, Y')",
                '$post->read_time',
                '$post->read_time_unit',
            ],
        ],
        'image' => "\$post->image?->url",
        'href' => "route('blog.show', \$post->slug)",
    ],
    [
        // "latest articles" strips
        'views' => ['home', 'why-choose-us', 'case-studies', 'blog-details'],
        'item_class' => 'blog-collection-item',
        'source' => "\App\Models\Post::published()->latestFirst()->take(2)->get()",
        'as' => 'post',
        'text' => [
            'blog-title' => '$post->title',
            'blog-post-summary' => '$post->summary',
            // three nodes share this class: date, read time, unit
            'blog-info-text' => [
                "\$post->published_at?->format('M j, Y')",
                '$post->read_time',
                '$post->read_time_unit',
            ],
            /*
             * Same three values, different class: these pages mark them up as
             * `font-weight-medium` while /blog uses `blog-info-text`. Mapping
             * both is safe — whichever the card does not contain is a no-op.
             */
            'font-weight-medium' => [
                "\$post->published_at?->format('M j, Y')",
                '$post->read_time',
                '$post->read_time_unit',
            ],
        ],
        'image' => "\$post->image?->url",
        'image_class' => 'blog-image',
        'href' => "route('blog.show', \$post->slug)",
    ],
    [
        'views' => ['home', 'service-details'],
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
        'views' => ['about', 'career-details'],
        'item_class' => 'job-collection-item',
        'source' => "\App\Models\JobOpening::published()->ordered()->get()",
        'as' => 'job',
        'text' => [
            'job-item-title' => '$job->title',
            // two nodes share this class: where the role is, and its contract
            'job-info-text' => ['$job->location', '$job->employment_type'],
        ],
        'href' => "route('career.show', \$job->slug)",
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
        /*
         * A class can carry several values in one card: a blog card prints
         * the date, the read time and its unit through three `blog-info-text`
         * nodes. An array maps them in document order; a plain string still
         * means "the first one", which is what every original entry expects.
         */
        foreach ((array) $expr as $nth) {
            $item = preg_replace(
                '#(<(?P<tag>[a-z][a-z0-9]*)[^>]*\sclass="' . preg_quote($class, '#') . '"[^>]*>)(?!\{\{)(.*?)(</(?P=tag)>)#s',
                '$1{{ ' . $nth . ' }}$4',
                $item,
                1
            );
        }
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

        /*
         * Idempotency guard. This pass normally runs once, straight after
         * convert.php, on markup with no loops in it yet; running it again
         * would wrap an existing @foreach in another one. Skipping a block
         * whose loop is already present is what makes it safe to run alone.
         */
        $opener = '@foreach (' . $config['source'] . ' as $' . $config['as'] . ')';
        if (str_contains($html, $opener)) {
            printf("  %-16s %-30s already wired\n", $view, $config['item_class']);
            continue;
        }

        $run = item_run($html, $config['item_class']);
        $min = $config['min'] ?? 2;

        if (count($run) < $min) {
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
