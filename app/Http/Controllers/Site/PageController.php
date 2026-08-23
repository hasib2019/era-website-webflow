<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\CaseStudy;
use App\Models\JobOpening;
use App\Models\Post;
use App\Models\Service;
use Illuminate\Contracts\View\View;

/**
 * Serves the public marketing site.
 *
 * The views are the converted Webflow export with their copy, images and
 * repeating cards bound to the CMS; anything not yet bound still renders the
 * value the template shipped with.
 */
class PageController extends Controller
{
    public function home(): View
    {
        return view('site.pages.home');
    }

    public function about(): View
    {
        return view('site.pages.about');
    }

    public function services(): View
    {
        return view('site.pages.services');
    }

    public function serviceDetails(string $slug): View
    {
        $service = Service::published()->where('slug', $slug)->firstOrFail();

        return view('site.pages.service-details', compact('service'));
    }

    public function caseStudies(): View
    {
        return view('site.pages.case-studies');
    }

    public function caseStudyDetails(string $slug): View
    {
        $caseStudy = CaseStudy::published()->where('slug', $slug)->firstOrFail();

        return view('site.pages.case-study-details', compact('caseStudy'));
    }

    public function blog(): View
    {
        return view('site.pages.blog');
    }

    public function blogDetails(string $slug): View
    {
        $post = Post::published()->where('slug', $slug)->firstOrFail();

        return view('site.pages.blog-details', compact('post'));
    }

    public function career(): View
    {
        return view('site.pages.career');
    }

    public function careerDetails(string $slug): View
    {
        $job = JobOpening::published()->where('slug', $slug)->firstOrFail();

        return view('site.pages.career-details', compact('job'));
    }

    public function contact(): View
    {
        return view('site.pages.contact');
    }

    public function faq(): View
    {
        return view('site.pages.faq');
    }

    public function whyChooseUs(): View
    {
        return view('site.pages.why-choose-us');
    }

    public function changelog(): View
    {
        return view('site.pages.changelog');
    }

    public function styleGuide(): View
    {
        return view('site.pages.style-guide');
    }
}
