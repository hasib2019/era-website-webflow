<?php

/*
|--------------------------------------------------------------------------
| Export page file -> site path
|--------------------------------------------------------------------------
| The Webflow export links page to page by filename. tools/lib_rewrite.php
| rewrites those out of the markup on the way into Blade, and Content::url()
| applies the same map at render time, because a link stored in a page section
| is still the export's own href until an editor changes it.
|
| One table, read from both sides: a route renamed in only one of them would
| leave the markup and the dashboard pointing at different pages.
| Detail pages keep the slugs the export already linked to.
*/

return [
    'home.html' => '/',
    'about.html' => '/about',
    'service.html' => '/services',
    'services-details.html' => '/services/search-engine-optimization',
    'casestudy.html' => '/case-studies',
    'case-study-details.html' => '/case-studies/event-planning-and-management',
    'blog.html' => '/blog',
    'blog-details.html' => '/blog/navigating-search-algorithms-for-regional-impact',
    'career.html' => '/career',
    'career-details.html' => '/career/brand-expert',
    'contact-us.html' => '/contact',
    'faq.html' => '/faq',
    'why-choose-us.html' => '/why-choose-us',
    'changelog.html' => '/changelog',
    'style-guide.html' => '/style-guide',
    '404.html' => '/404',
];
