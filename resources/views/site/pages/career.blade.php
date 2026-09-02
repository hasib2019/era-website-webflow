@extends('site.layouts.app')

@section('title', page_title('career', 'Career'))
@section('wf_page', '66485cbdb8fe5b2ef09ac0c6')
@section('wf_site', '66485cbdb8fe5b2ef09ac0c3')

@section('content')
@if(cms_section_visible('career', 'career_hero'))<header class="section-common-hero career-hero">
        <div class="container-main">
            <div class="common-hero-component">
                <div class="career-hero-content-wrap">
                    <div id="w-node-f0d9c460-c570-34cc-0d03-0f87ae0496d1-f09ac0ca" class="hero-title-wrap z-index-none">
                        <div class="title-move-animation"
                            style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                            <div class="text-gradient">
                                <h1 class="display-large">{{ cms('career.career_hero.hero_title_line_1', 'join our team') }}</h1>
                            </div>
                        </div>
                    </div>
                    <div id="w-node-f0d9c460-c570-34cc-0d03-0f87ae0496d6-f09ac0ca" class="hero-title-wrap">
                        <div class="title-move-animation"
                            style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                            <div class="text-gradient">
                                <div class="display-large">{{ cms('career.career_hero.hero_title_line_2', 'at inbound') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div data-w-id="e6782d73-26c4-d27d-f4e1-0a9c3cc106ba"
                    style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 1; transform-style: preserve-3d;"
                    class="career-hero-images-wrap">
                    <div class="career-hero-image-wrap"><img
                            src="/era/media/webflow/66a68172aeba377adf0f10ab_Career-hero-image-1.webp"
                            loading="lazy"
                            sizes="(max-width: 479px) 44vw, (max-width: 767px) 43vw, (max-width: 991px) 29vw, (max-width: 1439px) 30vw, (max-width: 1919px) 31vw, 33vw"
                            srcset="/era/media/webflow/66a68172aeba377adf0f10ab_Career-hero-image-1-p-500.webp 500w, /era/media/webflow/66a68172aeba377adf0f10ab_Career-hero-image-1.webp 786w"
                            alt="Career hero image" class="full-image"></div>
                    <div class="career-hero-image-wrap"><img
                            src="/era/media/webflow/66a681723cd4756ecef89fdf_Career-hero-image-2.webp"
                            loading="lazy"
                            sizes="(max-width: 479px) 44vw, (max-width: 767px) 43vw, (max-width: 991px) 29vw, (max-width: 1439px) 30vw, (max-width: 1919px) 31vw, 33vw"
                            srcset="/era/media/webflow/66a681723cd4756ecef89fdf_Career-hero-image-2-p-500.webp 500w, /era/media/webflow/66a681723cd4756ecef89fdf_Career-hero-image-2.webp 786w"
                            alt="Career hero image" class="full-image"></div>
                    <div class="career-hero-image-wrap hide-on-landscape"><img
                            src="/era/media/webflow/66a681724c8db4dac8c66374_Career-hero-image-3.webp"
                            loading="lazy"
                            sizes="(max-width: 767px) 100vw, (max-width: 991px) 29vw, (max-width: 1439px) 30vw, (max-width: 1919px) 31vw, 33vw"
                            srcset="/era/media/webflow/66a681724c8db4dac8c66374_Career-hero-image-3-p-500.webp 500w, /era/media/webflow/66a681724c8db4dac8c66374_Career-hero-image-3.webp 786w"
                            alt="Career hero image" class="full-image"></div>
                </div>
                <div class="career-hero-other-content-wrap">
                    <p data-w-id="59b40a6a-fcc7-e4e7-fcbf-7ed64a00f259"
                        style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 1; transform-style: preserve-3d;"
                        class="career-hero-para">{{ cms('career.career_hero.hero_paragraph', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tristique velit nulla  consectetur adipiscing elit. Tristique velit nulla at congue massa enim habitasse') }}</p>
                </div>
            </div>
        </div>
    </header>@endif
    @if(cms_section_visible('career', 'career_stats'))<section class="section-about-us-info">
        <div class="container-main">
            <div data-w-id="6fcd4e0b-3ff9-370e-81f6-229d1417e516" class="about-us-info-component"
                style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                <div class="about-us-info-wrap">
                    <div class="about-us-info-list">
                        @foreach (\App\Models\Stat::forScope('career')->ordered()->get() as $stat)<div class="about-us-info-item">
                            <div class="about-us-info-title">@include('site.partials.stat-counter', ['withBreak' => $loop->first])</div>
                            <p class="gray-text">{{ $stat->label }}</p>
                        </div>@endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>@endif
    @if(cms_section_visible('career', 'career_benefits'))<section class="section-our-benefits">
        <div class="container-main">
            <div class="our-benefits-component">
                <div class="section-title-element our-solution-title-element">
                    <div class="section-caption-wrap">
                        <div class="caption"
                            style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                            {{ cms('career.career_benefits.benefits_caption', 'BENEFITS') }}</div>
                    </div>
                    <div class="section-title-wrap">
                        <div class="text-align-right">
                            <div class="text-animation-block"
                                style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                                <h2>{{ cms('career.career_benefits.benefits_heading', 'Join our team to advance your career, collaborate on innovative projects, and help businesses achieve their goals.') }}</h2>
                                <div class="text-overlay" style="will-change: width, height; width: 0%;"></div>
                                <div class="text-overlay row-02" style="will-change: width, height; width: 0%;">
                                </div>
                                <div class="text-overlay row-03" style="will-change: width, height; width: 0%;">
                                </div>
                                <div class="text-overlay row-04" style="will-change: width, height; width: 0%;">
                                </div>
                                <div class="text-overlay row-05" style="will-change: width, height; width: 0%;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div data-w-id="80e3a50d-1ce9-8979-3d82-52af295f1175"
                    style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 1; transform-style: preserve-3d;"
                    class="our-benefits-element">
                    <div class="our-benefits-item margin-left-none">
                        <div class="our-process-item-title">Marketing Plan</div>
                        <div class="process-counting-wrap">
                            <div>1</div>
                        </div>
                    </div>
                    <div class="our-benefits-image-item"><img
                            src="/era/media/webflow/66a6836c3d2c836983ada19c_Our-benefits-image-1.webp"
                            loading="lazy"
                            sizes="(max-width: 479px) 46vw, (max-width: 767px) 45vw, (max-width: 991px) 46vw, 26vw"
                            srcset="/era/media/webflow/66a6836c3d2c836983ada19c_Our-benefits-image-1-p-500.webp 500w, /era/media/webflow/66a6836c3d2c836983ada19c_Our-benefits-image-1.webp 684w"
                            alt="Our benefits image" class="full-image"></div>
                    <div class="our-benefits-item">
                        <div class="our-process-item-title">Execution</div>
                        <div class="process-counting-wrap">
                            <div>2</div>
                        </div>
                    </div>
                    <div class="our-benefits-image-item"><img
                            src="/era/media/webflow/66a6836c97a13a4a180486c0_Our-benefits-image-2.webp"
                            loading="lazy"
                            sizes="(max-width: 479px) 46vw, (max-width: 767px) 45vw, (max-width: 991px) 46vw, 26vw"
                            srcset="/era/media/webflow/66a6836c97a13a4a180486c0_Our-benefits-image-2-p-500.webp 500w, /era/media/webflow/66a6836c97a13a4a180486c0_Our-benefits-image-2.webp 684w"
                            alt="Our benefits image" class="full-image"></div>
                    <div class="our-benefits-image-item margin-left-none"><img
                            src="/era/media/webflow/66a6836cde55ad37d6dcd116_Our-benefits-image-3.webp"
                            loading="lazy"
                            sizes="(max-width: 479px) 46vw, (max-width: 767px) 45vw, (max-width: 991px) 46vw, 26vw"
                            srcset="/era/media/webflow/66a6836cde55ad37d6dcd116_Our-benefits-image-3-p-500.webp 500w, /era/media/webflow/66a6836cde55ad37d6dcd116_Our-benefits-image-3.webp 684w"
                            alt="Our benefits image" class="full-image"></div>
                    <div class="our-benefits-item">
                        <div class="our-process-item-title">Growth &amp; Scale</div>
                        <div class="process-counting-wrap">
                            <div>3</div>
                        </div>
                    </div>
                    <div class="our-benefits-image-item"><img
                            src="/era/media/webflow/66a6836c50dc9af6975c04a7_Our-benefits-image-4.webp"
                            loading="lazy"
                            sizes="(max-width: 479px) 46vw, (max-width: 767px) 45vw, (max-width: 991px) 46vw, 26vw"
                            srcset="/era/media/webflow/66a6836c50dc9af6975c04a7_Our-benefits-image-4-p-500.webp 500w, /era/media/webflow/66a6836c50dc9af6975c04a7_Our-benefits-image-4.webp 684w"
                            alt="Our benefits image" class="full-image"></div>
                    <div class="our-benefits-item">
                        <div class="our-process-item-title">Growth &amp; Scale</div>
                        <div class="process-counting-wrap">
                            <div>4</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="horizontal-line-wrap">
            <div class="horizontal-line"
                style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
            </div>
        </div>
    </section>@endif
    @if(cms_section_visible('career', 'career_testimonials'))<section class="section-testimonial">
        <div class="container-main">
            <div class="testimonial-component">
                <h2 class="caption"
                    style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                    {{ cms('career.career_testimonials.testimonials_caption', 'TESTIMONIALS') }}</h2>
                <div data-w-id="afebf228-b705-b23f-c6fe-3b4a36c0203b" class="testimonial-element-wrap"
                    style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                    <div data-current="Tab 3" data-easing="ease-in-out-quad" data-duration-in="350"
                        data-duration-out="350" class="testimonial-tabs w-tabs">
                        <div id="w-node-afebf228-b705-b23f-c6fe-3b4a36c0203d-36c02036"
                            class="testimonial-tabs-menu w-tab-menu" role="tablist">@php($activeTab = min(2, \App\Models\Testimonial::published()->count() - 1))@foreach (\App\Models\Testimonial::published()->ordered()->get() as $testimonial)<a data-w-tab="Tab {{ $loop->iteration }}"
                                class="testimonial-content-wrap w-inline-block w-tab-link{{ $loop->index === $activeTab ? ' w--current' : '' }}" tabindex="-1"
                                id="w-tabs-0-data-w-tab-{{ $loop->index }}" href="#w-tabs-0-data-w-pane-{{ $loop->index }}" role="tab"
                                aria-controls="w-tabs-0-data-w-pane-{{ $loop->index }}" aria-selected="{{ $loop->index === $activeTab ? 'true' : 'false' }}">
                                <div class="testimonial-content-inner">
                                    <div class="testimonial-title-wrap">
                                        <div class="testimonial-title">{{ $testimonial->author_line }} <span
                                                class="lowercase-regular">{{ $testimonial->company }}</span></div>
                                    </div>
                                    <div class="testimonial-description-wrap" style="width: 100%; height: 0px;">
                                        <div class="testimonial-description-inner">
                                            <blockquote class="testimonial-description">{{ $testimonial->quote }}</blockquote>
                                            <div class="testimonial-inside-image-parent">
                                                
                                                    <div class="testimonial-inside-image-wrap"><img loading="lazy"
                                                            src="{{ $testimonial->image?->url }}"
                                                            alt="{{ $testimonial->image_alt }}"
                                                            class="testimonial-inside-image">
                                                        <div class="testimonial-image-overlay"></div>
                                                    </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>@endforeach</div>
                        <div id="w-node-afebf228-b705-b23f-c6fe-3b4a36c02080-36c02036"
                            class="testimonial-tabs-image-element w-tab-content">
                            @foreach (\App\Models\Testimonial::published()->ordered()->get() as $testimonial)<div data-w-tab="Tab {{ $loop->iteration }}" class="testimonial-image-wrap w-tab-pane{{ $loop->index === $activeTab ? ' w--tab-active' : '' }}"
                                id="w-tabs-0-data-w-pane-{{ $loop->index }}" role="tabpanel" aria-labelledby="w-tabs-0-data-w-tab-0">
                                <div class="testimonial-image-parent">
                                    <div class="testimonial-image-inner"><img loading="lazy"
                                            src="{{ $testimonial->image?->url }}"
                                            alt="{{ $testimonial->image_alt }}"
                                            class="testimonial-image">
                                        <div class="testimonial-image-overlay"></div>
                                    </div>
                                </div>
                            </div>@endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="horizontal-line-wrap">
            <div class="horizontal-line"
                style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
            </div>
        </div>
    </section>@endif
    @if(cms_section_visible('career', 'career_jobs'))<section class="section-our-jobs">
        <div class="container-main">
            <div class="our-jobs-component">
                <div class="section-title-element">
                    <div class="section-caption-wrap">
                        <div class="caption"
                            style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                            {{ cms('career.career_jobs.jobs_caption', 'JOBS') }}</div>
                    </div>
                    <div class="section-title-wrap">
                        <div class="text-align-right">
                            <div class="text-animation-block"
                                style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                                <h2>{{ cms('career.career_jobs.jobs_heading', 'Opportunities to join our awesome team') }}</h2>
                                <div class="text-overlay" style="will-change: width, height; width: 0%;"></div>
                                <div class="text-overlay row-02" style="will-change: width, height; width: 0%;">
                                </div>
                                <div class="text-overlay row-03" style="will-change: width, height; width: 0%;">
                                </div>
                                <div class="text-overlay row-04" style="will-change: width, height; width: 0%;">
                                </div>
                                <div class="text-overlay row-05" style="will-change: width, height; width: 0%;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div data-w-id="25b49376-ad16-b58b-a6a0-b88ec3870d4c"
                    style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 1; transform-style: preserve-3d;"
                    class="jobs-collection-wrap">
                    <div class="w-dyn-list">
                        <div role="list" class="w-dyn-items">
                            @foreach (\App\Models\JobOpening::published()->ordered()->get() as $job)<div role="listitem" class="job-collection-item w-dyn-item">
                                <div class="job-item-inner">
                                    <div class="job-item-info-wrap">
                                        <div class="job-item-title" style="color: rgb(120, 120, 120);">{{ $job->title }}</div>
                                        <div class="job-info">
                                            <div class="job-info-text" style="color: rgb(120, 120, 120);">new york
                                            </div>
                                            <div class="job-info-text" style="color: rgb(120, 120, 120);">Full time
                                            </div>
                                        </div>
                                    </div>
                                    <div id="w-node-_7854e895-f395-adb1-9683-cef92e4c3000-f09ac0ca"
                                        class="job-apply-button-wrap"><a {!! nav_active('/career/brand-expert') ? 'aria-current="page"' : '' !!}
                                            data-w-id="84ff4b69-3bd5-a48a-06c2-d764252bc56d"
                                            href="{{ route('career.show', $job->slug) }}" class="primary-button w-inline-block{{ nav_active('/career/brand-expert') ? ' w--current' : '' }}"
                                            style="border-color: rgba(255, 255, 255, 0.2);">
                                            <div class="button-text-wrap">
                                                <div class="button-text-inner"
                                                    style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                                    <div class="text-block">Apply now</div>
                                                    <div>Apply now</div>
                                                </div>
                                            </div>
                                            <div class="button-icon-element">
                                                <div class="button-icon-wrap"
                                                    style="transform: translate3d(-50%, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                                    <div class="button-icon-inner"><img
                                                            src="/era/media/webflow/664c2ad8ce7e660fca0261be_arrow.svg"
                                                            loading="lazy" alt="" class="button-iocn"></div>
                                                    <div class="button-icon-inner"><img
                                                            src="/era/media/webflow/664c2ad8ce7e660fca0261be_arrow.svg"
                                                            loading="lazy" alt="" class="button-iocn"></div>
                                                </div>
                                            </div>
                                        </a></div>
                                </div>
                            </div>@endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="horizontal-line-wrap">
            <div class="horizontal-line"
                style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
            </div>
        </div>
    </section>@endif
    @if(cms_section_visible('career', 'career_cta'))<section class="section-cta">
        <div class="container-main">
            <div class="max-width-930px">
                <div class="cta-component">
                    <div class="cta-title-wrap">
                        <div data-w-id="9a268fd0-8c98-cbd7-b73d-163a2aa21c2a" class="title-move-animation"
                            style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                            <div class="text-gradient cta-text-gradient">
                                <div class="text-align-center">
                                    <h2 class="display-medium">{{ cms('career.career_cta.cta_title_line_1', 'START YOUR') }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cta-title-wrap">
                        <div data-w-id="93ad72e4-cc3e-2e24-6f93-9a3fc7f64ccd" class="title-move-animation"
                            style="transform: translate3d(0px, 100%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                            <div class="text-gradient cta-text-gradient">
                                <div class="text-align-center">
                                    <div class="display-medium">{{ cms('career.career_cta.cta_title_line_2', 'PROJECT NOW') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div data-w-id="fb3d8211-581b-e555-5949-cd34f550b0e3" class="cta-image-wrap"
                        style="opacity: 1; transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                        <img src="{{ cms_image('career.career_cta.cta_image', '/era/media/webflow/664c7b819abdb2098fe1c195_cta-image.jpg') }}"
                            loading="lazy" sizes="100vw"
                            srcset="/era/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-500.jpg 500w, /era/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-800.jpg 800w, /era/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-1080.jpg 1080w, /era/media/webflow/664c7b819abdb2098fe1c195_cta-image.jpg 1395w"
                            alt="CTA image" class="full-image">
                    </div><a {!! nav_active('/contact') ? 'aria-current="page"' : '' !!} data-w-id="84ff4b69-3bd5-a48a-06c2-d764252bc56d"
                        href="/contact" target="_blank"
                        class="primary-button w-inline-block{{ nav_active('/contact') ? ' w--current' : '' }}" style="border-color: rgba(255, 255, 255, 0.2);">
                        <div class="button-text-wrap">
                            <div class="button-text-inner"
                                style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                <div class="text-block">{{ cms('career.career_cta.cta_button_label', 'GET IT TOUCH') }}</div>
                                <div>{{ cms('career.career_cta.cta_button_label', 'GET IT TOUCH') }}</div>
                            </div>
                        </div>
                        <div class="button-icon-element">
                            <div class="button-icon-wrap"
                                style="transform: translate3d(-50%, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                <div class="button-icon-inner"><img
                                        src="/era/media/webflow/664c2ad8ce7e660fca0261be_arrow.svg"
                                        loading="lazy" alt="" class="button-iocn"></div>
                                <div class="button-icon-inner"><img
                                        src="/era/media/webflow/664c2ad8ce7e660fca0261be_arrow.svg"
                                        loading="lazy" alt="" class="button-iocn"></div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="horizontal-line-wrap">
            <div class="horizontal-line"
                style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
            </div>
        </div>
    </section>@endif
@endsection
