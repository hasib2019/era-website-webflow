@extends('site.layouts.app')

@section('title', page_title('home', 'Home'))
@section('wf_page', '66485cbdb8fe5b2ef09ac0c2')
@section('wf_site', '66485cbdb8fe5b2ef09ac0c3')
@section('cursor')
@include('site.partials.cursor', ['cursorClass' => 'cursor load-on-scroll'])
@endsection

@section('content')
<header data-w-id="2148083c-5a88-2722-4e3b-37b4a1eb45bd" class="section-home-hero">
        <div class="container-main">
            <div class="home-hero-component">
                <div class="home-hero-element">
                    <div id="hero-line-1"
                        class="hero-title-wrap z-index-none">
                        <div style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 1; transform-style: preserve-3d;"
                            class="title-move-animation ">
                            <div class="text-gradient">
                                <h1 class="display-large">{{ cms('home.home_hero.hero_title_line_1', 'provide The') }}</h1>
                            </div>
                        </div>
                    </div>
                    <div id="hero-line-2" class="hero-title-wrap">
                        <div style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 1; transform-style: preserve-3d;"
                            class="title-move-animation">
                            <div class="text-gradient">
                                <div class="display-large">{{ cms('home.home_hero.hero_title_line_2', 'best ranking') }}</div>
                            </div>
                        </div>
                    </div>
                    <div id="hero-line-3" class="hero-title-wrap">
                        <div style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 1; transform-style: preserve-3d;"
                            class="title-move-animation">
                            <div class="text-gradient">
                                <div class="display-large">{{ cms('home.home_hero.hero_title_line_3', 'Experience') }}</div>
                            </div>
                        </div>
                    </div>
                    <div id="id_hero-title-wrap" class="hero-title-wrap">
                        <p data-w-id="ef9124bf-77e8-79d6-ba7b-d69dbee3728f"
                            style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 1; transform-style: preserve-3d;"
                            class="home-hero-para">{{ cms('home.home_hero.hero_paragraph', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Faucibus ante velit nunc') }}</p>
                    </div>
                    <div class="hero-title-wrap">
                        <p data-w-id="8291a6a2-6ca8-df2b-5ce1-6b641e1cf7e0"
                            style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                            {{ cms('home.home_hero.hero_tagline', 'Marketing Design Agency since 1988') }}</p>
                    </div>
                    <div id="w-node-_8180ad61-f75c-6c01-5016-22828d663093-f09ac0c2" class="hero-title-wrap">
                        <div data-w-id="ed5a3aa6-b06a-604a-3bf8-49a8d0dcaa18"
                            style="opacity: 1; transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;"
                            class="home-hero-button-wrap"><a {!! nav_active('/contact') ? 'aria-current="page"' : '' !!} data-w-id="84ff4b69-3bd5-a48a-06c2-d764252bc56d"
                                href="/contact" class="primary-button w-inline-block{{ nav_active('/contact') ? ' w--current' : '' }}"
                                style="border-color: rgba(255, 255, 255, 0.2);">
                                <div class="button-text-wrap">
                                    <div class="button-text-inner"
                                        style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                        <div class="text-block">{{ cms('home.home_hero.hero_button_label', 'LET’S TALK') }}</div>
                                        <div>{{ cms('home.home_hero.hero_button_label', 'LET’S TALK') }}</div>
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
                <div data-w-id="1cdc3515-9b69-d8e5-eafb-ce4163077016"
                    style="opacity: 1; transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;"
                    class="home-hero-image-wrap">
                    <img src="{{ cms_image('home.home_hero.hero_image', '/site/images/home-hero-image.jpg') }}" loading="lazy" sizes="(max-width: 479px) 100vw, (max-width: 767px) 54vw, (max-width: 991px) 40vw, 493px"
                        srcset="/site/images/home-hero-image-p-500.jpg 500w, /site/images/home-hero-image.jpg 741w"
                        alt="Home hero image" class="image">
                    <a data-w-id="c868fe40-8193-7925-a7ad-53ff469463d6" style="opacity: 1;" href="#case-study" class="hero-round-text-wrap w-inline-block">
                        <div class="hero-round-icon-wrap"> 
                            <img src="{{ cms_image('home.home_hero.hero_round_icon', '/site/images/icons/round-icon.png') }}" loading="lazy" alt="Round icon" class="round-arrow-icon">
                        </div>
                        <img src="{{ cms_image('home.home_hero.hero_round_text_image', '/site/images/icons/hero-round-text.png') }}" loading="lazy" alt="Hero round text" class="hero-round-text-image" style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(87.2028deg) skew(0deg); transform-style: preserve-3d; will-change: transform;">
                    </a>
                </div>
            </div>
        </div>
        <div class="horizontal-line-wrap">
            <div class="horizontal-line"
                style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
            </div>
        </div>
    </header>
    <section data-w-id="53a1557a-a5dc-677e-bbe6-7708ef9f1c9e" class="section-home-about-us">
        <div class="container-main">
            <div class="home-about-us-component">
                <div class="home-about-us-element">
                    <div id="w-node-_5683a303-6a9e-12ed-1839-7ffe7b5b3eef-f09ac0c2" class="caption"
                        style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                        {{ cms('home.home_about_us.caption', 'ABOUT US') }}</div>
                    <div id="w-node-_77d354db-51d6-5e2a-1b83-495d25f56242-f09ac0c2" class="home-about-us-content">
                        <div class="text-align-right">
                            <div class="text-animation-block"
                                style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                                <h2>{{ cms('home.home_about_us.heading', 'Discover the future of marketing with FAVLES, your trusted partner in innovative digital solutions. Our cutting-edge website offers a dynamic platform') }}</h2>
                                <div data-w-id="fef22dc4-3f3b-b686-a687-78a998cf1b5e" class="text-overlay"
                                    style="will-change: width, height; width: 100%;"></div>
                                <div class="text-overlay row-02" style="will-change: width, height; width: 100%;"></div>
                                <div class="text-overlay row-03" style="will-change: width, height; width: 100%;"></div>
                                <div class="text-overlay row-04" style="will-change: width, height; width: 100%;"></div>
                                <div class="text-overlay row-05" style="will-change: width, height; width: 100%;"></div>
                                <div class="text-overlay row-06" style="will-change: width, height; width: 100%;"></div>
                                <div class="text-overlay row-07" style="will-change: width, height; width: 100%;"></div>
                            </div>
                        </div>
                        <div class="home-about-us-info-wrap">
                            <div class="about-us-info-wrap">
                                <div class="about-us-info-list">
                                    @foreach (\App\Models\Stat::forScope('home')->ordered()->get() as $stat)<div class="about-us-info-item">
                                        <div class="about-us-info-title">@include('site.partials.stat-counter', ['withBreak' => $loop->first])</div>
                                        <p class="gray-text">{{ $stat->label }}</p>
                                    </div>@endforeach
                                </div>
                            </div>
                        </div>
                        <div data-w-id="2c20399a-82f8-c9ea-8c7f-33c1b402bb1d"
                            style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 0; transform-style: preserve-3d;"
                            class="text-align-right"><a {!! nav_active('/contact') ? 'aria-current="page"' : '' !!} data-w-id="84ff4b69-3bd5-a48a-06c2-d764252bc56d"
                                href="{{ cms_url('home.home_about_us.button_url', '/contact') }}" class="primary-button w-inline-block{{ nav_active('/contact') ? ' w--current' : '' }}"
                                style="border-color: rgba(255, 255, 255, 0.2);">
                                <div class="button-text-wrap">
                                    <div class="button-text-inner"
                                        style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                        <div class="text-block">{{ cms('home.home_about_us.button_label', 'GET TO KNOW US') }}</div>
                                        <div>{{ cms('home.home_about_us.button_label', 'GET TO KNOW US') }}</div>
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
        </div>
        <div class="horizontal-line-wrap">
            <div class="horizontal-line"
                style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
            </div>
        </div>
    </section>
    <section class="section-home-video">
        <div class="container-main">
            <div class="home-video-element"><a href="#" data-w-id="c3481595-905d-439d-a04b-32df4c47acce"
                    class="video-lightbox w-inline-block w-lightbox"
                    style="will-change: transform; transform: translate3d(-160px, -1000px, 0px) scale3d(0.3, 0.3, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;"
                    aria-label="open lightbox" aria-haspopup="dialog"><img
                        src="{{ cms_image('home.home_video.video_thumbnail', '/era/media/webflow/66a671fa50dc9af69750f4cf_service-video-thumbnail.webp') }}"
                        loading="lazy"
                        sizes="(max-width: 479px) 100vw, (max-width: 767px) 90vw, (max-width: 991px) 92vw, (max-width: 1439px) 94vw, (max-width: 1919px) 96vw, 99vw"
                        srcset="/era/media/webflow/66a671fa50dc9af69750f4cf_service-video-thumbnail-p-500.webp 500w, /era/media/webflow/66a671fa50dc9af69750f4cf_service-video-thumbnail-p-800.webp 800w, /era/media/webflow/66a671fa50dc9af69750f4cf_service-video-thumbnail-p-1080.webp 1080w, /era/media/webflow/66a671fa50dc9af69750f4cf_service-video-thumbnail-p-1600.webp 1600w, /era/media/webflow/66a671fa50dc9af69750f4cf_service-video-thumbnail-p-2000.webp 2000w, /era/media/webflow/66a671fa50dc9af69750f4cf_service-video-thumbnail.webp 2480w"
                        alt="Service video thumbnail image" class="image">
                    <div style="opacity: 1;" class="video-play-icon-wrap"><img
                            src="{{ cms_image('home.home_video.video_play_icon', '/era/media/webflow/664d7b64e6f014d2e2659c40_video-play.svg') }}"
                            loading="lazy" alt="" class="video-play-icon"></div>
                    <script type="application/json" class="w-json">{
  "items": [
    {
      "url": "https://youtube.com/watch?v=r233kDWShkA",
      "originalUrl": "https://youtube.com/watch?v=r233kDWShkA",
      "width": 940,
      "height": 528,
      "thumbnailUrl": "https://i.ytimg.com/vi/r233kDWShkA/hqdefault.jpg",
      "html": "<iframe class=\"embedly-embed\" src=\"//cdn.embedly.com/widgets/media.html?src=https%3A%2F%2Fwww.youtube.com%2Fembed%2Fr233kDWShkA%3Ffeature%3Doembed&display_name=YouTube&url=https%3A%2F%2Fwww.youtube.com%2Fwatch%3Fv%3Dr233kDWShkA&image=https%3A%2F%2Fi.ytimg.com%2Fvi%2Fr233kDWShkA%2Fhqdefault.jpg&key=96f1f04c5f4143bcb0f2e68c87d65feb&type=text%2Fhtml&schema=youtube\" width=\"940\" height=\"528\" scrolling=\"no\" title=\"YouTube embed\" frameborder=\"0\" allow=\"autoplay; fullscreen; encrypted-media; picture-in-picture;\" allowfullscreen=\"true\"></iframe>",
      "type": "video"
    }
  ],
  "group": ""
}</script>
                </a></div>
        </div>
        <div class="horizontal-line-wrap">
            <div class="horizontal-line"
                style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
            </div>
        </div>
    </section>
    <section class="section-service">
        <div class="container-main">
            <div class="service-component">
                <div class="service-section-caption-wrap">
                    <h2 class="caption"
                        style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                        {{ cms('home.home_services.caption', 'SERVICES') }}</h2>
                </div>
                <div data-w-id="be10eac0-f33f-85de-d8c0-cd7eeb04d68a" class="service-collection-list-wrapper w-dyn-list"
                    style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
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
    </section>
    <section id="case-study" class="section-case-study">
        <div class="container-main">
            <div class="case-study-component">
                <h2 class="caption"
                    style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                    {{ cms('home.home_case_study.caption', 'CASE STUDY') }}</h2>
                <div class="case-study-element">
                    <div class="w-dyn-list">
                        <div role="list" class="w-dyn-items">
                            @foreach (\App\Models\CaseStudy::published()->ordered()->take(3)->get() as $study)<div role="listitem" class="case-study-collection-item w-dyn-item"
                                style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                                <a {!! nav_active('/case-studies/event-planning-and-management') ? 'aria-current="page"' : '' !!} href="{{ route('case-studies.show', $study->slug) }}"
                                    class="case-study-image-wrap w-inline-block{{ nav_active('/case-studies/event-planning-and-management') ? ' w--current' : '' }}"><img
                                        src="{{ $study->image?->url }}"
                                        loading="lazy" alt=""
                                        class="full-image"></a>
                                <div id="w-node-_0815d970-abde-a912-bf09-59715d3d53e9-f09ac0c2"
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
                    <div data-w-id="24d703d0-1aae-2fb7-d964-d55807bb8f67"
                        style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 0; transform-style: preserve-3d;"
                        class="view-all-case-study-button-wrap"><a {!! nav_active('/case-studies') ? 'aria-current="page"' : '' !!} data-w-id="84ff4b69-3bd5-a48a-06c2-d764252bc56d"
                            href="/case-studies" class="primary-button w-inline-block{{ nav_active('/case-studies') ? ' w--current' : '' }}"
                            style="border-color: rgba(255, 255, 255, 0.2);">
                            <div class="button-text-wrap">
                                <div class="button-text-inner"
                                    style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                    <div class="text-block">{{ cms('home.home_case_study.button_label', 'VIEW ALL CASE STUDY') }}</div>
                                    <div>{{ cms('home.home_case_study.button_label', 'VIEW ALL CASE STUDY') }}</div>
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
        <div class="horizontal-line-wrap position-top">
            <div class="horizontal-line"
                style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
            </div>
        </div>
        <div class="horizontal-line-wrap">
            <div class="horizontal-line"
                style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
            </div>
        </div>
    </section>
    <section class="section-our-process">
        <div class="container-main">
            <div class="our-process-component">
                <div class="our-process-title-element home-page-process-title">
                    <div class="caption"
                        style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                        {{ cms('home.home_process.caption', 'PROCESS') }}</div>
                    <div class="text-align-right">
                        <div class="text-animation-block"
                            style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                            <h2>{{ cms('home.home_process.heading', 'A SIMPLE, YET POWERFUL AND EFFICIENT PROCESS; A SYSTEMATIC APPROACH TO DIGITAL MARKETING') }}
                            </h2>
                            <div class="text-overlay" style="will-change: width, height; width: 100%;"></div>
                            <div class="text-overlay row-02" style="will-change: width, height; width: 100%;"></div>
                            <div class="text-overlay row-03" style="will-change: width, height; width: 100%;"></div>
                            <div class="text-overlay row-04" style="will-change: width, height; width: 100%;"></div>
                        </div>
                    </div>
                </div>
                <div data-w-id="0670aef5-e717-741f-56f2-9b86c49790d3"
                    style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 0; transform-style: preserve-3d;"
                    class="our-process-list">
                    @foreach (\App\Models\ProcessStep::forScope('home')->ordered()->get() as $step)<div class="our-process-item{{ $loop->first ? ' margin-left-none' : '' }}">
                        <div class="our-process-item-title">{{ $step->title }}</div>
                        <div class="process-counting-wrap">
                            <div>{{ $step->number }}</div>
                        </div>
                    </div>@endforeach
                </div>
            </div>
        </div>
        <div class="horizontal-line-wrap">
            <div class="horizontal-line"
                style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
            </div>
        </div>
    </section>
    <section class="section-testimonial">
        <div class="container-main">
            <div class="testimonial-component">
                <h2 class="caption"
                    style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                    {{ cms('home.home_testimonials.caption', 'TESTIMONIALS') }}</h2>
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
    </section>
    <section class="home-latest-blog">
        <div class="container-main">
            <div class="blog-component">
                <div class="blog-section-title-wrap">
                    <div id="w-node-_4e6796ed-5a35-3b0c-04fe-7c88635c92c3-635c92bf" class="caption"
                        style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                        {{ cms('home.home_latest_blog.caption', 'BLOG/ARTICLES') }}</div>
                    <div class="text-align-right">
                        <div class="text-animation-block"
                            style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                            <h2>{{ cms('home.home_latest_blog.heading', 'Browse our latest news and resources') }}</h2>
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
                            <div role="listitem" class="blog-collection-item w-dyn-item"
                                style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                                <div class="blog-item">
                                    <div id="w-node-_4e6796ed-5a35-3b0c-04fe-7c88635c92cd-635c92bf"
                                        class="blog-content-wrap">
                                        <div class="blog-info-wrap blog-item-info-wrap">
                                            <div class="blog-info"><img
                                                    src="/era/media/webflow/66507334b279af4803571b92_calender-icon.png"
                                                    loading="lazy" alt="">
                                                <p class="font-weight-medium">Jul 10, 2024</p>
                                            </div>
                                            <div class="blog-info"><img
                                                    src="/era/media/webflow/66507334a301d18ef9aa933f_time-icon.png"
                                                    loading="lazy" alt="">
                                                <div class="blog-info-content-wrap">
                                                    <p class="font-weight-medium">6</p>
                                                    <p class="font-weight-medium">min read</p>
                                                </div>
                                            </div>
                                        </div>
                                        <h3 class="blog-title" style="color: rgb(120, 120, 120);">Navigating search
                                            algorithms for regional impact</h3>
                                        <div class="blog-post-summary-wrap">
                                            <p class="blog-post-summary">Lorem ipsum dolor sit amet, consecteturor
                                                adipiscing elit. Tincidunt donec vulputate ipsum erat urna auctor. Eget
                                                phasellus ideirs. </p>
                                        </div><a {!! nav_active('/blog/navigating-search-algorithms-for-regional-impact') ? 'aria-current="page"' : '' !!} data-w-id="84ff4b69-3bd5-a48a-06c2-d764252bc56d"
                                            href="/blog/navigating-search-algorithms-for-regional-impact"
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
                                            src="/era/media/webflow/66876a195c4a30e89f362732_blog-image-1.webp"
                                            loading="lazy" alt="This is a nice image"
                                            sizes="(max-width: 479px) 100vw, (max-width: 767px) 90vw, (max-width: 1439px) 40vw, (max-width: 1919px) 41vw, 44vw"
                                            srcset="/era/media/webflow/66876a195c4a30e89f362732_blog-image-1-p-500.webp 500w, /era/media/webflow/66876a195c4a30e89f362732_blog-image-1-p-800.webp 800w, /era/media/webflow/66876a195c4a30e89f362732_blog-image-1-p-1080.webp 1080w, /era/media/webflow/66876a195c4a30e89f362732_blog-image-1.webp 1240w"
                                            class="blog-image"
                                            style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                    </div>
                                </div>
                            </div>
                            <div role="listitem" class="blog-collection-item w-dyn-item"
                                style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                                <div class="blog-item">
                                    <div id="w-node-_4e6796ed-5a35-3b0c-04fe-7c88635c92cd-635c92bf"
                                        class="blog-content-wrap">
                                        <div class="blog-info-wrap blog-item-info-wrap">
                                            <div class="blog-info"><img
                                                    src="/era/media/webflow/66507334b279af4803571b92_calender-icon.png"
                                                    loading="lazy" alt="">
                                                <p class="font-weight-medium">Jul 10, 2024</p>
                                            </div>
                                            <div class="blog-info"><img
                                                    src="/era/media/webflow/66507334a301d18ef9aa933f_time-icon.png"
                                                    loading="lazy" alt="">
                                                <div class="blog-info-content-wrap">
                                                    <p class="font-weight-medium">6</p>
                                                    <p class="font-weight-medium">min read</p>
                                                </div>
                                            </div>
                                        </div>
                                        <h3 class="blog-title" style="color: rgb(120, 120, 120);">How to increase your
                                            twitter reach by this simple trick</h3>
                                        <div class="blog-post-summary-wrap">
                                            <p class="blog-post-summary">Lorem ipsum dolor sit amet, consecteturor
                                                adipiscing elit. Tincidunt donec vulputate ipsum erat urna auctor. Eget
                                                phasellus ideirs.</p>
                                        </div><a {!! nav_active('/blog/navigating-search-algorithms-for-regional-impact') ? 'aria-current="page"' : '' !!} data-w-id="84ff4b69-3bd5-a48a-06c2-d764252bc56d"
                                            href="/blog/navigating-search-algorithms-for-regional-impact"
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
                                            src="/era/media/webflow/66876a27d9a22ea2e9b0e272_blog-image-2.webp"
                                            loading="lazy" alt="This is a nice image"
                                            sizes="(max-width: 479px) 100vw, (max-width: 767px) 90vw, (max-width: 1439px) 40vw, (max-width: 1919px) 41vw, 44vw"
                                            srcset="/era/media/webflow/66876a27d9a22ea2e9b0e272_blog-image-2-p-500.webp 500w, /era/media/webflow/66876a27d9a22ea2e9b0e272_blog-image-2-p-800.webp 800w, /era/media/webflow/66876a27d9a22ea2e9b0e272_blog-image-2-p-1080.webp 1080w, /era/media/webflow/66876a27d9a22ea2e9b0e272_blog-image-2.webp 1240w"
                                            class="blog-image"
                                            style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                    </div>
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
                                    <h2 class="display-medium">{{ cms('home.home_cta.cta_title_line_1', 'START YOUR') }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cta-title-wrap">
                        <div data-w-id="93ad72e4-cc3e-2e24-6f93-9a3fc7f64ccd" class="title-move-animation"
                            style="transform: translate3d(0px, 100%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                            <div class="text-gradient cta-text-gradient">
                                <div class="text-align-center">
                                    <div class="display-medium">{{ cms('home.home_cta.cta_title_line_2', 'PROJECT NOW') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div data-w-id="fb3d8211-581b-e555-5949-cd34f550b0e3" class="cta-image-wrap" style="opacity: 0;">
                        <img src="{{ cms_image('home.home_cta.cta_image', '/era/media/webflow/664c7b819abdb2098fe1c195_cta-image.jpg') }}"
                            loading="lazy" sizes="100vw"
                            srcset="/era/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-500.jpg 500w, /era/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-800.jpg 800w, /era/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-1080.jpg 1080w, /era/media/webflow/664c7b819abdb2098fe1c195_cta-image.jpg 1395w"
                            alt="CTA image" class="full-image"></div><a {!! nav_active('/contact') ? 'aria-current="page"' : '' !!} data-w-id="84ff4b69-3bd5-a48a-06c2-d764252bc56d"
                        href="/contact" target="_blank"
                        class="primary-button w-inline-block{{ nav_active('/contact') ? ' w--current' : '' }}" style="border-color: rgba(255, 255, 255, 0.2);">
                        <div class="button-text-wrap">
                            <div class="button-text-inner"
                                style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                <div class="text-block">{{ cms('home.home_cta.cta_button_label', 'GET IT TOUCH') }}</div>
                                <div>{{ cms('home.home_cta.cta_button_label', 'GET IT TOUCH') }}</div>
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
