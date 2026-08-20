<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

/**
 * Serves the public marketing site.
 *
 * The views are the converted Webflow export; content becomes database-driven
 * one section at a time, so a route that has not been wired to a model yet still
 * renders the markup the template shipped with.
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
        return view('site.pages.service-details', compact('slug'));
    }

    public function caseStudies(): View
    {
        return view('site.pages.case-studies');
    }

    public function caseStudyDetails(string $slug): View
    {
        return view('site.pages.case-study-details', compact('slug'));
    }

    public function blog(): View
    {
        return view('site.pages.blog');
    }

    public function blogDetails(string $slug): View
    {
        return view('site.pages.blog-details', compact('slug'));
    }

    public function career(): View
    {
        return view('site.pages.career');
    }

    public function careerDetails(string $slug): View
    {
        return view('site.pages.career-details', compact('slug'));
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
