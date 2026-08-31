<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\CaseStudy;
use App\Models\JobOpening;
use App\Models\Page;
use App\Models\Post;
use App\Models\Service;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFactory;

/**
 * Serves the public marketing site.
 *
 * The views are the converted Webflow export with their copy, images and
 * repeating cards bound to the CMS; anything not yet bound still renders the
 * value the template shipped with.
 *
 * Every route goes through render(), which enforces the page's published flag.
 * Calling view() directly bypasses that, which is how unpublishing a page in
 * the dashboard used to leave it happily serving 200s.
 */
class PageController extends Controller
{
    /**
     * Renders a page after checking the dashboard has it published.
     *
     * The view name and the `pages` row share a slug for all 15 pages, so the
     * one argument covers both.
     *
     * Signed-in staff still see unpublished pages, so "unpublish, fix, publish"
     * does not mean editing blind. Everyone else gets a 404 — a 404 rather than
     * a notice, because an unpublished page should not advertise that it exists.
     */
    private function render(string $slug, array $data = []): View
    {
        $published = Page::where('slug', $slug)->value('is_published');

        // A missing row means the page was never seeded, not that it was
        // withdrawn; failing open keeps the route serving instead of stranding
        // it behind a flag nobody can reach.
        abort_if($published !== null && ! $published && ! auth()->check(), 404);

        // the head composer reads this to cascade meta description and og:image
        // from the page's own SEO fields down to the site defaults
        ViewFactory::share('cmsPageSlug', $slug);

        return view('site.pages.' . $slug, $data);
    }

    public function home(): View
    {
        return $this->render('home');
    }

    public function about(): View
    {
        return $this->render('about');
    }

    public function services(): View
    {
        return $this->render('services');
    }

    public function serviceDetails(string $slug): View
    {
        $service = Service::published()->where('slug', $slug)->firstOrFail();

        return $this->render('service-details', compact('service'));
    }

    public function caseStudies(): View
    {
        return $this->render('case-studies');
    }

    public function caseStudyDetails(string $slug): View
    {
        $caseStudy = CaseStudy::published()->where('slug', $slug)->firstOrFail();

        return $this->render('case-study-details', compact('caseStudy'));
    }

    public function blog(): View
    {
        return $this->render('blog');
    }

    public function blogDetails(string $slug): View
    {
        $post = Post::published()->where('slug', $slug)->firstOrFail();

        return $this->render('blog-details', compact('post'));
    }

    public function career(): View
    {
        return $this->render('career');
    }

    public function careerDetails(string $slug): View
    {
        $job = JobOpening::published()->where('slug', $slug)->firstOrFail();

        return $this->render('career-details', compact('job'));
    }

    public function contact(): View
    {
        return $this->render('contact');
    }

    public function faq(): View
    {
        return $this->render('faq');
    }

    public function whyChooseUs(): View
    {
        return $this->render('why-choose-us');
    }

    public function changelog(): View
    {
        return $this->render('changelog');
    }

    public function styleGuide(): View
    {
        return $this->render('style-guide');
    }
}
