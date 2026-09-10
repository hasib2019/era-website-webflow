<?php

/*
|--------------------------------------------------------------------------
| Section -> collection shortcuts
|--------------------------------------------------------------------------
| Most bands are part page fields and part collection: the "about us" band, for
| instance, has its caption and heading in the page editor while its four
| counters live in the stats table. Without a pointer the counters look like
| they simply are not editable, so each entry here adds a link from the section
| card in /admin/pages to the screen that owns the rest of it.
|
| Only list a band whose markup actually reads the collection. The FAQ
| accordions on /services and /contact, the changelog entries and the career
| benefits all still render static markup, so a link from those sections would
| send an editor to a screen where nothing they change reaches the page —
| exactly the confusion this file exists to remove.
|
| page slug => section key => [label, route, permission, note, query]
*/

$link = fn (string $what, string $route, string $permission, array $query = []) => [
    'label' => 'Add or edit the ' . $what,
    'route' => 'admin.' . $route . '.index',
    'permission' => $permission,
    'query' => $query,
    'note' => 'The ' . $what . ' below are their own collection, not page fields — add, remove and reorder them there.',
];

$counters = fn (string $scope) => [
    'label' => 'Edit the counters',
    'route' => 'admin.stats.index',
    'permission' => 'stats.manage',
    'query' => ['scope' => $scope],
    'note' => 'The numbers and their labels are counters, not page fields.',
];

$process = fn (string $scope) => [
    'label' => 'Edit the process steps',
    'route' => 'admin.process-steps.index',
    'permission' => 'process-steps.manage',
    'query' => ['scope' => $scope],
    'note' => 'The numbered steps below are their own collection, not page fields.',
];

/** The three about-page logo bands, which share the clients table by scope. */
$logos = fn (string $scope, string $what) => $link($what, 'clients', 'clients.manage', ['scope' => $scope]);

$services = fn () => $link('services', 'services', 'services.manage');
$caseStudies = fn () => $link('case studies', 'case-studies', 'case-studies.manage');
$posts = fn () => $link('blog posts', 'posts', 'posts.manage');
$jobs = fn () => $link('job openings', 'jobs', 'jobs.manage');
$testimonials = fn () => $link('testimonials', 'testimonials', 'testimonials.manage');

return [
    'home' => [
        'home_about_us' => $counters('home'),
        'home_services' => $services(),
        'home_case_study' => $caseStudies(),
        'home_process' => $process('home'),
        'home_testimonials' => $testimonials(),
        'home_latest_blog' => $posts(),
    ],

    'about' => [
        'about_us_info_stats' => $counters('about'),
        'core_values' => $link('core values', 'core-values', 'core-values.manage'),
        'our_team' => $link('team members', 'team', 'team.manage'),
        'our_partners' => $logos('partner', 'partners'),
        'our_clients' => $logos('client', 'client logos'),
        'certifications' => $logos('certification', 'certifications'),
        'awards' => $link('awards', 'awards', 'awards.manage'),
        'testimonials' => $testimonials(),
        'our_jobs' => $jobs(),
    ],

    'services' => [
        'service_list' => $services(),
        'about_us_stats' => $counters('service'),
        'our_process' => $process('service'),
        'our_clients' => $logos('client', 'client logos'),
    ],

    'service-details' => ['case_study' => $caseStudies()],

    'case-studies' => [
        'case_study_list' => $caseStudies(),
        'testimonials' => $testimonials(),
        'latest_blog' => $posts(),
    ],

    'case-study-details' => ['testimonial' => $testimonials()],

    'blog' => [
        'blog_featured' => $posts(),
        'blog_list' => $posts(),
    ],

    'blog-details' => ['latest_blog' => $posts()],

    'career' => [
        'career_stats' => $counters('career'),
        'career_testimonials' => $testimonials(),
        'career_jobs' => $jobs(),
    ],

    'career-details' => ['other_jobs' => $jobs()],

    'faq' => ['faq_accordion' => $link('questions', 'faqs', 'faqs.manage')],

    'why-choose-us' => [
        'our_process' => $process('why-choose-us'),
        'testimonials' => $testimonials(),
        'latest_blog' => $posts(),
    ],
];
