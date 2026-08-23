<?php

namespace Database\Seeders;

use App\Models\CaseStudy;
use App\Models\JobOpening;
use App\Models\Page;
use App\Models\Post;
use App\Models\Service;
use Illuminate\Database\Seeder;

/**
 * Gives each record its own copy of the detail-page content.
 *
 * The export only ever showed one service, one case study and so on, so those
 * pages' copy sits in page sections. Copying it onto every record means each one
 * opens in the dashboard with something real to edit instead of an empty form,
 * and the pages keep rendering exactly what they rendered before.
 */
class DetailContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedServices();
        $this->seedCaseStudies();
        $this->seedPosts();
        $this->seedJobs();
    }

    /** A page section's field value, or null. */
    private function field(string $pageSlug, string $section, string $key): ?string
    {
        $page = Page::with('sections')->where('slug', $pageSlug)->first();
        $value = data_get($page?->section($section), $key . '.value');

        return filled($value) ? (string) $value : null;
    }

    private function seedServices(): void
    {
        $heading = $this->field('service-details', 'service_details_hero', 'hero_title');
        $intro = $this->field('service-details', 'service_details_hero', 'hero_description');

        foreach (Service::all() as $service) {
            $service->forceFill([
                // the record's own title wins; the section value is only a shape
                'hero_heading' => $service->hero_heading ?: ($service->title ?: $heading),
                'hero_intro' => $service->hero_intro ?: $intro,
                'excerpt' => $service->excerpt ?: $intro,
            ])->save();
        }
    }

    private function seedCaseStudies(): void
    {
        $client = $this->field('case-study-details', 'case_study_info', 'client_name');
        $date = $this->field('case-study-details', 'case_study_info', 'date_value');
        $services = $this->field('case-study-details', 'case_study_info', 'services_value');

        foreach (CaseStudy::all() as $study) {
            $study->forceFill([
                'client' => $study->client ?: $client,
                'duration' => $study->duration ?: $date,
                'category' => $study->category ?: $services,
            ])->save();
        }
    }

    private function seedPosts(): void
    {
        $author = $this->field('blog-details', 'blog_details_hero', 'author_name');

        foreach (Post::all() as $post) {
            $post->forceFill([
                'author_name' => $post->author_name ?: $author,
            ])->save();
        }
    }

    private function seedJobs(): void
    {
        $summary = $this->field('career-details', 'job_details', 'body_paragraph_1');

        foreach (JobOpening::all() as $job) {
            $job->forceFill([
                'summary' => $job->summary ?: $summary,
            ])->save();
        }
    }
}
