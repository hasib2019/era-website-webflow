<?php

/*
|--------------------------------------------------------------------------
| Section -> collection shortcuts
|--------------------------------------------------------------------------
| Some bands are part page fields and part collection: the "about us" band, for
| instance, has its caption and heading in the page editor while its four
| counters live in the stats table. Without a pointer the counters look like
| they simply are not editable, so each entry here adds a link from the section
| card in /admin/pages to the screen that owns the rest of it.
|
| page slug => section key => [label, route, permission, query]
*/

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

return [
    'home' => [
        'home_about_us' => $counters('home'),
        'home_process' => $process('home'),
    ],
    'about' => ['about_us_info_stats' => $counters('about')],
    'services' => [
        'about_us_stats' => $counters('service'),
        'our_process' => $process('service'),
    ],
    'career' => ['career_stats' => $counters('career')],
    'why-choose-us' => ['our_process' => $process('why-choose-us')],
];
