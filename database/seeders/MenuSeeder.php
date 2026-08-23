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
                ['Home', '/', 'Column 1'],
                ['About', '/about', 'Column 1'],
                ['Contact', '/contact', 'Column 1'],
                ['Services', '/services', 'Column 1'],
                ['Services Details', '/services/search-engine-optimization', 'Column 1'],
                ['Why Choose Us', '/why-choose-us', 'Column 1'],
                ['Case Study', '/case-studies', 'Column 1'],
                ['Case Study Details', '/case-studies/event-planning-and-management', 'Column 2'],
                ['Career', '/career', 'Column 2'],
                ["Career  Details", '/career/brand-expert', 'Column 2'],
                ['Blog', '/blog', 'Column 2'],
                ['Blog Details', '/blog/navigating-search-algorithms-for-regional-impact', 'Column 2'],
                ['FAQ', '/faq', 'Column 3'],
                ['404 Error', '/404', 'Column 3'],
            ],
        ],
        'footer' => [
            'name' => 'Footer links',
            'description' => 'The PAGES column in the footer.',
            'items' => [
                ['Home', '/', 'PAGES'],
                ['About Us', '/about', 'PAGES'],
                ['Service', '/services', 'PAGES'],
                ['Case Study', '/case-studies', 'PAGES'],
                ['Blog', '/blog', 'PAGES'],
                ['Why Choose Us', '/why-choose-us', 'COMPANY'],
                ['Career', '/career', 'COMPANY'],
                ['Contact Us', '/contact', 'COMPANY'],
                ['FAQ', '/faq', 'COMPANY'],
                ['404 Error Page', '/404', 'UTILITY'],
                ['Style Guide', '/style-guide', 'UTILITY'],
                ['Changelog', '/changelog', 'UTILITY'],
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

            foreach ($definition['items'] as $order => $item) {
                [$label, $url] = $item;

                MenuItem::updateOrCreate(
                    ['menu_id' => $menu->id, 'label' => $label],
                    [
                        'url' => $url,
                        'column_heading' => $item[2] ?? null,
                        'sort_order' => $order,
                        'is_active' => true,
                    ],
                );
            }
        }
    }
}
