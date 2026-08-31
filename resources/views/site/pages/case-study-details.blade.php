@extends('site.layouts.app')

@section('title', 'Case Study Details')
@section('wf_page', '66485cbdb8fe5b2ef09ac0c6')
@section('wf_site', '66485cbdb8fe5b2ef09ac0c3')

@section('content')
<header class="section-case-study-details-hero">
        <div class="container-main">
            <div class="case-study-details-component">
                <div class="case-study-details-hero-element">
                    <h1 data-w-id="eb2fd0e8-99e8-18d8-cbad-bc93496d62af"
                        style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 1; transform-style: preserve-3d;"
                        class="case-study-details-title">{{ ($caseStudy->title) ?: cms('case-study-details.case_study_details_hero.case_study_title', 'Event planning and management') }}</h1>
                </div>
            </div>
        </div>
    </header>
    <section class="section-case-study-info">
        <div class="container-main">
            <div class="case-study-info-component">
                <div data-w-id="92bc3feb-83dd-5913-c237-7192f3537bff"
                    style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 1; transform-style: preserve-3d;"
                    class="case-study-main-image-wrap"><img
                        src="/era/media/webflow/66a88aa8e8d3d468817e7ff3_case-study-image-1.webp"
                        loading="lazy" alt="This is a nice image"
                        sizes="(max-width: 479px) 93vw, (max-width: 767px) 90vw, (max-width: 991px) 92vw, (max-width: 1439px) 94vw, (max-width: 1919px) 96vw, 99vw"
                        srcset="/era/media/webflow/66a88aa8e8d3d468817e7ff3_case-study-image-1-p-500.webp 500w, /era/media/webflow/66a88aa8e8d3d468817e7ff3_case-study-image-1-p-800.webp 800w, /era/media/webflow/66a88aa8e8d3d468817e7ff3_case-study-image-1-p-1080.webp 1080w, /era/media/webflow/66a88aa8e8d3d468817e7ff3_case-study-image-1-p-1600.webp 1600w, /era/media/webflow/66a88aa8e8d3d468817e7ff3_case-study-image-1.webp 1634w"
                        class="full-image"></div>
                <div data-w-id="96477ec7-ac44-d1db-8285-7f230d0b1275"
                    style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 1; transform-style: preserve-3d;"
                    class="case-study-info-wrap">
                    <div class="case-study-info-block">
                        <div class="case-study-info-title">{{ cms('case-study-details.case_study_info.client_label', 'CLIENT') }}</div>
                        <p>{{ ($caseStudy->client) ?: cms('case-study-details.case_study_info.client_name', 'Sarah Anderson') }}</p>
                    </div>
                    <div id="w-node-_51a30bd4-acee-1be9-ab0b-3d5d13716dab-2f0a959f" class="case-study-info-block">
                        <div class="case-study-info-title">{{ cms('case-study-details.case_study_info.date_label', 'DATE') }}</div>
                        <p>{{ ($caseStudy->duration) ?: cms('case-study-details.case_study_info.date_value', 'July 31, 2024') }}</p>
                    </div>
                    <div class="case-study-info-block">
                        <div class="case-study-info-title">{{ cms('case-study-details.case_study_info.services_label', 'Services') }}</div>
                        <p>{{ ($caseStudy->category) ?: cms('case-study-details.case_study_info.services_value', 'Branding, Development') }}</p>
                    </div>
                    <div id="w-node-_51678eff-5956-0e40-2396-f2b8741570b2-2f0a959f" class="case-study-info-block">
                        <div class="case-study-info-title">{{ cms('case-study-details.case_study_info.share_label', 'Share on') }}</div>
                        <div class="share-case-study-social"><a href="https://www.facebook.com/" target="_blank"
                                class="social-icon w-inline-block">
                                <div></div>
                            </a><a href="https://twitter.com/" target="_blank" class="social-icon w-inline-block">
                                <div></div>
                            </a><a href="https://www.instagram.com/" target="_blank" class="social-icon w-inline-block">
                                <div></div>
                            </a></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="horizontal-line-wrap">
            <div class="horizontal-line"
                style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
            </div>
        </div>
    </section>
    <section class="section-case-study-details">
        <div class="container-main">
            <div class="case-study-details-component">
                <div class="section-title-element our-solution-title-element">
                    <div class="section-caption-wrap">
                        <div class="caption"
                            style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                            {{ cms('case-study-details.case_study_objective_and_strategies.objective_caption', 'OBJECTIVE') }}</div>
                    </div>
                    <div class="section-title-wrap">
                        <div class="text-align-right">
                            <div class="text-animation-block"
                                style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                                <h2>{{ cms('case-study-details.case_study_objective_and_strategies.objective_heading', 'Enhance event attendance, engagement, and ROI through strategic planning and seamless execution.') }}</h2>
                                <div class="text-overlay" style="will-change: width, height; width: 100%;"></div>
                                <div class="text-overlay row-02" style="will-change: width, height; width: 100%;">
                                </div>
                                <div class="text-overlay row-03" style="will-change: width, height; width: 100%;">
                                </div>
                                <div class="text-overlay row-04" style="will-change: width, height; width: 100%;">
                                </div>
                                <div class="text-overlay row-05" style="will-change: width, height; width: 100%;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="case-study-details-element-wrap">
                    <div class="case-study-details-element"
                        style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                        <div id="w-node-_4bd6d0b9-41fb-bb03-68eb-7dceb8155158-2f0a959f"
                            class="case-study-details-content-block">
                            <div class="case-study-details-section-caption-wrap">
                                <div class="caption"
                                    style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                                    {{ cms('case-study-details.case_study_objective_and_strategies.key_strategies_caption', 'Key Strategies') }}</div>
                            </div>
                            <div class="case-study-details-rich-text w-richtext">
                                <h2>Experience and Streamlined Ordering</h2>
                                <p>Implement a user-centric design with intuitive navigation and a simplified
                                    ordering process. Integrate a one-click reorder feature for returning customers,
                                    reducing friction in the ordering experience.</p>
                            </div>
                        </div>
                        <div class="case-study-details-image-block"><img
                                src="/era/media/webflow/6697a1fab6721cc89ec1bbbf_case-strategies-image-1.webp"
                                loading="lazy" alt="" class="full-image"></div>
                    </div>
                    <div class="case-study-details-element second-element"
                        style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                        <div id="w-node-_87cc5316-0b96-3957-f92d-dcf2f7c2fca7-2f0a959f"
                            class="case-study-details-image-block"><img
                                src="/era/media/webflow/6697a202e6212609480fc166_case-strategies-image-2.webp"
                                loading="lazy" alt="" class="full-image"></div>
                        <div id="w-node-_87cc5316-0b96-3957-f92d-dcf2f7c2fca5-2f0a959f"
                            class="case-study-details-content-block">
                            <div class="case-study-details-rich-text w-richtext">
                                <h2>Personalization and Loyalty Programs</h2>
                                <p>Enhance customer engagement through personalized offerings and a loyalty program.
                                    Tailor promotions based on order history and preferences, and introduce a
                                    point-based loyalty system for repeat customers.</p>
                            </div>
                        </div>
                    </div>
                    <div class="case-study-details-element"
                        style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                        <div id="w-node-_6399360c-80b2-ba22-2f1f-7101c5374f15-2f0a959f"
                            class="case-study-details-content-block">
                            <div class="case-study-details-rich-text w-richtext">
                                <h2>Post-Event Analysis and Feedback</h2>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tristique velit nulla
                                    consectetur adipiscing elit. Tristique velit nulla at congue massa enim
                                    habitasse commodo.</p>
                            </div>
                        </div>
                        <div class="case-study-details-image-block"><img
                                src="/era/media/webflow/6697a210df3b42c274654129_case-strategies-image-3.webp"
                                loading="lazy" alt="" class="full-image"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="horizontal-line-wrap">
            <div class="horizontal-line"
                style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
            </div>
        </div>
    </section>
    <section class="section-case-study-result">
        <div class="container-main">
            <div class="case-study-result-component">
                <div class="case-study-result-content">
                    <div class="case-study-result-caption-wrap">
                        <div class="caption"
                            style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                            {{ cms('case-study-details.case_study_result.results_caption', 'RESULTS') }}</div>
                    </div>
                    <div class="case-study-result-title-wrap">
                        <div class="text-animation-block"
                            style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                            <h2>{{ cms('case-study-details.case_study_result.results_heading', 'Event planning management project impactful results') }}</h2>
                            <div class="text-overlay" style="will-change: width, height; width: 100%;"></div>
                            <div class="text-overlay row-02" style="will-change: width, height; width: 100%;"></div>
                            <div class="text-overlay row-03" style="will-change: width, height; width: 100%;"></div>
                            <div class="text-overlay row-04" style="will-change: width, height; width: 100%;"></div>
                        </div>
                    </div>
                    <div data-w-id="758b106c-ff19-31e4-5850-c974fb45c7c0"
                        style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 1; transform-style: preserve-3d;"
                        class="case-study-result-info-wrap">
                        <div class="case-study-result-info">
                            <div class="case-study-result-rich-text w-richtext">
                                <h2>20%</h2>
                                <p>Reduction average order placement</p>
                            </div>
                        </div>
                        <div class="case-study-result-info">
                            <div class="case-study-result-rich-text w-richtext">
                                <h2>40%</h2>
                                <p>Monthly website engagement increased</p>
                            </div>
                        </div>
                        <div class="case-study-result-info">
                            <div class="case-study-result-rich-text w-richtext">
                                <h2>96%</h2>
                                <p>Project delivery success rate</p>
                            </div>
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
    </section>
    <section class="section-testimonial">
        <div class="container-main">
            <div class="testimonial-component">
                <h2 class="caption"
                    style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                    {{ cms('case-study-details.testimonial.section_caption', 'TESTIMONIALS') }}</h2>
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
    </section>
    <section class="section-cta">
        <div class="container-main">
            <div class="max-width-930px">
                <div class="cta-component">
                    <div class="cta-title-wrap">
                        <div data-w-id="9a268fd0-8c98-cbd7-b73d-163a2aa21c2a" class="title-move-animation"
                            style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                            <div class="text-gradient cta-text-gradient">
                                <div class="text-align-center">
                                    <h2 class="display-medium">{{ cms('case-study-details.cta.cta_title_line_1', 'START YOUR') }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cta-title-wrap">
                        <div data-w-id="93ad72e4-cc3e-2e24-6f93-9a3fc7f64ccd" class="title-move-animation"
                            style="transform: translate3d(0px, 100%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                            <div class="text-gradient cta-text-gradient">
                                <div class="text-align-center">
                                    <div class="display-medium">{{ cms('case-study-details.cta.cta_title_line_2', 'PROJECT NOW') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div data-w-id="fb3d8211-581b-e555-5949-cd34f550b0e3" class="cta-image-wrap" style="opacity: 0;">
                        <img src="{{ cms_image('case-study-details.cta.cta_image', '/era/media/webflow/664c7b819abdb2098fe1c195_cta-image.jpg') }}"
                            loading="lazy" sizes="100vw"
                            srcset="/era/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-500.jpg 500w, /era/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-800.jpg 800w, /era/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-1080.jpg 1080w, /era/media/webflow/664c7b819abdb2098fe1c195_cta-image.jpg 1395w"
                            alt="CTA image" class="full-image"></div><a {!! nav_active('/contact') ? 'aria-current="page"' : '' !!} data-w-id="84ff4b69-3bd5-a48a-06c2-d764252bc56d"
                        href="/contact" target="_blank"
                        class="primary-button w-inline-block{{ nav_active('/contact') ? ' w--current' : '' }}" style="border-color: rgba(255, 255, 255, 0.2);">
                        <div class="button-text-wrap">
                            <div class="button-text-inner"
                                style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                <div class="text-block">{{ cms('case-study-details.cta.cta_button_label', 'GET IT TOUCH') }}</div>
                                <div>{{ cms('case-study-details.cta.cta_button_label', 'GET IT TOUCH') }}</div>
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
    </section>
@endsection
