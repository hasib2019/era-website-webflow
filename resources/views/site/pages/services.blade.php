@extends('site.layouts.app')

@section('title', page_title('services', 'Services'))
@section('wf_page', '66485cbdb8fe5b2ef09ac0c6')
@section('wf_site', '66485cbdb8fe5b2ef09ac0c3')

@section('content')
<div class="cursor-wrapper">
        <div data-w-id="fd885965-1454-8dd5-7dfb-6b25a03c3d50" class="cursor"
            style="transform: translate3d(-36.669vw, -50vh, 0px) scale3d(0, 0, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1; will-change: transform;">
            <div data-w-id="fd885965-1454-8dd5-7dfb-6b25a03c3d51" class="cursor-text-view" style="opacity: 0;">View
                Case</div><img
                src="/era/media/webflow/664d7b64e6f014d2e2659c40_video-play.svg"
                loading="lazy" alt="" class="video-play-icon">
        </div>
    </div>
    @if(cms_section_visible('services', 'service_hero'))<header class="section-common-hero">
        <div class="container-main">
            <div class="common-hero-component">
                <div class="common-hero-element">
                    <div id="w-node-_96d6410b-e305-2510-fce2-20f6b25eef31-f09ac0c7" class="hero-title-wrap">
                        <div class="title-move-animation"
                            style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                            <div class="text-gradient">
                                <div class="display-large">{{ cms('services.service_hero.hero_title_line_1', 'our digital') }}</div>
                            </div>
                        </div>
                    </div>
                    <div id="w-node-_4cbf8089-8e27-c28f-83df-f2b368be7264-f09ac0c7" class="hero-title-wrap">
                        <div class="title-move-animation"
                            style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                            <div class="text-gradient">
                                <div class="display-large">{{ cms('services.service_hero.hero_title_line_2', 'marketing') }}</div>
                            </div>
                        </div>
                    </div>
                    <div id="w-node-_96d6410b-e305-2510-fce2-20f6b25eef36-f09ac0c7" class="content-group">
                        <div class="content-group-title-wrap">
                            <div class="hero-title-wrap">
                                <div class="title-move-animation"
                                    style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                                    <div class="text-gradient">
                                        <div class="display-large">{{ cms('services.service_hero.hero_title_line_3', 'services') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="w-node-_96d6410b-e305-2510-fce2-20f6b25eef3d-f09ac0c7" class="content-group-para-wrap"
                            style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                            <p class="hero-para">{{ cms('services.service_hero.hero_paragraph', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id nibh vestibulum, fringilla nulla nec, iaculis mauris. Proin.') }}</p>
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
    @if(cms_section_visible('services', 'service_list'))<section class="section-service">
        <div class="container-main">
            <div class="service-component">
                <div class="service-section-caption-wrap">
                    <h2 class="caption"
                        style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                        {{ cms('services.service_list.section_caption', 'SERVICES') }}</h2>
                </div>
                <div data-w-id="be10eac0-f33f-85de-d8c0-cd7eeb04d68a" class="service-collection-list-wrapper w-dyn-list"
                    style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                    <div role="list" class="w-dyn-items">
                        @foreach (\App\Models\Service::published()->ordered()->get() as $service)<div data-w-id="be10eac0-f33f-85de-d8c0-cd7eeb04d68c" role="listitem"
                            class="service-collection-item w-dyn-item"><a {!! nav_active('/services/search-engine-optimization') ? 'aria-current="page"' : '' !!} href="{{ route('services.show', $service->slug) }}"
                                class="service-link w-inline-block{{ nav_active('/services/search-engine-optimization') ? ' w--current' : '' }}">
                                <div class="service-content-wrap">
                                    <div class="service-content-inner"
                                        style="transform: translate3d(0%, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                        <div class="service-counter" style="color: rgb(120, 120, 120);">{{ $service->counter }}</div>
                                        <div class="service-title-wrap">
                                            <div class="service-title" style="color: rgb(120, 120, 120);">{{ $service->title }}</div>
                                        </div>
                                    </div>
                                </div>
                            </a><img
                                src="{{ $service->image?->url }}"
                                loading="lazy" alt="This is a nice image"
                                class="service-image"
                                style="transform: translate3d(320px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                        </div>@endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>@endif
    @if(cms_section_visible('services', 'about_us_stats'))<section class="section-about-us-info">
        <div class="container-main">
            <div data-w-id="6fcd4e0b-3ff9-370e-81f6-229d1417e516" class="about-us-info-component"
                style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                <div class="about-us-info-wrap">
                    <div class="about-us-info-list">
                        @foreach (\App\Models\Stat::forScope('service')->ordered()->get() as $stat)<div class="about-us-info-item">
                            <div class="about-us-info-title">@include('site.partials.stat-counter', ['withBreak' => $loop->first])</div>
                            <p class="gray-text">{{ $stat->label }}</p>
                        </div>@endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>@endif
    @if(cms_section_visible('services', 'our_process'))<section class="section-our-process">
        <div class="container-main">
            <div class="our-process-component">
                <div class="section-title-element our-process-title-element">
                    <div class="section-caption-wrap">
                        <div class="caption"
                            style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                            {{ cms('services.our_process.section_caption', 'MARKETING PROCESS') }}</div>
                    </div>
                    <div class="section-title-wrap">
                        <div class="text-align-right">
                            <div class="text-animation-block"
                                style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                                <h2>{{ cms('services.our_process.section_title', 'Successful Marketing Process') }}</h2>
                                <div class="text-overlay" style="will-change: width, height; width: 100%;"></div>
                                <div class="text-overlay row-02" style="will-change: width, height; width: 100%;">
                                </div>
                                <div class="text-overlay row-03" style="will-change: width, height; width: 100%;">
                                </div>
                                <div class="text-overlay row-04" style="will-change: width, height; width: 100%;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div data-w-id="eec6cf19-1a8e-3f95-1863-cb708ddf8ed8" class="our-process-list service-page-process-list"
                    style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                    @foreach (\App\Models\ProcessStep::forScope('service')->ordered()->get() as $step)<div class="our-process-item{{ $loop->first ? ' margin-left-none' : '' }}">
                        <div class="our-process-item-inner">
                            <div class="our-process-item-title our-process-title-big-on-mobile">{{ $step->title }}</div>
                            <p>Lorem ipsum dolor sit amet, consectetur elit.</p>
                        </div>
                        <div class="process-counting-wrap service-page-process-counting">
                            <div>{{ $step->number }}</div>
                        </div>
                    </div>@endforeach
                </div>
            </div>
        </div>
        <div class="horizontal-line-wrap">
            <div class="horizontal-line"
                style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
            </div>
        </div>
    </section>@endif
    @if(cms_section_visible('services', 'service_video'))<section class="section-service-video">
        <div class="container-main">
            <div data-w-id="a9a38eeb-a9f9-3829-b862-02e83cad83f3"
                style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 1; transform-style: preserve-3d;"
                class="service-video-wrap"><a href="#" data-w-id="ef7353a3-37bb-bb7a-8ab0-e82230bed01b"
                    class="service-video-lightbox w-inline-block w-lightbox" aria-label="open lightbox"
                    aria-haspopup="dialog"><img
                        src="{{ cms_image('services.service_video.video_thumbnail', '/era/media/webflow/66a671fa50dc9af69750f4cf_service-video-thumbnail.webp') }}"
                        loading="lazy"
                        sizes="(max-width: 479px) 93vw, (max-width: 767px) 90vw, (max-width: 991px) 92vw, (max-width: 1439px) 94vw, (max-width: 1919px) 96vw, 99vw"
                        srcset="/era/media/webflow/66a671fa50dc9af69750f4cf_service-video-thumbnail-p-500.webp 500w, /era/media/webflow/66a671fa50dc9af69750f4cf_service-video-thumbnail-p-800.webp 800w, /era/media/webflow/66a671fa50dc9af69750f4cf_service-video-thumbnail-p-1080.webp 1080w, /era/media/webflow/66a671fa50dc9af69750f4cf_service-video-thumbnail-p-1600.webp 1600w, /era/media/webflow/66a671fa50dc9af69750f4cf_service-video-thumbnail-p-2000.webp 2000w, /era/media/webflow/66a671fa50dc9af69750f4cf_service-video-thumbnail.webp 2480w"
                        alt="Service video thumbnail image" class="lightbox-thumbnail">
                    <div class="video-play-icon-wrap service-video-play-icon-wrap" style="opacity: 1;"><img
                            src="/era/media/webflow/664d7b64e6f014d2e2659c40_video-play.svg"
                            loading="lazy" alt="" class="video-play-icon"></div>
                    <script type="application/json" class="w-json">@json(cms_video('services.service_video.video_url', 'https://youtube.com/watch?v=r233kDWShkA'))</script>
                </a></div>
        </div>
        <div class="horizontal-line-wrap">
            <div class="horizontal-line"
                style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
            </div>
        </div>
    </section>@endif
    @if(cms_section_visible('services', 'faq'))<section class="section-faq">
        <div class="container-main">
            <div class="faq-component">
                <div class="faq-element">
                    <div class="faq-caption-wrap">
                        <div class="caption"
                            style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                            {{ cms('services.faq.section_caption', 'FAQ') }}</div>
                    </div>
                    <div class="faq-list"
                        style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                        <div class="faq-item">
                            <div class="faq-trigger">
                                <div class="faq-title" style="color: rgb(120, 120, 120);">WHAT SERVICES DOES PROVIDE
                                    THE era?</div>
                                <div class="faq-open-close-icon-wrap">
                                    <div class="faq-open-close-icon"
                                        style="color: rgb(120, 120, 120); transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                        </div>
                                </div>
                            </div>
                            <div class="faq-content-wrap" style="width: 100%; height: 0px;">
                                <div class="faq-content-inner">
                                    <p class="faq-content" style="color: rgb(120, 120, 120);">Lorem ipsum dolor sit
                                        amet, consectetur adipiscing elit. Maecenas quis malesuada nunc. Mauris
                                        accumsan ultricies tempus. Suspendisse cursus dui non libero malesuada, id
                                        dignissim lacus posuere. Aliquam eget lectus lobortis, rutrum tortor quis,
                                        tincidunt odio. Pellentesque et turpis viverra, vestibulum urna at.</p>
                                </div>
                            </div>
                        </div>
                        <div class="faq-item">
                            <div class="faq-trigger">
                                <div class="faq-title" style="color: rgb(120, 120, 120);">HOW CAN era BENEFITS MY
                                    BUSINESS</div>
                                <div class="faq-open-close-icon-wrap">
                                    <div class="faq-open-close-icon"
                                        style="color: rgb(120, 120, 120); transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                        </div>
                                </div>
                            </div>
                            <div class="faq-content-wrap" style="width: 100%; height: 0px;">
                                <div class="faq-content-inner">
                                    <p class="faq-content" style="color: rgb(120, 120, 120);">Lorem ipsum dolor sit
                                        amet, consectetur adipiscing elit. Maecenas quis malesuada nunc. Mauris
                                        accumsan ultricies tempus. Suspendisse cursus dui non libero malesuada, id
                                        dignissim lacus posuere. Aliquam eget lectus lobortis, rutrum tortor quis,
                                        tincidunt odio. Pellentesque et turpis viverra, vestibulum urna at.</p>
                                </div>
                            </div>
                        </div>
                        <div class="faq-item">
                            <div class="faq-trigger">
                                <div class="faq-title" style="color: rgb(120, 120, 120);">HOW DO YOU APPROACH
                                    STRATEGIC PLANNING?</div>
                                <div class="faq-open-close-icon-wrap">
                                    <div class="faq-open-close-icon"
                                        style="color: rgb(120, 120, 120); transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                        </div>
                                </div>
                            </div>
                            <div class="faq-content-wrap" style="width: 100%; height: 0px;">
                                <div class="faq-content-inner">
                                    <p class="faq-content" style="color: rgb(120, 120, 120);">Lorem ipsum dolor sit
                                        amet, consectetur adipiscing elit. Maecenas quis malesuada nunc. Mauris
                                        accumsan ultricies tempus. Suspendisse cursus dui non libero malesuada, id
                                        dignissim lacus posuere. Aliquam eget lectus lobortis, rutrum tortor quis,
                                        tincidunt odio. Pellentesque et turpis viverra, vestibulum urna at.</p>
                                </div>
                            </div>
                        </div>
                        <div class="faq-item">
                            <div class="faq-trigger">
                                <div class="faq-title" style="color: rgb(120, 120, 120);">HOW DOES era PROVIDE THE
                                    SECURITY?</div>
                                <div class="faq-open-close-icon-wrap">
                                    <div class="faq-open-close-icon"
                                        style="color: rgb(120, 120, 120); transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                        </div>
                                </div>
                            </div>
                            <div class="faq-content-wrap" style="width: 100%; height: 0px;">
                                <div class="faq-content-inner">
                                    <p class="faq-content" style="color: rgb(120, 120, 120);">Lorem ipsum dolor sit
                                        amet, consectetur adipiscing elit. Maecenas quis malesuada nunc. Mauris
                                        accumsan ultricies tempus. Suspendisse cursus dui non libero malesuada, id
                                        dignissim lacus posuere. Aliquam eget lectus lobortis, rutrum tortor quis,
                                        tincidunt odio. Pellentesque et turpis viverra, vestibulum urna at.</p>
                                </div>
                            </div>
                        </div>
                        <div class="faq-item">
                            <div class="faq-trigger">
                                <div class="faq-title" style="color: rgb(120, 120, 120);">WHAT IS THE TYPICAL
                                    TIMELINE FOR PROJECT DELIVERY?</div>
                                <div class="faq-open-close-icon-wrap">
                                    <div class="faq-open-close-icon"
                                        style="color: rgb(120, 120, 120); transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                        </div>
                                </div>
                            </div>
                            <div class="faq-content-wrap" style="width: 100%; height: 0px;">
                                <div class="faq-content-inner">
                                    <p class="faq-content" style="color: rgb(120, 120, 120);">Lorem ipsum dolor sit
                                        amet, consectetur adipiscing elit. Maecenas quis malesuada nunc. Mauris
                                        accumsan ultricies tempus. Suspendisse cursus dui non libero malesuada, id
                                        dignissim lacus posuere. Aliquam eget lectus lobortis, rutrum tortor quis,
                                        tincidunt odio. Pellentesque et turpis viverra, vestibulum urna at.</p>
                                </div>
                            </div>
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
    @if(cms_section_visible('services', 'our_clients'))<section data-w-id="979eb138-38b4-5f5c-7df2-418d23b3870f" class="section-our-clients">
        <div class="container-main">
            <div class="our-clients-logo-component">
                <div class="caption"
                    style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                    {{ cms('services.our_clients.section_caption', 'OUR CLIENTS') }}</div>
                <div class="our-clients-title-wrap">
                    <div class="text-animation-block"
                        style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                        <h2>{{ cms('services.our_clients.section_title', 'PROUD TO PARTNER WITH INDUSTRY-LEADING COMPANIES') }}</h2>
                        <div class="text-overlay" style="will-change: width, height; width: 100%;"></div>
                        <div class="text-overlay row-02" style="will-change: width, height; width: 100%;"></div>
                        <div class="text-overlay row-03" style="will-change: width, height; width: 100%;"></div>
                        <div class="text-overlay row-04" style="will-change: width, height; width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="client-logos-element">
            <div data-w-id="979eb138-38b4-5f5c-7df2-418d23b38718" class="client-logo-list"
                style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                <div class="client-logo-list-inner">
                    <div class="client-logo-item"
                        style="transform: translate3d(0%, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                        @foreach (\App\Models\Client::published()->where('row_group', 1)->ordered()->get() as $client)<div class="client-logo-wrap">
                            <div class="client-logo{{ $client->variant ? ' ' . $client->variant : '' }}">{{ $client->name }}</div>
                        </div>@endforeach
                    </div>
                    <div class="client-logo-item"
                        style="transform: translate3d(0%, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                        @foreach (\App\Models\Client::published()->where('row_group', 1)->ordered()->get() as $client)<div class="client-logo-wrap">
                            <div class="client-logo{{ $client->variant ? ' ' . $client->variant : '' }}">{{ $client->name }}</div>
                        </div>@endforeach
                    </div>
                </div>
                <div class="client-logo-list-inner">
                    <div class="client-logo-item"
                        style="transform: translate3d(0%, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                        @foreach (\App\Models\Client::published()->where('row_group', 2)->ordered()->get() as $client)<div class="client-logo-wrap">
                            <div class="client-logo{{ $client->variant ? ' ' . $client->variant : '' }}">{{ $client->name }}</div>
                        </div>@endforeach
                    </div>
                    <div class="client-logo-item"
                        style="transform: translate3d(0%, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                        @foreach (\App\Models\Client::published()->where('row_group', 2)->ordered()->get() as $client)<div class="client-logo-wrap">
                            <div class="client-logo{{ $client->variant ? ' ' . $client->variant : '' }}">{{ $client->name }}</div>
                        </div>@endforeach
                    </div>
                </div>
                <div class="client-logo-list-inner">
                    <div class="client-logo-item"
                        style="transform: translate3d(0%, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                        @foreach (\App\Models\Client::published()->where('row_group', 3)->ordered()->get() as $client)<div class="client-logo-wrap">
                            <div class="client-logo{{ $client->variant ? ' ' . $client->variant : '' }}">{{ $client->name }}</div>
                        </div>@endforeach
                    </div>
                    <div class="client-logo-item"
                        style="transform: translate3d(0%, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                        @foreach (\App\Models\Client::published()->where('row_group', 3)->ordered()->get() as $client)<div class="client-logo-wrap">
                            <div class="client-logo{{ $client->variant ? ' ' . $client->variant : '' }}">{{ $client->name }}</div>
                        </div>@endforeach
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
    @if(cms_section_visible('services', 'cta'))<section class="section-cta">
        <div class="container-main">
            <div class="max-width-930px">
                <div class="cta-component">
                    <div class="cta-title-wrap">
                        <div data-w-id="9a268fd0-8c98-cbd7-b73d-163a2aa21c2a" class="title-move-animation"
                            style="transform: translate3d(0px, 100%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                            <div class="text-gradient cta-text-gradient">
                                <div class="text-align-center">
                                    <h2 class="display-medium">{{ cms('services.cta.cta_title_line_1', 'START YOUR') }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cta-title-wrap">
                        <div data-w-id="93ad72e4-cc3e-2e24-6f93-9a3fc7f64ccd" class="title-move-animation"
                            style="transform: translate3d(0px, 100%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                            <div class="text-gradient cta-text-gradient">
                                <div class="text-align-center">
                                    <div class="display-medium">{{ cms('services.cta.cta_title_line_2', 'PROJECT NOW') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div data-w-id="fb3d8211-581b-e555-5949-cd34f550b0e3" class="cta-image-wrap" style="opacity: 0;">
                        <img src="{{ cms_image('services.cta.cta_image', '/era/media/webflow/664c7b819abdb2098fe1c195_cta-image.jpg') }}"
                            loading="lazy" sizes="100vw"
                            srcset="/era/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-500.jpg 500w, /era/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-800.jpg 800w, /era/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-1080.jpg 1080w, /era/media/webflow/664c7b819abdb2098fe1c195_cta-image.jpg 1395w"
                            alt="CTA image" class="full-image"></div><a {!! nav_active('/contact') ? 'aria-current="page"' : '' !!} data-w-id="84ff4b69-3bd5-a48a-06c2-d764252bc56d"
                        href="/contact" target="_blank"
                        class="primary-button w-inline-block{{ nav_active('/contact') ? ' w--current' : '' }}" style="border-color: rgba(255, 255, 255, 0.2);">
                        <div class="button-text-wrap">
                            <div class="button-text-inner"
                                style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                <div class="text-block">{{ cms('services.cta.cta_button_label', 'GET IT TOUCH') }}</div>
                                <div>{{ cms('services.cta.cta_button_label', 'GET IT TOUCH') }}</div>
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
