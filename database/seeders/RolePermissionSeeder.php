<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /** group => [slug => label] */
    private const PERMISSIONS = [
        'Dashboard' => [
            'dashboard.view' => 'View dashboard',
        ],
        'Pages' => [
            'pages.view' => 'View pages',
            'pages.edit' => 'Edit page content',
        ],
        'Content' => [
            'services.manage' => 'Manage services',
            'case-studies.manage' => 'Manage case studies',
            'posts.manage' => 'Manage blog posts',
            'jobs.manage' => 'Manage job openings',
            'testimonials.manage' => 'Manage testimonials',
            'team.manage' => 'Manage team members',
            'clients.manage' => 'Manage clients',
            'faqs.manage' => 'Manage FAQs',
            'stats.manage' => 'Manage the animated counters',
            'changelog.manage' => 'Manage changelog',
        ],
        'Media' => [
            'media.view' => 'View media library',
            'media.upload' => 'Upload media',
            'media.delete' => 'Delete media',
        ],
        'Navigation' => [
            'menus.manage' => 'Manage menus',
        ],
        'Submissions' => [
            'messages.view' => 'View contact messages',
            'messages.manage' => 'Update or delete messages',
            'applications.view' => 'View job applications',
            'subscribers.view' => 'View subscribers',
        ],
        'Settings' => [
            'settings.manage' => 'Manage site settings',
        ],
        'Administration' => [
            'users.view' => 'View admin users',
            'users.manage' => 'Create, edit and remove admin users',
            'roles.manage' => 'Manage roles and permissions',
            'activity.view' => 'View activity log',
        ],
    ];

    /** Roles shipped with the install; super-admin implicitly holds everything. */
    private const ROLES = [
        'super-admin' => [
            'name' => 'Super Admin',
            'description' => 'Full access, including user and role management.',
            'permissions' => '*',
        ],
        'admin' => [
            'name' => 'Administrator',
            'description' => 'Manages all site content, media and submissions.',
            'permissions' => [
                'dashboard.view', 'pages.view', 'pages.edit',
                'services.manage', 'case-studies.manage', 'posts.manage', 'jobs.manage',
                'testimonials.manage', 'team.manage', 'clients.manage', 'faqs.manage',
                'changelog.manage', 'stats.manage', 'media.view', 'media.upload', 'media.delete',
                'menus.manage', 'messages.view', 'messages.manage',
                'applications.view', 'subscribers.view', 'settings.manage',
            ],
        ],
        'editor' => [
            'name' => 'Editor',
            'description' => 'Edits page content and collections but cannot change settings.',
            'permissions' => [
                'dashboard.view', 'pages.view', 'pages.edit',
                'services.manage', 'case-studies.manage', 'posts.manage', 'jobs.manage',
                'testimonials.manage', 'team.manage', 'clients.manage', 'faqs.manage',
                'changelog.manage', 'stats.manage', 'media.view', 'media.upload',
            ],
        ],
        'author' => [
            'name' => 'Author',
            'description' => 'Writes blog posts and uploads the images they need.',
            'permissions' => [
                'dashboard.view', 'posts.manage', 'media.view', 'media.upload',
            ],
        ],
        'viewer' => [
            'name' => 'Viewer',
            'description' => 'Read-only access to the dashboard and submissions.',
            'permissions' => [
                'dashboard.view', 'pages.view', 'media.view',
                'messages.view', 'applications.view', 'subscribers.view',
            ],
        ],
    ];

    public function run(): void
    {
        foreach (self::PERMISSIONS as $group => $items) {
            foreach ($items as $slug => $name) {
                Permission::updateOrCreate(['slug' => $slug], ['name' => $name, 'group' => $group]);
            }
        }

        $all = Permission::pluck('id', 'slug');

        foreach (self::ROLES as $slug => $definition) {
            $role = Role::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $definition['name'],
                    'description' => $definition['description'],
                    'is_system' => true,
                ],
            );

            $ids = $definition['permissions'] === '*'
                ? $all->values()->all()
                : $all->only($definition['permissions'])->values()->all();

            $role->permissions()->sync($ids);
        }
    }
}
