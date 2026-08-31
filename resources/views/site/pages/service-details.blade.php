@extends('site.layouts.app')

@section('title', detail_title($service ?? null, 'service-details', 'Services Details'))
@section('wf_page', '66485cbdb8fe5b2ef09ac0c6')
@section('wf_site', '66485cbdb8fe5b2ef09ac0c3')

@section('content')
<div class="cursor-wrapper">
        <div data-w-id="fd885965-1454-8dd5-7dfb-6b25a03c3d50" class="cursor"
            style="transform: translate3d(-28.163vw, 49.995vh, 0px) scale3d(0, 0, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1; background-color: rgb(255, 255, 255); will-change: transform;">
            <div data-w-id="fd885965-1454-8dd5-7dfb-6b25a03c3d51" class="cursor-text-view"
                style="opacity: 0; display: block;">{{ cms('service-details.custom_cursor_overlay.cursor_hover_label', 'View Case') }}</div><img
                src="{{ cms_image('service-details.custom_cursor_overlay.cursor_play_icon', '/era/media/webflow/664d7b64e6f014d2e2659c40_video-play.svg') }}"
                loading="lazy" alt="" class="video-play-icon">
        </div>
    </div>
    <header class="section-common-hero">
        <div class="container-main">
            <div class="common-hero-component">
                <div class="service-details-hero-element">
                    <div id="w-node-_6b10a086-cdc8-1904-869f-3b19474562c5-a80b356f"
                        class="service-details-content-wrap">
                        <div id="w-node-_6b10a086-cdc8-1904-869f-3b19474562c6-a80b356f" class="hero-title-wrap">
                            <div class="title-move-animation"
                                style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                                <div class="text-gradient">
                                    <h1 class="display-large">{{ ($service->hero_heading ?: $service->title) ?: cms('service-details.service_details_hero.hero_title', 'Search engine optimization') }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="w-node-_6b10a086-cdc8-1904-869f-3b19474562d7-a80b356f"
                        class="service-short-description-wrap">
                        <p data-w-id="6b10a086-cdc8-1904-869f-3b19474562d8"
                            style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 1; transform-style: preserve-3d;">
                            {{ ($service->hero_intro ?: $service->excerpt) ?: cms('service-details.service_details_hero.hero_description', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse aliquet dolor sit amet diam pulvinar tempus et ac sapien. Nullam molestie, lorem finibus tristique tincidunt, nunc purus venenatis.') }}</p>
                    </div>
                    <div id="w-node-ca5155ab-986f-fabd-0c31-a3f3f5f63039-a80b356f"
                        data-w-id="ca5155ab-986f-fabd-0c31-a3f3f5f63039"
                        style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 1; transform-style: preserve-3d;"
                        class="button-wrap"><a {!! nav_active('/contact') ? 'aria-current="page"' : '' !!} data-w-id="84ff4b69-3bd5-a48a-06c2-d764252bc56d" href="/contact"
                            class="primary-button w-inline-block{{ nav_active('/contact') ? ' w--current' : '' }}" style="border-color: rgba(255, 255, 255, 0.2);">
                            <div class="button-text-wrap">
                                <div class="button-text-inner"
                                    style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                    <div class="text-block">{{ cms('service-details.service_details_hero.hero_cta_label', 'LET’S TALK') }}</div>
                                    <div>{{ cms('service-details.service_details_hero.hero_cta_label', 'LET’S TALK') }}</div>
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
                    <div id="w-node-_106e21cd-1a1c-528f-a761-28e2ab0e10e0-a80b356f"
                        data-w-id="106e21cd-1a1c-528f-a761-28e2ab0e10e0"
                        style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 1; transform-style: preserve-3d;"
                        class="service-main-image-wrap"><img
                            src="{{ ($service->heroImage?->url ?: $service->image?->url) ?: cms_image('service-details.service_details_hero.hero_image', '/era/media/webflow/66acd1202df48adbb6b1b10d_service-image-4.webp') }}"
                            loading="lazy" alt="This is a nice image"
                            sizes="(max-width: 479px) 43vw, (max-width: 767px) 35vw, (max-width: 991px) 32vw, (max-width: 1279px) 33vw, 540px"
                            srcset="/era/media/webflow/66acd1202df48adbb6b1b10d_service-image-4-p-500.webp 500w, /era/media/webflow/66acd1202df48adbb6b1b10d_service-image-4-p-800.webp 800w, /era/media/webflow/66acd1202df48adbb6b1b10d_service-image-4.webp 1028w"
                            class="service-main-image"></div>
                </div>
            </div>
        </div>
        <div class="horizontal-line-wrap">
            <div class="horizontal-line"
                style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
            </div>
        </div>
    </header>
    <section class="section-service-details">
        <div class="container-main">
            <div class="service-details-component">
                <div class="service-details-element">
                    <div class="section-title-element">
                        <div class="section-caption-wrap">
                            <div class="caption"
                                style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                                {{ cms('service-details.service_details_features.caption', 'SERVICE') }}</div>
                        </div>
                        <div class="section-title-wrap">
                            <div class="text-align-right">
                                <div class="text-animation-block"
                                    style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                                    <h2>{{ cms('service-details.service_details_features.heading', 'Under the services of the search engine optimization') }}</h2>
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
                    <div data-w-id="845f2d33-8849-26b5-5294-3e2cf46a941c"
                        style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 1; transform-style: preserve-3d;"
                        class="our-process-list service-details-feature-list">
                        <div class="our-process-item service-feature-item">
                            <div class="our-process-item-inner service-feature-item">
                                <div class="service-feature-rich-text w-richtext">
                                    <h3>Local seo optimization</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin sed lectus
                                        vehicula.</p>
                                </div>
                            </div>
                            <div class="process-counting-wrap service-page-process-counting">
                                <div>1</div>
                            </div>
                        </div>
                        <div class="our-process-item service-feature-item">
                            <div class="our-process-item-inner service-feature-item">
                                <div class="service-feature-rich-text w-richtext">
                                    <h3>Voice search optimization</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin iaculis nibh
                                        sed.</p>
                                </div>
                            </div>
                            <div class="process-counting-wrap service-page-process-counting">
                                <div>2</div>
                            </div>
                        </div>
                        <div class="our-process-item service-feature-item">
                            <div class="our-process-item-inner service-feature-item">
                                <div class="service-feature-rich-text w-richtext">
                                    <h3>Video seo services</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sapien nibh,
                                        ornare.</p>
                                </div>
                            </div>
                            <div class="process-counting-wrap service-page-process-counting">
                                <div>3</div>
                            </div>
                        </div>
                        <div class="our-process-item service-feature-item">
                            <div class="our-process-item-inner service-feature-item">
                                <div class="service-feature-rich-text w-richtext">
                                    <h3>E-commerce seo solutions</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas aliquet
                                        ultricies gravida.</p>
                                </div>
                            </div>
                            <div class="process-counting-wrap service-page-process-counting">
                                <div>4</div>
                            </div>
                        </div>
                        <div class="our-process-item service-feature-item">
                            <div class="our-process-item-inner service-feature-item">
                                <div class="service-feature-rich-text w-richtext">
                                    <h3>Mobile seo services</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi rhoncus porta
                                        velit.</p>
                                </div>
                            </div>
                            <div class="process-counting-wrap service-page-process-counting">
                                <div>5</div>
                            </div>
                        </div>
                        <div class="our-process-item service-feature-item">
                            <div class="our-process-item-inner service-feature-item">
                                <div class="service-feature-rich-text w-richtext">
                                    <h3>International seo strategies</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam dapibus
                                        pulvinar neque.</p>
                                </div>
                            </div>
                            <div class="process-counting-wrap service-page-process-counting">
                                <div>6</div>
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
    <section class="section-service-process">
        <div class="container-main">
            <div class="service-process-component">
                <div class="section-title-element">
                    <div class="section-caption-wrap">
                        <div class="caption"
                            style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                            {{ cms('service-details.service_process.caption', 'PROCESS') }}</div>
                    </div>
                    <div class="section-title-wrap">
                        <div class="text-align-right">
                            <div class="text-animation-block"
                                style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                                <h2>{{ cms('service-details.service_process.heading', 'Our bulletproof process to win on social media') }}</h2>
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
                <div class="service-process-element">
                    <div class="service-process-item service-process-item-01"
                        style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                        <div class="service-process-rich-text w-richtext">
                            <h2>01</h2>
                            <h3>Content plan</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tristique velit nulla
                                &nbsp;consectetur adipiscing elit. Tristique velit nulla at congue massa enim
                                habitasse commodo. Sed mi dictum non ultrices sed dis.</p>
                        </div>
                    </div>
                    <div id="w-node-_21b224d4-1e2a-b9fd-edf3-a43f9f9938de-a80b356f"
                        class="service-process-item service-process-item-02"
                        style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                        <div>
                            <div class="service-process-rich-text w-richtext">
                                <h2>02</h2>
                                <h3>Execution</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tristique velit nulla
                                    &nbsp;consectetur adipiscing elit. Tristique velit nulla at congue massa enim
                                    habitasse commodo. Sed mi dictum non ultrices sed dis.</p>
                            </div>
                        </div>
                    </div>
                    <div id="w-node-f3cccc0c-d168-922d-1661-7e081ce93b50-a80b356f"
                        class="service-process-item service-process-item-03"
                        style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                        <div class="service-process-rich-text w-richtext">
                            <h2>03</h2>
                            <h3>Measure &amp; scale</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tristique velit nulla
                                &nbsp;consectetur adipiscing elit. Tristique velit nulla at congue massa enim
                                habitasse commodo. Sed mi dictum non ultrices sed dis.</p>
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
    <section class="section-case-study">
        <div class="container-main">
            <div class="case-study-component">
                <h2 class="caption"
                    style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                    {{ cms('service-details.case_study.caption', 'CASE STUDY') }}</h2>
                <div class="case-study-element">
                    <div class="w-dyn-list">
                        <div role="list" class="w-dyn-items">
                            @foreach (\App\Models\CaseStudy::published()->ordered()->take(3)->get() as $study)<div role="listitem" class="case-study-collection-item w-dyn-item"
                                style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                                <a {!! nav_active('/case-studies/event-planning-and-management') ? 'aria-current="page"' : '' !!} href="{{ route('case-studies.show', $study->slug) }}" class="w-inline-block{{ nav_active('/case-studies/event-planning-and-management') ? ' w--current' : '' }}">
                                    <div class="case-study-image-wrap"><img
                                            src="{{ $study->image?->url }}"
                                            loading="lazy" alt=""
                                            class="full-image"></div>
                                </a>
                                <div id="w-node-cda89d13-20d1-91a8-7902-5c59a19ff0f5-a80b356f"
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
                    </div>
                    <div data-w-id="cda89d13-20d1-91a8-7902-5c59a19ff0fd"
                        style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 1; transform-style: preserve-3d;"
                        class="view-all-case-study-button-wrap"><a {!! nav_active('/case-studies') ? 'aria-current="page"' : '' !!} data-w-id="84ff4b69-3bd5-a48a-06c2-d764252bc56d"
                            href="/case-studies" class="primary-button w-inline-block{{ nav_active('/case-studies') ? ' w--current' : '' }}"
                            style="border-color: rgba(255, 255, 255, 0.2);">
                            <div class="button-text-wrap">
                                <div class="button-text-inner"
                                    style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                    <div class="text-block">{{ cms('service-details.case_study.view_all_label', 'VIEW MORE') }}</div>
                                    <div>{{ cms('service-details.case_study.view_all_label', 'VIEW MORE') }}</div>
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
            </div>
        </div>
        <div class="horizontal-line-wrap">
            <div class="horizontal-line"
                style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
            </div>
        </div>
    </section>
    <section class="section-why-choose-us">
        <div class="container-main">
            <div class="why-choose-us-component">
                <div class="why-choose-us-element">
                    <div id="w-node-fc291a14-7273-2f34-0daa-4445132c96b5-a80b356f" class="why-choose-us-content-wrap">
                        <div class="why-choose-us-caption-wrap">
                            <div class="caption"
                                style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                                {{ cms('service-details.why_choose_us.caption', 'WHY CHOOSE US') }}</div>
                        </div>
                        <div class="why-choose-us-content-block">
                            <div class="why-choose-us-content-item">
                                <div class="why-choose-us-title-wrap">
                                    <div class="text-animation-block"
                                        style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                                        <h2>1. Proven Expertise</h2>
                                        <div class="text-overlay" style="will-change: width, height; width: 100%;">
                                        </div>
                                        <div class="text-overlay row-02"
                                            style="will-change: width, height; width: 100%;"></div>
                                        <div class="text-overlay row-03"
                                            style="will-change: width, height; width: 100%;"></div>
                                        <div class="text-overlay row-04"
                                            style="will-change: width, height; width: 100%;"></div>
                                    </div>
                                </div>
                                <div class="why-choose-us-para-wrap">
                                    <p data-w-id="fc291a14-7273-2f34-0daa-4445132c96c2"
                                        style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 0; transform-style: preserve-3d;">
                                        Whether with an app, a site, or a system, our focus is on helping improve
                                        your relationship with your customers through a mix of strategy, design, and
                                        technology.amet, consectetur adipiscing elit.</p>
                                </div>
                            </div>
                            <div class="why-choose-us-content-item">
                                <div class="why-choose-us-title-wrap">
                                    <div class="text-animation-block"
                                        style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                                        <h2>2. Customized Strategies</h2>
                                        <div class="text-overlay" style="will-change: width, height; width: 100%;">
                                        </div>
                                        <div class="text-overlay row-02"
                                            style="will-change: width, height; width: 100%;"></div>
                                        <div class="text-overlay row-03"
                                            style="will-change: width, height; width: 100%;"></div>
                                        <div class="text-overlay row-04"
                                            style="will-change: width, height; width: 100%;"></div>
                                    </div>
                                </div>
                                <div class="why-choose-us-para-wrap">
                                    <p data-w-id="ec51c824-d57c-5570-4db8-4297ab6c291c"
                                        style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 0; transform-style: preserve-3d;">
                                        Whether with an app, a site, or a system, our focus is on helping improve
                                        your relationship with your customers through a mix of strategy, design, and
                                        technology.amet, consectetur adipiscing elit.</p>
                                </div>
                            </div>
                            <div class="why-choose-us-content-item">
                                <div class="why-choose-us-title-wrap">
                                    <div class="text-animation-block"
                                        style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                                        <h2>3. direct Communication</h2>
                                        <div class="text-overlay" style="will-change: width, height; width: 100%;">
                                        </div>
                                        <div class="text-overlay row-02"
                                            style="will-change: width, height; width: 100%;"></div>
                                        <div class="text-overlay row-03"
                                            style="will-change: width, height; width: 100%;"></div>
                                        <div class="text-overlay row-04"
                                            style="will-change: width, height; width: 100%;"></div>
                                    </div>
                                </div>
                                <div class="why-choose-us-para-wrap">
                                    <p data-w-id="d3afc926-6b7d-0715-9ea6-e16b6afdd2f0"
                                        style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 0; transform-style: preserve-3d;">
                                        Whether with an app, a site, or a system, our focus is on helping improve
                                        your relationship with your customers through a mix of strategy, design, and
                                        technology.amet, consectetur adipiscing elit.</p>
                                </div>
                            </div>
                        </div>
                        <div class="button-wrap why-choose-us-section-button"><a {!! nav_active('/why-choose-us') ? 'aria-current="page"' : '' !!}
                                data-w-id="84ff4b69-3bd5-a48a-06c2-d764252bc56d" href="/why-choose-us"
                                class="primary-button w-inline-block{{ nav_active('/why-choose-us') ? ' w--current' : '' }}" style="border-color: rgba(255, 255, 255, 0.2);">
                                <div class="button-text-wrap">
                                    <div class="button-text-inner"
                                        style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                        <div class="text-block">{{ cms('service-details.why_choose_us.button_label', 'SEE MORE') }}</div>
                                        <div>{{ cms('service-details.why_choose_us.button_label', 'SEE MORE') }}</div>
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
                    <div id="w-node-fc291a14-7273-2f34-0daa-4445132c96c6-a80b356f" class="why-choose-us-image-block">
                        <div data-w-id="fc291a14-7273-2f34-0daa-4445132c96c7"
                            style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 0; transform-style: preserve-3d;"
                            class="why-choose-us-image-wrap"><img
                                src="{{ cms_image('service-details.why_choose_us.side_image', '/era/media/webflow/668f57f523812d8b78e89c6b_our-evaluation-section-image.webp') }}"
                                loading="lazy"
                                sizes="(max-width: 479px) 93vw, (max-width: 767px) 90vw, (max-width: 991px) 92vw, (max-width: 1279px) 44vw, 500px"
                                srcset="/era/media/webflow/668f57f523812d8b78e89c6b_our-evaluation-section-image-p-500.webp 500w, /era/media/webflow/668f57f523812d8b78e89c6b_our-evaluation-section-image-p-800.webp 800w, /era/media/webflow/668f57f523812d8b78e89c6b_our-evaluation-section-image.webp 998w"
                                alt="our evaluation section image" class="full-image"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="horizontal-line-wrap">
            <div class="horizontal-line"
                style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
            </div>
        </div>
    </section>
    <section class="section-cta">
        <div class="container-main">
            <div class="max-width-930px">
                <div class="cta-component">
                    <div class="cta-title-wrap">
                        <div data-w-id="9a268fd0-8c98-cbd7-b73d-163a2aa21c2a" class="title-move-animation"
                            style="transform: translate3d(0px, 100%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                            <div class="text-gradient cta-text-gradient">
                                <div class="text-align-center">
                                    <h2 class="display-medium">{{ cms('service-details.cta.cta_title_line_1', 'START YOUR') }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cta-title-wrap">
                        <div data-w-id="93ad72e4-cc3e-2e24-6f93-9a3fc7f64ccd" class="title-move-animation"
                            style="transform: translate3d(0px, 100%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                            <div class="text-gradient cta-text-gradient">
                                <div class="text-align-center">
                                    <div class="display-medium">{{ cms('service-details.cta.cta_title_line_2', 'PROJECT NOW') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div data-w-id="fb3d8211-581b-e555-5949-cd34f550b0e3" class="cta-image-wrap" style="opacity: 0;">
                        <img src="{{ cms_image('service-details.cta.cta_image', '/era/media/webflow/664c7b819abdb2098fe1c195_cta-image.jpg') }}"
                            loading="lazy" sizes="100vw"
                            srcset="/era/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-500.jpg 500w, /era/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-800.jpg 800w, /era/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-1080.jpg 1080w, /era/media/webflow/664c7b819abdb2098fe1c195_cta-image.jpg 1395w"
                            alt="CTA image" class="full-image"></div><a {!! nav_active('/contact') ? 'aria-current="page"' : '' !!} data-w-id="84ff4b69-3bd5-a48a-06c2-d764252bc56d"
                        href="/contact" target="_blank"
                        class="primary-button w-inline-block{{ nav_active('/contact') ? ' w--current' : '' }}" style="border-color: rgba(255, 255, 255, 0.2);">
                        <div class="button-text-wrap">
                            <div class="button-text-inner"
                                style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                <div class="text-block">{{ cms('service-details.cta.cta_button_label', 'GET IT TOUCH') }}</div>
                                <div>{{ cms('service-details.cta.cta_button_label', 'GET IT TOUCH') }}</div>
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
