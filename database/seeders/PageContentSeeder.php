<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Database\Seeder;

/**
 * Registers every public page and the editable bands it is made of, filled with
 * the copy the template shipped so the dashboard opens on real content.
 */
class PageContentSeeder extends Seeder
{
    public function run(): void
    {
        $file = database_path('data/pages.json');

        if (! is_file($file)) {
            $this->command->warn('database/data/pages.json missing — run: php tools/build_pages_json.php');

            return;
        }

        $pages = json_decode(file_get_contents($file), true) ?: [];

        foreach ($pages as $order => $definition) {
            $page = Page::updateOrCreate(
                ['slug' => $definition['slug']],
                [
                    'name' => $definition['name'],
                    'route_name' => $definition['route_name'],
                    'meta_title' => $definition['name'],
                    'is_published' => true,
                    'sort_order' => $order,
                ],
            );

            foreach ($definition['sections'] as $section) {
                PageSection::updateOrCreate(
                    ['page_id' => $page->id, 'key' => $section['key']],
                    [
                        'name' => $section['name'],
                        'content' => $section['content'],
                        'sort_order' => $section['sort_order'],
                        'is_visible' => true,
                    ],
                );
            }
        }
    }
}
