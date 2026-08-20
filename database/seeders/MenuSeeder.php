<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

/**
 * The three menus the template renders: the top bar, the mega-menu panel behind
 * it, and the footer column. Pricing and Terms & Conditions are absent because
 * those two pages were dropped from the project.
 */
class MenuSeeder extends Seeder
{
    private const MENUS = [
        'primary' => [
            'name' => 'Primary navigation',
            'description' => 'The links shown across the top bar.',
            'items' => [
                ['home', '/'],
                ['about us', '/about'],
                ['Services', '/services'],
                ['Case study', '/case-studies'],
                ['Contact', '/contact'],
            ],
        ],
        'mega' => [
            'name' => 'Mega menu',
            'description' => 'The full-screen panel opened from the menu button.',
            'items' => [
                ['Home', '/'],
                ['About', '/about'],
                ['Contact', '/contact'],
                ['Services', '/services'],
                ['Services Details', '/services/search-engine-optimization'],
                ['Why Choose Us', '/why-choose-us'],
                ['Case Study', '/case-studies'],
                ['Case Study Details', '/case-studies/event-planning-and-management'],
                ['Career', '/career'],
                ['Career  Details', '/career/brand-expert'],
                ['Blog', '/blog'],
                ['Blog Details', '/blog/navigating-search-algorithms-for-regional-impact'],
                ['FAQ', '/faq'],
                ['404 Error', '/404'],
            ],
        ],
        'footer' => [
            'name' => 'Footer links',
            'description' => 'The PAGES column in the footer.',
            'items' => [
                ['Home', '/'],
                ['About Us', '/about'],
                ['Service', '/services'],
                ['Case Study', '/case-studies'],
                ['Blog', '/blog'],
                ['Why Choose Us', '/why-choose-us'],
                ['Career', '/career'],
                ['Contact Us', '/contact'],
                ['FAQ', '/faq'],
                ['404 Error Page', '/404'],
                ['Style Guide', '/style-guide'],
                ['Changelog', '/changelog'],
            ],
        ],
    ];

    public function run(): void
    {
        foreach (self::MENUS as $slug => $definition) {
            $menu = Menu::updateOrCreate(
                ['slug' => $slug],
                ['name' => $definition['name'], 'description' => $definition['description']],
            );

            foreach ($definition['items'] as $order => [$label, $url]) {
                MenuItem::updateOrCreate(
                    ['menu_id' => $menu->id, 'label' => $label],
                    [
                        'url' => $url,
                        'column_heading' => $slug === 'footer' ? 'PAGES' : null,
                        'sort_order' => $order,
                        'is_active' => true,
                    ],
                );
            }
        }
    }
}
