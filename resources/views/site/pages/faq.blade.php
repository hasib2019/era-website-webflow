@extends('site.layouts.app')

@section('title', 'FAQ')
@section('wf_page', '66485cbdb8fe5b2ef09ac0c6')
@section('wf_site', '66485cbdb8fe5b2ef09ac0c3')

@section('content')
<header class="section-common-hero">
        <div class="container-main">
            <div class="common-hero-component">
                <div class="common-hero-element">
                    <div id="w-node-_831e41e0-f952-34e2-a6e9-15913a3ea116-f09ac0cd" class="hero-title-wrap">
                        <div class="title-move-animation"
                            style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                            <div class="text-gradient">
                                <div class="display-large">{{ cms('faq.faq_common_hero.hero_title_line_1', 'Frequently') }}</div>
                            </div>
                        </div>
                    </div>
                    <div id="w-node-_994ab409-0497-8698-ef49-a62e07da2d70-f09ac0cd" class="hero-title-wrap">
                        <div class="title-move-animation"
                            style="transform: translate3d(0px, 100%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                            <div class="text-gradient">
                                <div class="display-large">{{ cms('faq.faq_common_hero.hero_title_line_2', 'asked') }}</div>
                            </div>
                        </div>
                    </div>
                    <div id="w-node-_831e41e0-f952-34e2-a6e9-15913a3ea11b-f09ac0cd" class="content-group">
                        <div class="content-group-title-wrap">
                            <div class="hero-title-wrap">
                                <div class="title-move-animation"
                                    style="transform: translate3d(0px, 100%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                                    <div class="text-gradient">
                                        <div class="display-large">{{ cms('faq.faq_common_hero.hero_title_line_3', 'question') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="w-node-_831e41e0-f952-34e2-a6e9-15913a3ea122-f09ac0cd" class="content-group-para-wrap"
                            style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                            <p class="hero-para">{{ cms('faq.faq_common_hero.hero_paragraph', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin volutpat velit in lorem feugiat.') }}</p>
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
    </header>
    <section class="section-faq">
        <div class="container-main">
            <div class="faq-component">
                <div class="faq-element">
                    <div class="faq-caption-wrap">
                        <div class="caption"
                            style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                            {{ cms('faq.faq_accordion.faq_caption', 'FAQ') }}</div>
                    </div>
                    <div class="faq-list"
                        style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                        @foreach (\App\Models\Faq::published()->ordered()->get() as $faq)<div class="faq-item">
                            <div class="faq-trigger">
                                <div class="faq-title" style="color: rgb(120, 120, 120);">{{ $faq->question }}</div>
                                <div class="faq-open-close-icon-wrap">
                                    <div class="faq-open-close-icon"
                                        style="color: rgb(120, 120, 120); transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                        </div>
                                </div>
                            </div>
                            <div class="faq-content-wrap" style="width: 100%; height: 0px;">
                                <div class="faq-content-inner">
                                    <p class="faq-content" style="color: rgb(120, 120, 120);">{!! $faq->answer !!}</p>
                                </div>
                            </div>
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
    <section class="section-cta">
        <div class="container-main">
            <div class="max-width-930px">
                <div class="cta-component">
                    <div class="cta-title-wrap">
                        <div data-w-id="9a268fd0-8c98-cbd7-b73d-163a2aa21c2a" class="title-move-animation"
                            style="transform: translate3d(0px, 100%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                            <div class="text-gradient cta-text-gradient">
                                <div class="text-align-center">
                                    <h2 class="display-medium">{{ cms('faq.faq_cta.cta_title_line_1', 'START YOUR') }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cta-title-wrap">
                        <div data-w-id="93ad72e4-cc3e-2e24-6f93-9a3fc7f64ccd" class="title-move-animation"
                            style="transform: translate3d(0px, 100%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                            <div class="text-gradient cta-text-gradient">
                                <div class="text-align-center">
                                    <div class="display-medium">{{ cms('faq.faq_cta.cta_title_line_2', 'PROJECT NOW') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div data-w-id="fb3d8211-581b-e555-5949-cd34f550b0e3" class="cta-image-wrap" style="opacity: 0;">
                        <img src="{{ cms_image('faq.faq_cta.cta_image', '/storage/media/webflow/664c7b819abdb2098fe1c195_cta-image.jpg') }}"
                            loading="lazy" sizes="100vw"
                            srcset="/storage/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-500.jpg 500w, /storage/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-800.jpg 800w, /storage/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-1080.jpg 1080w, /storage/media/webflow/664c7b819abdb2098fe1c195_cta-image.jpg 1395w"
                            alt="CTA image" class="full-image"></div><a {!! nav_active('/contact') ? 'aria-current="page"' : '' !!} data-w-id="84ff4b69-3bd5-a48a-06c2-d764252bc56d"
                        href="/contact" target="_blank"
                        class="primary-button w-inline-block{{ nav_active('/contact') ? ' w--current' : '' }}" style="border-color: rgba(255, 255, 255, 0.2);">
                        <div class="button-text-wrap">
                            <div class="button-text-inner"
                                style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                <div class="text-block">{{ cms('faq.faq_cta.cta_button_label', 'GET IT TOUCH') }}</div>
                                <div>{{ cms('faq.faq_cta.cta_button_label', 'GET IT TOUCH') }}</div>
                            </div>
                        </div>
                        <div class="button-icon-element">
                            <div class="button-icon-wrap"
                                style="transform: translate3d(-50%, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                <div class="button-icon-inner"><img
                                        src="/storage/media/webflow/664c2ad8ce7e660fca0261be_arrow.svg"
                                        loading="lazy" alt="" class="button-iocn"></div>
                                <div class="button-icon-inner"><img
                                        src="/storage/media/webflow/664c2ad8ce7e660fca0261be_arrow.svg"
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
