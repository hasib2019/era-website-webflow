@extends('site.layouts.app')

@section('title', page_title('style-guide', 'Style Guide'))
@section('wf_page', '66485cbdb8fe5b2ef09ac0c6')
@section('wf_site', '66485cbdb8fe5b2ef09ac0c3')

@section('content')
@if(cms_section_visible('style-guide', 'style_guide_hero'))<header class="utilities-section-hero">
        <div class="container-main">
            <div class="utilities-component">
                <div class="hero-title-wrap z-index-none">
                    <div class="title-move-animation"
                        style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                        <div class="text-gradient">
                            <h1 class="display-large text-align-center">{{ cms('style-guide.style_guide_hero.hero_title', 'Style Guide') }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="horizontal-line-wrap">
            {!! cms('style-guide.style_guide_hero.hero_divider_visible', '<div class="horizontal-line" style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">') !!}
            </div>
        </div>
    </header>@endif
    @if(cms_section_visible('style-guide', 'style_guide_main'))<section class="utilities-section-main">
        <div class="container-main">
            <div class="utilities-main-inner">
                <aside class="utilities-main-aside">
                    <div class="utilities-main-sidebar"
                        style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                        <a href="#heading" class="utilities-sidebar-link w-inline-block">
                            <div>Heading</div>
                        </a><a href="#custom-heading" class="utilities-sidebar-link w-inline-block">
                            <div>custom heading</div>
                        </a><a href="#body-text" class="utilities-sidebar-link w-inline-block">
                            <div>Body text</div>
                        </a><a href="#Color" class="utilities-sidebar-link w-inline-block">
                            <div>Color</div>
                        </a><a href="#Buttons" class="utilities-sidebar-link w-inline-block">
                            <div>Buttons</div>
                        </a>
                    </div>
                </aside>
                <div class="utilities-main-content">
                    <div id="heading" class="utilities-single-section-block"
                        style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                        <div class="utilities-section-content">
                            <div class="display-large">{{ cms('style-guide.style_guide_main.typo_display_large', 'Display L') }}</div>
                            <div class="display-medium">{{ cms('style-guide.style_guide_main.typo_display_medium', 'Display M') }}</div>
                            <h1>{{ cms('style-guide.style_guide_main.typo_h1', 'Heading H1') }}</h1>
                            <h2>{{ cms('style-guide.style_guide_main.typo_h2', 'Heading H2') }}</h2>
                            <h3>{{ cms('style-guide.style_guide_main.typo_h3', 'Heading H3') }}</h3>
                            <h4>{{ cms('style-guide.style_guide_main.typo_h4', 'Heading H4') }}</h4>
                        </div>
                    </div>
                    <div id="custom-heading" class="utilities-single-section-block"
                        style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                        <div class="utilities-section-content">
                            <div class="heading-h1">{{ cms('style-guide.style_guide_main.typo_h1', 'Heading H1') }}</div>
                            <div class="heading-h2">{{ cms('style-guide.style_guide_main.typo_h2', 'Heading H2') }}</div>
                            <div class="heading-h3">{{ cms('style-guide.style_guide_main.typo_h3', 'Heading H3') }}</div>
                            <div class="heading-h4">{{ cms('style-guide.style_guide_main.typo_h4', 'Heading H4') }}</div>
                        </div>
                    </div>
                    <div id="body-text" class="utilities-single-section-block"
                        style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                        <div class="utilities-section-content">
                            <div class="caption"
                                style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                                {{ cms('style-guide.style_guide_main.body_caption', 'Caption') }}</div>
                            <p>{{ cms('style-guide.style_guide_main.body_paragraph', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla, ut commodo diam libero vitae erat. Aenean faucibus nibh et justo cursus id rutrum lorem imperdiet. Nunc ut sem vitae risus tristique posuere.') }}</p>
                            <blockquote>{{ cms('style-guide.style_guide_main.body_blockquote', 'Block Quote') }}</blockquote>
                        </div>
                    </div>
                    <div id="Color" class="utilities-single-section-block"
                        style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                        <div class="utilities-color-swatch-wrapper">
                            <div class="utilities-color-swatch-item">
                                <div class="background-white">
                                    <div class="utilities-swatch-background-color"></div>
                                </div>
                                <div class="utilities-color-swatch-card-bottom">
                                    <div>#FFFFFF</div>
                                </div>
                            </div>
                            <div class="utilities-color-swatch-item">
                                <div class="background-black">
                                    <div class="utilities-swatch-background-color"></div>
                                </div>
                                <div class="utilities-color-swatch-card-bottom">
                                    <div>#0A0909</div>
                                </div>
                            </div>
                            <div class="utilities-color-swatch-item">
                                <div class="background-grey">
                                    <div class="utilities-swatch-background-color"></div>
                                </div>
                                <div class="utilities-color-swatch-card-bottom">
                                    <div>#787878</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="Buttons" class="utilities-single-section-block"
                        style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                        <div class="utilities-section-content"><a data-w-id="84ff4b69-3bd5-a48a-06c2-d764252bc56d"
                                href="#" class="primary-button w-inline-block"
                                style="border-color: rgba(255, 255, 255, 0.2);">
                                <div class="button-text-wrap">
                                    <div class="button-text-inner"
                                        style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                        <div class="text-block">{{ cms('style-guide.style_guide_main.button_demo_label', 'BUY TEMPLATE') }}</div>
                                        <div>{{ cms('style-guide.style_guide_main.button_demo_label', 'BUY TEMPLATE') }}</div>
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
            {!! cms('style-guide.style_guide_hero.hero_divider_visible', '<div class="horizontal-line" style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">') !!}
            </div>
        </div>
    </section>@endif
    @if(cms_section_visible('style-guide', 'style_guide_cta'))<section class="section-cta">
        <div class="container-main">
            <div class="max-width-930px">
                <div class="cta-component">
                    <div class="cta-title-wrap">
                        <div data-w-id="9a268fd0-8c98-cbd7-b73d-163a2aa21c2a" class="title-move-animation"
                            style="transform: translate3d(0px, 100%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                            <div class="text-gradient cta-text-gradient">
                                <div class="text-align-center">
                                    <h2 class="display-medium">{{ cms('style-guide.style_guide_cta.cta_title_line_1', 'START YOUR') }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cta-title-wrap">
                        <div data-w-id="93ad72e4-cc3e-2e24-6f93-9a3fc7f64ccd" class="title-move-animation"
                            style="transform: translate3d(0px, 100%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                            <div class="text-gradient cta-text-gradient">
                                <div class="text-align-center">
                                    <div class="display-medium">{{ cms('style-guide.style_guide_cta.cta_title_line_2', 'PROJECT NOW') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div data-w-id="fb3d8211-581b-e555-5949-cd34f550b0e3" class="cta-image-wrap" style="opacity: 0;">
                        <img src="{{ cms_image('style-guide.style_guide_cta.cta_image', '/era/media/webflow/664c7b819abdb2098fe1c195_cta-image.jpg') }}"
                            loading="lazy" sizes="100vw"
                            srcset="/era/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-500.jpg 500w, /era/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-800.jpg 800w, /era/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-1080.jpg 1080w, /era/media/webflow/664c7b819abdb2098fe1c195_cta-image.jpg 1395w"
                            alt="CTA image" class="full-image"></div><a {!! nav_active('/contact') ? 'aria-current="page"' : '' !!} data-w-id="84ff4b69-3bd5-a48a-06c2-d764252bc56d"
                        href="/contact" target="_blank"
                        class="primary-button w-inline-block{{ nav_active('/contact') ? ' w--current' : '' }}" style="border-color: rgba(255, 255, 255, 0.2);">
                        <div class="button-text-wrap">
                            <div class="button-text-inner"
                                style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                <div class="text-block">{{ cms('style-guide.style_guide_cta.cta_button_label', 'GET IT TOUCH') }}</div>
                                <div>{{ cms('style-guide.style_guide_cta.cta_button_label', 'GET IT TOUCH') }}</div>
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
            {!! cms('style-guide.style_guide_hero.hero_divider_visible', '<div class="horizontal-line" style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">') !!}
            </div>
        </div>
    </section>@endif
@endsection
