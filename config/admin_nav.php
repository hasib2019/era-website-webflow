<?php

/*
|--------------------------------------------------------------------------
| Dashboard navigation
|--------------------------------------------------------------------------
| Groups render in this order. Each item names the permission that reveals it,
| so a role without that permission never sees the link. `icon` maps to a path
| in resources/views/admin/partials/icon.blade.php.
*/

return [
    'Overview' => [
        ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'permission' => 'dashboard.view', 'icon' => 'grid'],
    ],

    'Site content' => [
        ['label' => 'Pages', 'route' => 'admin.pages.index', 'permission' => 'pages.view', 'icon' => 'document'],
        ['label' => 'Navigation', 'route' => 'admin.menus.index', 'permission' => 'menus.manage', 'icon' => 'bars'],
        ['label' => 'Media library', 'route' => 'admin.media.index', 'permission' => 'media.view', 'icon' => 'photo'],
    ],

    'Collections' => [
        ['label' => 'Services', 'route' => 'admin.services.index', 'permission' => 'services.manage', 'icon' => 'sparkles'],
        ['label' => 'Case studies', 'route' => 'admin.case-studies.index', 'permission' => 'case-studies.manage', 'icon' => 'briefcase'],
        ['label' => 'Blog posts', 'route' => 'admin.posts.index', 'permission' => 'posts.manage', 'icon' => 'newspaper'],
        ['label' => 'Job openings', 'route' => 'admin.jobs.index', 'permission' => 'jobs.manage', 'icon' => 'briefcase'],
        ['label' => 'Testimonials', 'route' => 'admin.testimonials.index', 'permission' => 'testimonials.manage', 'icon' => 'chat'],
        ['label' => 'Team', 'route' => 'admin.team.index', 'permission' => 'team.manage', 'icon' => 'users'],
        ['label' => 'Clients', 'route' => 'admin.clients.index', 'permission' => 'clients.manage', 'icon' => 'building'],
        ['label' => 'FAQs', 'route' => 'admin.faqs.index', 'permission' => 'faqs.manage', 'icon' => 'question'],
        ['label' => 'Counters', 'route' => 'admin.stats.index', 'permission' => 'stats.manage', 'icon' => 'chart'],
        ['label' => 'Changelog', 'route' => 'admin.changelog.index', 'permission' => 'changelog.manage', 'icon' => 'clock'],
    ],

    'Inbox' => [
        ['label' => 'Messages', 'route' => 'admin.messages.index', 'permission' => 'messages.view', 'icon' => 'envelope'],
        ['label' => 'Applications', 'route' => 'admin.applications.index', 'permission' => 'applications.view', 'icon' => 'document'],
        ['label' => 'Subscribers', 'route' => 'admin.subscribers.index', 'permission' => 'subscribers.view', 'icon' => 'at'],
    ],

    'Administration' => [
        ['label' => 'Admin users', 'route' => 'admin.users.index', 'permission' => 'users.view', 'icon' => 'user'],
        ['label' => 'Roles', 'route' => 'admin.roles.index', 'permission' => 'roles.manage', 'icon' => 'lock'],
        ['label' => 'Activity log', 'route' => 'admin.activity.index', 'permission' => 'activity.view', 'icon' => 'chart'],
        ['label' => 'Settings', 'route' => 'admin.settings.edit', 'permission' => 'settings.manage', 'icon' => 'cog'],
    ],
];
