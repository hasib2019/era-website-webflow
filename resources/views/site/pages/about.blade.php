@extends('site.layouts.app')

@section('title', page_title('about', 'About Us'))
@section('wf_page', '66485cbdb8fe5b2ef09ac0c6')
@section('wf_site', '66485cbdb8fe5b2ef09ac0c3')

@section('content')
<header class="section-common-hero">
        <div class="container-main">
            <div class="common-hero-component">
                <div class="career-hero-content-wrap">
                    <div id="w-node-_19fc91ae-bd01-8b6c-8c60-7bc668b1159b-f09ac0c6" class="hero-title-wrap">
                        <div class="title-move-animation"
                            style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                            <div class="text-gradient">
                                <div class="display-large">{{ cms('about.about_hero.hero_title_line_1', 'creating true') }}</div>
                            </div>
                        </div>
                    </div>
                    <div id="w-node-_19fc91ae-bd01-8b6c-8c60-7bc668b11596-f09ac0c6"
                        class="hero-title-wrap z-index-none">
                        <div class="title-move-animation"
                            style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                            <div class="text-gradient">
                                <h1 class="display-large">{{ cms('about.about_hero.hero_title_line_2', 'expressions') }}</h1>
                            </div>
                        </div>
                    </div>
                    <div id="w-node-_1b2fc065-8385-1ce3-b848-04c8694eaaa8-f09ac0c6" class="hero-title-wrap">
                        <div class="title-move-animation"
                            style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                            <div class="text-gradient">
                                <div class="display-large">{{ cms('about.about_hero.hero_title_line_3', 'of brands') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div data-w-id="19fc91ae-bd01-8b6c-8c60-7bc668b115a0"
                    style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 1; transform-style: preserve-3d;"
                    class="about-us-hero-image-wrap">
                    <div id="w-node-_19fc91ae-bd01-8b6c-8c60-7bc668b115a1-f09ac0c6" class="career-hero-image-wrap"><img
                            src="{{ cms_image('about.about_hero.hero_image_primary', '/era/media/webflow/66a96bab029754bb653bd53c_about-us-image-1.webp') }}"
                            loading="lazy" sizes="(max-width: 1634px) 100vw, 1634px"
                            srcset="/era/media/webflow/66a96bab029754bb653bd53c_about-us-image-1-p-500.webp 500w, /era/media/webflow/66a96bab029754bb653bd53c_about-us-image-1-p-800.webp 800w, /era/media/webflow/66a96bab029754bb653bd53c_about-us-image-1-p-1080.webp 1080w, /era/media/webflow/66a96bab029754bb653bd53c_about-us-image-1-p-1600.webp 1600w, /era/media/webflow/66a96bab029754bb653bd53c_about-us-image-1.webp 1634w"
                            alt="about us image" class="full-image"></div>
                    <div class="career-hero-image-wrap hide-on-mobile"><img
                            src="{{ cms_image('about.about_hero.hero_image_secondary', '/era/media/webflow/66a96bab2657765525173560_about-us-image-2.webp') }}"
                            loading="lazy" sizes="(max-width: 784px) 100vw, 784px"
                            srcset="/era/media/webflow/66a96bab2657765525173560_about-us-image-2-p-500.webp 500w, /era/media/webflow/66a96bab2657765525173560_about-us-image-2.webp 784w"
                            alt="about us image" class="full-image"></div><a href="#team"
                        class="hero-round-text-wrap about-us-hero-round-text w-inline-block">
                        <div class="hero-round-icon-wrap"><img
                                src="{{ cms_image('about.about_hero.hero_badge_arrow_icon', '/era/media/webflow/66501c426d5623b1d6d38036_round-icon.png') }}"
                                loading="lazy" alt="Round icon" class="round-arrow-icon"></div><img
                            src="{{ cms_image('about.about_hero.hero_badge_round_text_image', '/era/media/webflow/66501c42caaf44099468db6d_hero-round-text.png') }}"
                            loading="lazy" alt="Hero round text" class="hero-round-text-image"
                            style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(272.401deg) skew(0deg); transform-style: preserve-3d; will-change: transform;">
                    </a>
                </div>
            </div>
        </div>
    </header>
    <section class="section-about-us-info">
        <div class="container-main">
            <div data-w-id="6fcd4e0b-3ff9-370e-81f6-229d1417e516" class="about-us-info-component"
                style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                <div class="about-us-info-wrap">
                    <div class="about-us-info-list">
                        @foreach (\App\Models\Stat::forScope('about')->ordered()->get() as $stat)<div class="about-us-info-item">
                            <div class="about-us-info-title">@include('site.partials.stat-counter', ['withBreak' => $loop->first])</div>
                            <p class="gray-text">{{ $stat->label }}</p>
                        </div>@endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-our-mission">
        <div class="container-main">
            <div class="our-mission-component">
                <div class="section-title-element our-mission-title-element">
                    <div class="section-caption-wrap">
                        <div class="caption"
                            style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                            {{ cms('about.our_mission.caption', 'MISSION/VISION') }}</div>
                    </div>
                    <div class="section-title-wrap">
                        <div class="text-align-right">
                            <div class="our-mission-content-block">
                                <div class="text-animation-block"
                                    style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                                    <h2>{{ cms('about.our_mission.mission_statement', 'Our mission at FABELS Agency is to empower our clients to achieve their business goals through innovative VR') }}</h2>
                                    <div class="text-overlay" style="will-change: width, height; width: 100%;"></div>
                                    <div class="text-overlay row-02" style="will-change: width, height; width: 100%;">
                                    </div>
                                    <div class="text-overlay row-03" style="will-change: width, height; width: 100%;">
                                    </div>
                                    <div class="text-overlay row-04" style="will-change: width, height; width: 100%;">
                                    </div>
                                </div>
                                <div class="text-animation-block"
                                    style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                                    <h2>{{ cms('about.our_mission.vision_statement', 'We pride ourselves on delightful interactions and experiences within beautiful interfaces and worlds.') }} </h2>
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
                </div>
            </div>
        </div>
        <div class="horizontal-line-wrap">
            <div class="horizontal-line"
                style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
            </div>
        </div>
    </section>
    <section id="team" class="section-our-team">
        <div class="container-main">
            <div class="team-component">
                <div class="section-title-element our-team-title-element">
                    <div class="section-caption-wrap">
                        <div class="caption"
                            style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                            {{ cms('about.our_team.caption', 'OUR TEAM') }}</div>
                    </div>
                    <div class="section-title-wrap">
                        <div class="text-align-right">
                            <div class="text-animation-block"
                                style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                                <h2>{{ cms('about.our_team.heading', 'A simple, yet powerful and  efficient process A systematic approach to digital marketing') }}</h2>
                                <div class="text-overlay" style="will-change: width, height; width: 100%;"></div>
                                <div class="text-overlay row-02" style="will-change: width, height; width: 100%;"></div>
                                <div class="text-overlay row-03" style="will-change: width, height; width: 100%;"></div>
                                <div class="text-overlay row-04" style="will-change: width, height; width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="our-team-list">
                    @foreach (\App\Models\TeamMember::published()->ordered()->get() as $member)<div class="our-team-item">
                        <div class="our-team-image-wrap"><img
                                src="{{ $member->image?->url }}"
                                loading="lazy"
                                alt="team image" class="full-image"></div>
                        <div class="our-team-info">
                            <div class="our-team-name-block">
                                <h3 class="team-member-name">{{ $member->name }}</h3><img
                                    src="/era/media/webflow/66a86668cd78441e18f50abe_team-plus-icon.svg"
                                    loading="lazy" alt="" class="team-plus-icon"
                                    style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                            </div>
                            <div class="team-social-info" style="width: 100%; height: 0px;">
                                <div class="team-social-inner"><a href="https://www.facebook.com/" target="_blank"
                                        class="social-icon w-inline-block">
                                        <div></div>
                                    </a><a href="https://twitter.com/" target="_blank"
                                        class="social-icon w-inline-block">
                                        <div></div>
                                    </a><a href="https://www.instagram.com/" target="_blank"
                                        class="social-icon w-inline-block">
                                        <div></div>
                                    </a></div>
                            </div>
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
    <section data-w-id="979eb138-38b4-5f5c-7df2-418d23b3870f" class="section-our-clients">
        <div class="container-main">
            <div class="our-clients-logo-component">
                <div class="caption"
                    style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                    {{ cms('about.our_clients.caption', 'OUR CLIENTS') }}</div>
                <div class="our-clients-title-wrap">
                    <div class="text-animation-block"
                        style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                        <h2>{{ cms('about.our_clients.heading', 'PROUD TO PARTNER WITH INDUSTRY-LEADING COMPANIES') }}</h2>
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
    </section>
    <section class="section-testimonial">
        <div class="container-main">
            <div class="testimonial-component">
                <h2 class="caption"
                    style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                    {{ cms('about.testimonials.caption', 'TESTIMONIALS') }}</h2>
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
    <section class="section-our-jobs">
        <div class="container-main">
            <div class="our-jobs-component">
                <div class="section-title-element">
                    <div class="section-caption-wrap">
                        <div class="caption"
                            style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                            {{ cms('about.our_jobs.caption', 'JOBS') }}</div>
                    </div>
                    <div class="section-title-wrap">
                        <div class="text-align-right">
                            <div class="text-animation-block"
                                style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                                <h2>{{ cms('about.our_jobs.heading', 'Opportunities to join our awesome team') }}</h2>
                                <div class="text-overlay" style="will-change: width, height; width: 100%;"></div>
                                <div class="text-overlay row-02" style="will-change: width, height; width: 100%;"></div>
                                <div class="text-overlay row-03" style="will-change: width, height; width: 100%;"></div>
                                <div class="text-overlay row-04" style="will-change: width, height; width: 100%;"></div>
                                <div class="text-overlay row-05" style="will-change: width, height; width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div data-w-id="517743ec-d544-e9b2-871d-67e7f1a7082d"
                    style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 0; transform-style: preserve-3d;"
                    class="jobs-collection-wrap">
                    <div class="w-dyn-list">
                        <div role="list" class="w-dyn-items">
                            <div role="listitem" class="job-collection-item w-dyn-item">
                                <div class="job-item-inner">
                                    <div class="job-item-info-wrap">
                                        <div class="job-item-title" style="color: rgb(120, 120, 120);">Social media
                                            marketer</div>
                                        <div class="job-info">
                                            <div class="job-info-text" style="color: rgb(120, 120, 120);">new york</div>
                                            <div class="job-info-text" style="color: rgb(120, 120, 120);">Full time
                                            </div>
                                        </div>
                                    </div>
                                    <div id="w-node-_517743ec-d544-e9b2-871d-67e7f1a70837-f09ac0c6"
                                        class="job-apply-button-wrap"><a {!! nav_active('/career/brand-expert') ? 'aria-current="page"' : '' !!}
                                            data-w-id="84ff4b69-3bd5-a48a-06c2-d764252bc56d"
                                            href="/career/brand-expert" class="primary-button w-inline-block{{ nav_active('/career/brand-expert') ? ' w--current' : '' }}"
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
                            </div>
                            <div role="listitem" class="job-collection-item w-dyn-item">
                                <div class="job-item-inner">
                                    <div class="job-item-info-wrap">
                                        <div class="job-item-title" style="color: rgb(120, 120, 120);">Senior SEO expert
                                        </div>
                                        <div class="job-info">
                                            <div class="job-info-text" style="color: rgb(120, 120, 120);">new york</div>
                                            <div class="job-info-text" style="color: rgb(120, 120, 120);">Full time
                                            </div>
                                        </div>
                                    </div>
                                    <div id="w-node-_517743ec-d544-e9b2-871d-67e7f1a70837-f09ac0c6"
                                        class="job-apply-button-wrap"><a {!! nav_active('/career/brand-expert') ? 'aria-current="page"' : '' !!}
                                            data-w-id="84ff4b69-3bd5-a48a-06c2-d764252bc56d"
                                            href="/career/brand-expert" class="primary-button w-inline-block{{ nav_active('/career/brand-expert') ? ' w--current' : '' }}"
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
                            </div>
                            <div role="listitem" class="job-collection-item w-dyn-item">
                                <div class="job-item-inner">
                                    <div class="job-item-info-wrap">
                                        <div class="job-item-title" style="color: rgb(120, 120, 120);">Content writer
                                        </div>
                                        <div class="job-info">
                                            <div class="job-info-text" style="color: rgb(120, 120, 120);">new york</div>
                                            <div class="job-info-text" style="color: rgb(120, 120, 120);">Full time
                                            </div>
                                        </div>
                                    </div>
                                    <div id="w-node-_517743ec-d544-e9b2-871d-67e7f1a70837-f09ac0c6"
                                        class="job-apply-button-wrap"><a {!! nav_active('/career/brand-expert') ? 'aria-current="page"' : '' !!}
                                            data-w-id="84ff4b69-3bd5-a48a-06c2-d764252bc56d" href="/career/brand-expert"
                                            class="primary-button w-inline-block{{ nav_active('/career/brand-expert') ? ' w--current' : '' }}"
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
                            </div>
                            <div role="listitem" class="job-collection-item w-dyn-item">
                                <div class="job-item-inner">
                                    <div class="job-item-info-wrap">
                                        <div class="job-item-title" style="color: rgb(120, 120, 120);">Brand expert
                                        </div>
                                        <div class="job-info">
                                            <div class="job-info-text" style="color: rgb(120, 120, 120);">new york</div>
                                            <div class="job-info-text" style="color: rgb(120, 120, 120);">Full time
                                            </div>
                                        </div>
                                    </div>
                                    <div id="w-node-_517743ec-d544-e9b2-871d-67e7f1a70837-f09ac0c6"
                                        class="job-apply-button-wrap"><a {!! nav_active('/career/brand-expert') ? 'aria-current="page"' : '' !!}
                                            data-w-id="84ff4b69-3bd5-a48a-06c2-d764252bc56d" href="/career/brand-expert"
                                            class="primary-button w-inline-block{{ nav_active('/career/brand-expert') ? ' w--current' : '' }}"
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
                                    <h2 class="display-medium">{{ cms('about.cta.cta_title_line_1', 'START YOUR') }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cta-title-wrap">
                        <div data-w-id="93ad72e4-cc3e-2e24-6f93-9a3fc7f64ccd" class="title-move-animation"
                            style="transform: translate3d(0px, 100%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                            <div class="text-gradient cta-text-gradient">
                                <div class="text-align-center">
                                    <div class="display-medium">{{ cms('about.cta.cta_title_line_2', 'PROJECT NOW') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div data-w-id="fb3d8211-581b-e555-5949-cd34f550b0e3" class="cta-image-wrap" style="opacity: 0;">
                        <img src="{{ cms_image('about.cta.cta_image', '/era/media/webflow/664c7b819abdb2098fe1c195_cta-image.jpg') }}"
                            loading="lazy" sizes="100vw"
                            srcset="/era/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-500.jpg 500w, /era/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-800.jpg 800w, /era/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-1080.jpg 1080w, /era/media/webflow/664c7b819abdb2098fe1c195_cta-image.jpg 1395w"
                            alt="CTA image" class="full-image"></div><a {!! nav_active('/contact') ? 'aria-current="page"' : '' !!} data-w-id="84ff4b69-3bd5-a48a-06c2-d764252bc56d"
                        href="/contact" target="_blank"
                        class="primary-button w-inline-block{{ nav_active('/contact') ? ' w--current' : '' }}" style="border-color: rgba(255, 255, 255, 0.2);">
                        <div class="button-text-wrap">
                            <div class="button-text-inner"
                                style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                <div class="text-block">{{ cms('about.cta.cta_button_label', 'GET IT TOUCH') }}</div>
                                <div>{{ cms('about.cta.cta_button_label', 'GET IT TOUCH') }}</div>
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
