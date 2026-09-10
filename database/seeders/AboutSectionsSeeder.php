<?php

namespace Database\Seeders;

use App\Models\Award;
use App\Models\Client;
use App\Models\CoreValue;
use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Database\Seeder;

/**
 * The four about-page bands ERA asked for: core values, partners,
 * certifications & membership, and awards & achievements.
 *
 * PageContentSeeder reads database/data/pages.json, which tools/build_pages_json.php
 * regenerates from the export — so these sections are registered here instead,
 * where a re-extraction cannot drop them.
 *
 * Idempotent throughout. Section fields already present keep the value someone
 * has since edited, and the collection rows are matched on their own title, so
 * re-running never duplicates a row or undoes a dashboard change.
 */
class AboutSectionsSeeder extends Seeder
{
    /** section key => [name, fields] */
    private const SECTIONS = [
        'core_values' => ['Core Values', [
            'caption' => 'CORE VALUES',
            'heading' => 'THE PRINCIPLES BEHIND EVERY ENGAGEMENT',
        ]],
        'our_partners' => ['Our Partners', [
            'caption' => 'OUR PARTNERS',
            'heading' => 'TECHNOLOGY PARTNERSHIPS THAT EXTEND WHAT WE DELIVER',
        ]],
        'certifications' => ['Certifications & Membership', [
            'caption' => 'CERTIFICATIONS & MEMBERSHIP',
            'heading' => 'THE STANDARDS WE HOLD AND THE BODIES WE BELONG TO',
        ]],
        'awards' => ['Awards & Achievements', [
            'caption' => 'AWARDS & ACHIEVEMENTS',
            'heading' => 'RECOGNISED FOR THE WORK WE DELIVER',
        ]],
    ];

    /**
     * Every about section in page order.
     *
     * The four new bands sit between ones PageContentSeeder had already
     * numbered 0-7, so the whole page is renumbered rather than squeezed —
     * otherwise the dashboard lists the editor's sections in an order that no
     * longer matches what they see on the page.
     */
    private const ORDER = [
        'about_hero',
        'about_us_info_stats',
        'our_mission',
        'core_values',
        'our_team',
        'our_partners',
        'our_clients',
        'certifications',
        'awards',
        'testimonials',
        'our_jobs',
        'cta',
    ];

    /** The five values ERA supplied, in their order. */
    private const CORE_VALUES = [
        ['1', 'Integrity'],
        ['2', 'Quality & Security'],
        ['3', 'Innovation'],
        ['4', 'Professionalism'],
        ['5', 'Partnership Mindset'],
    ];

    /** The four awards ERA supplied. */
    private const AWARDS = [
        ['ISLQ Award', '2017'],
        ['Manthan Award', '2017'],
        ['National ICT Award', '2017'],
        ['NPQ Excellence Award', '2017'],
    ];

    public function run(): void
    {
        $page = Page::where('slug', 'about')->first();

        if (! $page) {
            $this->command->warn('about page missing — run PageContentSeeder first');

            return;
        }

        $this->seedSections($page);
        $this->seedCoreValues();
        $this->seedAwards();
        $this->seedPartners();
    }

    private function seedSections(Page $page): void
    {
        foreach (self::SECTIONS as $key => [$name, $fields]) {
            $section = PageSection::firstOrNew(['page_id' => $page->id, 'key' => $key]);

            $content = (array) ($section->content ?? []);

            foreach ($fields as $field => $value) {
                // a field that exists already may hold an edit; leave it alone
                $content[$field] ??= ['type' => 'text', 'value' => $value];
            }

            $section->fill([
                'name' => $section->name ?: $name,
                'content' => $content,
                'is_visible' => $section->exists ? $section->is_visible : true,
            ])->save();
        }

        foreach (self::ORDER as $order => $key) {
            PageSection::where('page_id', $page->id)->where('key', $key)->update(['sort_order' => $order]);
        }
    }

    private function seedCoreValues(): void
    {
        foreach (self::CORE_VALUES as $index => [$number, $title]) {
            CoreValue::firstOrCreate(
                ['title' => $title],
                ['number' => $number, 'sort_order' => $index, 'is_published' => true],
            );
        }
    }

    private function seedAwards(): void
    {
        foreach (self::AWARDS as $index => [$title, $year]) {
            Award::firstOrCreate(
                ['title' => $title],
                ['year' => $year, 'sort_order' => $index, 'is_published' => true],
            );
        }
    }

    /**
     * Partners and certifications share the clients table under `scope`.
     *
     * Every row that predates the scope column is a marquee client, so they are
     * pinned to 'client' before Oracle is added as the first partner.
     * Certifications are deliberately left empty: ERA has not supplied that
     * list yet, and the band hides itself until there is something to show.
     */
    private function seedPartners(): void
    {
        Client::whereNull('scope')->orWhere('scope', '')->update(['scope' => 'client']);

        Client::firstOrCreate(
            ['name' => 'Oracle', 'scope' => 'partner'],
            ['row_group' => 1, 'sort_order' => 0, 'is_published' => true],
        );
    }
}
