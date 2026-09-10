<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

/**
 * The two menus the template renders: the top bar and the footer columns.
 *
 * The top bar used to be two menus — `primary` for the flat row and `mega` for
 * the panel behind a hard-coded "Other page" toggle. They are one menu now: an
 * item of type `dropdown` carries its own children, so a panel can sit at any
 * position in the row and both kinds are built on the same screen.
 * 2026_01_01_001800 folds an existing install's `mega` rows in; this file is
 * what a fresh one gets.
 *
 * Pricing and Terms & Conditions are absent because those two pages were
 * dropped from the project.
 *
 * Idempotent by (menu, parent, label): a row that already exists is left alone,
 * so re-seeding never overwrites a label, URL or order someone has since edited
 * in the dashboard. Deleting a link here and re-seeding brings it back — that
 * is the point of a seed file, not a bug.
 */
class MenuSeeder extends Seeder
{
    /**
     * label, url, and for a dropdown the children it opens.
     *
     * A child's third element is its column heading. Headings are free text:
     * naming a new one grows a column in the panel, emptying one removes it.
     */
    private const MENUS = [
        'primary' => [
            'name' => 'Primary navigation',
            'description' => 'The row across the top bar, including any dropdown panels.',
            'items' => [
                // Labels as the top bar shows them: since wire_chrome.php the
                // Primary menu drives both the visible link row and the overlay
                // menu, and neither has a text-transform to tidy casing.
                ['Home', '/'],
                ['About', '/about'],
                ['Services', '/services'],
                ['Case study', '/case-studies'],
                ['Contact', '/contact'],
                ['Other page', '#', [
                    ['Home', '/', 'Column 1'],
                    ['About', '/about', 'Column 1'],
                    ['Contact', '/contact', 'Column 1'],
                    ['Services', '/services', 'Column 1'],
                    ['Services Details', '/services/search-engine-optimization', 'Column 1'],
                    ['Why Choose Us', '/why-choose-us', 'Column 1'],
                    ['Case Study', '/case-studies', 'Column 1'],
                    ['Case Study Details', '/case-studies/event-planning-and-management', 'Column 2'],
                    ['Career', '/career', 'Column 2'],
                    // two non-breaking spaces, as the export had them; retyping
                    // these with ordinary spaces makes tools/verify.php fail
                    ["Career\u{00A0}\u{00A0}Details", '/career/brand-expert', 'Column 2'],
                    ['Blog', '/blog', 'Column 2'],
                    ['Blog Details', '/blog/navigating-search-algorithms-for-regional-impact', 'Column 2'],
                    ['FAQ', '/faq', 'Column 3'],
                    ['404 Error', '/404', 'Column 3'],
                ]],
            ],
        ],

        'footer' => [
            'name' => 'Footer links',
            'description' => 'The link columns in the footer.',
            'items' => [
                ['Home', '/', null, 'PAGES'],
                ['About Us', '/about', null, 'PAGES'],
                ['Service', '/services', null, 'PAGES'],
                ['Case Study', '/case-studies', null, 'PAGES'],
                ['Blog', '/blog', null, 'PAGES'],
                ['Why Choose Us', '/why-choose-us', null, 'COMPANY'],
                ['Career', '/career', null, 'COMPANY'],
                ['Contact Us', '/contact', null, 'COMPANY'],
                ['FAQ', '/faq', null, 'COMPANY'],
                ['404 Error Page', '/404', null, 'UTILITY'],
                ['Style Guide', '/style-guide', null, 'UTILITY'],
                ['Changelog', '/changelog', null, 'UTILITY'],
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
                // entries carry 2 to 4 elements, so read them positionally
                $children = $item[2] ?? null;

                $parent = $this->item(
                    $menu,
                    null,
                    $item[0],
                    $item[1],
                    $order,
                    $item[3] ?? null,
                    $children ? MenuItem::TYPE_DROPDOWN : MenuItem::TYPE_LINK,
                );

                foreach ($children ?? [] as $childOrder => $child) {
                    $this->item($menu, $parent->id, $child[0], $child[1], $childOrder, $child[2] ?? null);
                }
            }
        }
    }

    /** Creates the row if this menu/parent has no link by that label yet. */
    private function item(
        Menu $menu,
        ?int $parentId,
        string $label,
        string $url,
        int $order,
        ?string $heading = null,
        string $type = MenuItem::TYPE_LINK,
    ): MenuItem {
        return MenuItem::firstOrCreate(
            ['menu_id' => $menu->id, 'parent_id' => $parentId, 'label' => $label],
            [
                'type' => $type,
                'url' => $url,
                'column_heading' => $heading,
                'sort_order' => $order,
                'is_active' => true,
            ],
        );
    }
}
