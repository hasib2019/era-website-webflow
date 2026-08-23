<?php

namespace Database\Seeders;

use App\Models\Benefit;
use App\Models\CaseStudy;
use App\Models\Client;
use App\Models\Faq;
use App\Models\JobOpening;
use App\Models\Media;
use App\Models\Post;
use App\Models\ProcessStep;
use App\Models\Service;
use App\Models\Stat;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Loads the collections the template shipped with, as extracted from the
 * original HTML by tools/extract_content.php, so a fresh install renders the
 * same pages the static export did.
 */
class ContentSeeder extends Seeder
{
    private array $data = [];

    private array $mediaByFilename = [];

    public function run(): void
    {
        $file = database_path('data/content.json');

        if (! is_file($file)) {
            $this->command->warn('database/data/content.json missing — run: php tools/extract_content.php');

            return;
        }

        $this->data = json_decode(file_get_contents($file), true) ?: [];
        $this->mediaByFilename = Media::pluck('id', 'filename')->all();

        $this->seedServices();
        $this->seedCaseStudies();
        $this->seedPosts();
        $this->seedTestimonials();
        $this->seedTeam();
        $this->seedClients();
        $this->seedJobs();
        $this->seedFaqs();
        $this->seedProcessAndStats();
        $this->seedBenefits();
    }

    private function mediaId(?string $filename): ?int
    {
        return $filename ? ($this->mediaByFilename[$filename] ?? null) : null;
    }

    private function rows(string $key): array
    {
        return $this->data[$key] ?? [];
    }

    private function seedServices(): void
    {
        foreach ($this->rows('services') as $row) {
            Service::updateOrCreate(
                ['slug' => Str::slug($row['title'])],
                [
                    'title' => $row['title'],
                    'counter' => $row['counter'],
                    'image_id' => $this->mediaId($row['image']),
                    'image_alt' => $row['image_alt'],
                    'sort_order' => $row['sort_order'],
                    'is_published' => true,
                ],
            );
        }
    }

    private function seedCaseStudies(): void
    {
        foreach ($this->rows('case_studies') as $row) {
            CaseStudy::updateOrCreate(
                ['slug' => Str::slug($row['title'])],
                [
                    'title' => $row['title'],
                    'subtitle' => $row['subtitle'],
                    'image_id' => $this->mediaId($row['image']),
                    'image_alt' => $row['image_alt'],
                    'sort_order' => $row['sort_order'],
                    'is_published' => true,
                ],
            );
        }
    }

    private function seedPosts(): void
    {
        foreach ($this->rows('posts') as $row) {
            // the meta line reads "Jul 10, 2024 / 6 min read"
            $date = $row['info'][0] ?? null;
            $read = $row['info'][1] ?? '';
            preg_match('/(\d+)/', $read, $m);

            Post::updateOrCreate(
                ['slug' => Str::slug($row['title'])],
                [
                    'title' => $row['title'],
                    'summary' => $row['summary'],
                    'image_id' => $this->mediaId($row['image']),
                    'image_alt' => $row['image_alt'],
                    'read_time' => (int) ($m[1] ?? 6),
                    'read_time_unit' => 'min read',
                    'is_featured' => (bool) $row['is_featured'],
                    'is_published' => true,
                    'published_at' => $date ? date('Y-m-d H:i:s', strtotime($date)) : now(),
                ],
            );
        }
    }

    private function seedTestimonials(): void
    {
        foreach ($this->rows('testimonials') as $row) {
            // the title line is "NAME - ROLE"
            [$author, $role] = array_pad(array_map('trim', explode(' - ', $row['author_line'], 2)), 2, '');

            Testimonial::updateOrCreate(
                ['author' => $author, 'company' => $row['company']],
                [
                    'role' => $role,
                    'quote' => $row['quote'],
                    'image_id' => $this->mediaId($row['image']),
                    'image_alt' => $row['image_alt'],
                    'sort_order' => $row['sort_order'],
                    'is_published' => true,
                ],
            );
        }
    }

    private function seedTeam(): void
    {
        foreach ($this->rows('team_members') as $row) {
            $socials = $row['socials'] ?? [];

            TeamMember::updateOrCreate(
                ['name' => $row['name'], 'sort_order' => $row['sort_order']],
                [
                    'image_id' => $this->mediaId($row['image']),
                    'image_alt' => $row['image_alt'],
                    'facebook_url' => $socials[0] ?? null,
                    'twitter_url' => $socials[1] ?? null,
                    'instagram_url' => $socials[2] ?? null,
                    'is_published' => true,
                ],
            );
        }
    }

    private function seedClients(): void
    {
        foreach ($this->rows('clients') as $row) {
            Client::updateOrCreate(
                ['name' => $row['name'], 'row_group' => $row['row_group']],
                [
                    'variant' => $row['variant'] ?? null,
                    'sort_order' => $row['sort_order'],
                    'is_published' => true,
                ],
            );
        }
    }

    private function seedJobs(): void
    {
        foreach ($this->rows('jobs') as $row) {
            JobOpening::updateOrCreate(
                ['slug' => Str::slug($row['title'])],
                [
                    'title' => $row['title'],
                    'location' => $row['location'],
                    'employment_type' => $row['employment_type'],
                    'sort_order' => $row['sort_order'],
                    'is_published' => true,
                ],
            );
        }
    }

    private function seedFaqs(): void
    {
        foreach ($this->rows('faqs') as $row) {
            Faq::updateOrCreate(
                ['question' => $row['question']],
                [
                    'answer' => $row['answer'],
                    'scope' => 'general',
                    'sort_order' => $row['sort_order'],
                    'is_published' => true,
                ],
            );
        }
    }

    private function seedProcessAndStats(): void
    {
        foreach ($this->rows('process_steps') as $row) {
            ProcessStep::updateOrCreate(
                ['scope' => $row['scope'], 'sort_order' => $row['sort_order']],
                [
                    'number' => $row['number'],
                    'title' => $row['title'],
                    'description' => $row['description'] ?: null,
                ],
            );
        }

        foreach ($this->rows('stats') as $row) {
            Stat::updateOrCreate(
                ['scope' => $row['scope'], 'sort_order' => $row['sort_order']],
                [
                    'value' => $row['value'],
                    'suffix' => $row['suffix'],
                    'suffix_html' => $row['suffix_html'] ?? null,
                    'label' => $row['label'],
                ],
            );
        }
    }

    private function seedBenefits(): void
    {
        $images = $this->rows('benefit_images');

        foreach ($this->rows('benefits') as $i => $row) {
            Benefit::updateOrCreate(
                ['scope' => $row['scope'], 'sort_order' => $row['sort_order']],
                [
                    'number' => $row['number'],
                    'title' => $row['title'],
                    'image_id' => $this->mediaId($images[$i] ?? null),
                ],
            );
        }
    }
}
