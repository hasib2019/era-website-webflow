@extends('site.layouts.app')

@section('title', page_title('case-studies', 'Case Studies'))
@section('wf_page', '66485cbdb8fe5b2ef09ac0c6')
@section('wf_site', '66485cbdb8fe5b2ef09ac0c3')

@section('content')
<div class="cursor-wrapper">
        <div data-w-id="fd885965-1454-8dd5-7dfb-6b25a03c3d50" class="cursor"
            style="transform: translate3d(32.083vw, -27.77vh, 0px) scale3d(0, 0, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1; will-change: transform;">
            <div data-w-id="fd885965-1454-8dd5-7dfb-6b25a03c3d51" class="cursor-text-view" style="opacity: 0;">View
                Case</div><img
                src="/era/media/webflow/664d7b64e6f014d2e2659c40_video-play.svg"
                loading="lazy" alt="" class="video-play-icon">
        </div>
    </div>
    @if(cms_section_visible('case-studies', 'case_study_hero'))<header class="section-common-hero">
        <div class="container-main">
            <div class="common-hero-component">
                <div class="common-hero-element">
                    <div id="w-node-_75249cb8-a702-a203-a33c-cdfff132a46e-f09ac0c9" class="hero-title-wrap">
                        <div class="title-move-animation"
                            style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                            <div class="text-gradient">
                                <div class="display-large">{{ cms('case-studies.case_study_hero.hero_title_line_1', 'A selection of') }}</div>
                            </div>
                        </div>
                    </div>
                    <div id="w-node-_05bfcc82-2810-09a7-3e69-0967f4b254cb-f09ac0c9" class="hero-title-wrap">
                        <div class="title-move-animation"
                            style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                            <div class="text-gradient">
                                <div class="display-large">{{ cms('case-studies.case_study_hero.hero_title_line_2', 'successful') }}</div>
                            </div>
                        </div>
                    </div>
                    <div id="w-node-_75249cb8-a702-a203-a33c-cdfff132a473-f09ac0c9" class="content-group">
                        <div class="content-group-title-wrap">
                            <div class="hero-title-wrap">
                                <div class="title-move-animation"
                                    style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                                    <div class="text-gradient">
                                        <div class="display-large">{{ cms('case-studies.case_study_hero.hero_title_line_3', 'projects') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="w-node-_75249cb8-a702-a203-a33c-cdfff132a47a-f09ac0c9"
                            class="content-group-para-wrap case-study-content-group-para-wrap"
                            style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                            <p class="hero-para">{{ cms('case-studies.case_study_hero.hero_paragraph', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas non massa luctus, rutrum libero in, fermentum orci. Pellentesque condimentum nisl et erat.') }}</p>
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
    </header>@endif
    @if(cms_section_visible('case-studies', 'case_study_list'))<section class="section-case-study">
        <div class="container-main">
            <div class="case-study-component">
                <h2 class="caption"
                    style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                    {{ cms('case-studies.case_study_list.section_caption', 'CASE STUDY') }}</h2>
                <div class="case-study-element">
                    <div class="w-dyn-list">
                        <div role="list" class="w-dyn-items">
                            @foreach (\App\Models\CaseStudy::published()->ordered()->get() as $study)<div role="listitem" class="case-study-collection-item w-dyn-item"
                                style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                                <a {!! nav_active('/case-studies/event-planning-and-management') ? 'aria-current="page"' : '' !!} href="{{ route('case-studies.show', $study->slug) }}"
                                    class="case-study-image-wrap w-inline-block{{ nav_active('/case-studies/event-planning-and-management') ? ' w--current' : '' }}"><img
                                        src="{{ $study->image?->url }}"
                                        loading="lazy" alt="This is a nice image"
                                        class="full-image"></a>
                                <div id="w-node-_913f2d87-2cdf-4e67-aac7-cae127bfba1e-f09ac0c9"
                                    class="case-study-content-block">
                                    <div class="case-study-content-wrap">
                                        <div class="case-study-title">{{ $study->title }}</div>
                                        <div class="case-study-subtitle-wrap">
                                            <p class="case-study-subtitle">{{ $study->subtitle }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>@endforeach
                        </div>
                        <div data-w-id="ab3f87c0-4be9-1370-1491-c672575458de"
                            style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 0; transform-style: preserve-3d;"
                            role="navigation" aria-label="List" class="w-pagination-wrapper pagination"><a
                                href="?b2709d13_page=2" aria-label="Next Page" class="w-pagination-next primary-button"
                                style="border-color: rgba(255, 255, 255, 0.2);">
                                <div class="button-text-wrap">
                                    <div class="button-text-inner"
                                        style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                        <div class="text-block">{{ cms('case-studies.case_study_list.pagination_next_label', 'NEXT PAGE') }}</div>
                                        <div>{{ cms('case-studies.case_study_list.pagination_next_label', 'NEXT PAGE') }}</div>
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
                            <link rel="prerender" href="?b2709d13_page=2">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="horizontal-line-wrap">
            <div class="horizontal-line"
                style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
            </div>
        </div>
    </section>@endif
    @if(cms_section_visible('case-studies', 'testimonials'))<section class="section-testimonial">
        <div class="container-main">
            <div class="testimonial-component">
                <h2 class="caption"
                    style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                    {{ cms('case-studies.testimonials.section_caption', 'TESTIMONIALS') }}</h2>
                <div data-w-id="afebf228-b705-b23f-c6fe-3b4a36c0203b" class="testimonial-element-wrap"
                    style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
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
                style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
            </div>
        </div>
    </section>@endif
    @if(cms_section_visible('case-studies', 'latest_blog'))<section class="home-latest-blog">
        <div class="container-main">
            <div class="blog-component">
                <div class="blog-section-title-wrap">
                    <div id="w-node-_4e6796ed-5a35-3b0c-04fe-7c88635c92c3-635c92bf" class="caption"
                        style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                        {{ cms('case-studies.latest_blog.section_caption', 'BLOG/ARTICLES') }}</div>
                    <div class="text-align-right">
                        <div class="text-animation-block"
                            style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                            <h2>{{ cms('case-studies.latest_blog.section_heading', 'Browse our latest news and resources') }}</h2>
                            <div class="text-overlay" style="will-change: width, height; width: 100%;"></div>
                            <div class="text-overlay row-02" style="will-change: width, height; width: 100%;"></div>
                            <div class="text-overlay row-03" style="will-change: width, height; width: 100%;"></div>
                            <div class="text-overlay row-04" style="will-change: width, height; width: 100%;"></div>
                        </div>
                    </div>
                </div>
                <div class="blog-element">
                    <div class="w-dyn-list">
                        <div role="list" class="w-dyn-items">
                            @foreach (\App\Models\Post::published()->latestFirst()->take(2)->get() as $post)<div role="listitem" class="blog-collection-item w-dyn-item"
                                style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                                <div class="blog-item">
                                    <div id="w-node-_4e6796ed-5a35-3b0c-04fe-7c88635c92cd-635c92bf"
                                        class="blog-content-wrap">
                                        <div class="blog-info-wrap blog-item-info-wrap">
                                            <div class="blog-info"><img
                                                    src="/era/media/webflow/66507334b279af4803571b92_calender-icon.png"
                                                    loading="lazy" alt="">
                                                <p class="font-weight-medium">{{ $post->published_at?->format('M j, Y') }}</p>
                                            </div>
                                            <div class="blog-info"><img
                                                    src="/era/media/webflow/66507334a301d18ef9aa933f_time-icon.png"
                                                    loading="lazy" alt="">
                                                <div class="blog-info-content-wrap">
                                                    <p class="font-weight-medium">{{ $post->read_time }}</p>
                                                    <p class="font-weight-medium">{{ $post->read_time_unit }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <h3 class="blog-title" style="color: rgb(120, 120, 120);">{{ $post->title }}</h3>
                                        <div class="blog-post-summary-wrap">
                                            <p class="blog-post-summary">{{ $post->summary }}</p>
                                        </div><a {!! nav_active('/blog/navigating-search-algorithms-for-regional-impact') ? 'aria-current="page"' : '' !!} data-w-id="84ff4b69-3bd5-a48a-06c2-d764252bc56d"
                                            href="{{ route('blog.show', $post->slug) }}"
                                            class="primary-button w-inline-block{{ nav_active('/blog/navigating-search-algorithms-for-regional-impact') ? ' w--current' : '' }}"
                                            style="border-color: rgba(255, 255, 255, 0.2);">
                                            <div class="button-text-wrap">
                                                <div class="button-text-inner"
                                                    style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                                    <div class="text-block">READ ARTICLE</div>
                                                    <div>READ ARTICLE</div>
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
                                    <div id="w-node-_4e6796ed-5a35-3b0c-04fe-7c88635c92de-635c92bf"
                                        class="blog-thumbnail-image-wrap"><img
                                            src="{{ $post->image?->url }}"
                                            loading="lazy" alt="This is a nice image"
                                            class="blog-image"
                                            style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
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
                style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
            </div>
        </div>
    </section>@endif
    @if(cms_section_visible('case-studies', 'cta'))<section class="section-cta">
        <div class="container-main">
            <div class="max-width-930px">
                <div class="cta-component">
                    <div class="cta-title-wrap">
                        <div data-w-id="9a268fd0-8c98-cbd7-b73d-163a2aa21c2a" class="title-move-animation"
                            style="transform: translate3d(0px, 100%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                            <div class="text-gradient cta-text-gradient">
                                <div class="text-align-center">
                                    <h2 class="display-medium">{{ cms('case-studies.cta.cta_title_line_1', 'START YOUR') }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cta-title-wrap">
                        <div data-w-id="93ad72e4-cc3e-2e24-6f93-9a3fc7f64ccd" class="title-move-animation"
                            style="transform: translate3d(0px, 100%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                            <div class="text-gradient cta-text-gradient">
                                <div class="text-align-center">
                                    <div class="display-medium">{{ cms('case-studies.cta.cta_title_line_2', 'PROJECT NOW') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div data-w-id="fb3d8211-581b-e555-5949-cd34f550b0e3" class="cta-image-wrap" style="opacity: 0;">
                        <img src="{{ cms_image('case-studies.cta.cta_image', '/era/media/webflow/664c7b819abdb2098fe1c195_cta-image.jpg') }}"
                            loading="lazy" sizes="100vw"
                            srcset="/era/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-500.jpg 500w, /era/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-800.jpg 800w, /era/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-1080.jpg 1080w, /era/media/webflow/664c7b819abdb2098fe1c195_cta-image.jpg 1395w"
                            alt="CTA image" class="full-image"></div><a {!! nav_active('/contact') ? 'aria-current="page"' : '' !!} data-w-id="84ff4b69-3bd5-a48a-06c2-d764252bc56d"
                        href="/contact" target="_blank"
                        class="primary-button w-inline-block{{ nav_active('/contact') ? ' w--current' : '' }}" style="border-color: rgba(255, 255, 255, 0.2);">
                        <div class="button-text-wrap">
                            <div class="button-text-inner"
                                style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                <div class="text-block">{{ cms('case-studies.cta.cta_button_label', 'GET IT TOUCH') }}</div>
                                <div>{{ cms('case-studies.cta.cta_button_label', 'GET IT TOUCH') }}</div>
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
