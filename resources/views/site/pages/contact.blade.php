@extends('site.layouts.app')

@section('title', 'Contact Us')

@section('content')
<header class="section-common-hero">
            <div class="container-main">
                <div class="common-hero-component">
                    <div class="common-hero-element">
                        <div id="w-node-_6731808a-23bb-c40b-6feb-8f3197526b9f-f09ac0cc" class="hero-title-wrap">
                            <div class="title-move-animation"
                                style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                                <div class="text-gradient">
                                    <div class="display-large">{{ cms('contact.contact_hero.hero_title_line_1', 'Have a') }}</div>
                                </div>
                            </div>
                        </div>
                        <div id="w-node-_6731808a-23bb-c40b-6feb-8f3197526ba4-f09ac0cc" class="content-group">
                            <div class="content-group-title-wrap">
                                <div class="hero-title-wrap">
                                    <div class="title-move-animation"
                                        style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                                        <div class="text-gradient">
                                            <div class="display-large">{{ cms('contact.contact_hero.hero_title_line_2', 'project?') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="w-node-_6731808a-23bb-c40b-6feb-8f3197526bab-f09ac0cc"
                                class="content-group-para-wrap"
                                style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                                <p class="hero-para">{{ cms('contact.contact_hero.hero_paragraph', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas non massa luctus, rutrum libero in, fermentum orci.') }}</p>
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
        </header>
        <section class="section-contact-us">
            <div class="container-main">
                <div class="contact-us-component">
                    <div class="section-title-element">
                        <div class="section-caption-wrap">
                            <div class="caption"
                                style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                                {{ cms('contact.contact_us_main.section_caption', 'CONTACT US') }}</div>
                        </div>
                        <div class="section-title-wrap">
                            <div class="text-align-right">
                                <div class="text-animation-block"
                                    style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                                    <h2>{{ cms('contact.contact_us_main.section_heading', 'Contact our support team to grow your business') }}</h2>
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
                    <div class="contact-us-element">
                        <div data-w-id="b648a0c7-845e-cd10-ef1a-20b936c4d457"
                            style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 0; transform-style: preserve-3d;"
                            class="address-wrapper">
                            <div class="address-info">
                                <div class="address-info-title">office</div>
                                <p><a href="#">714 Example
                                        location</a></p><a href="mailto:hello@edoly.com"
                                    class="address-link">hello@edoly.com</a>
                            </div>
                            <div class="address-info">
                                <div class="address-info-title">Sales</div>
                                <p><a href="#">715 Example
                                        location</a></p><a href="mailto:sales@edoly.com"
                                    class="address-link">sales@edoly.com</a>
                            </div>
                            <div class="address-info">
                                <div class="address-info-title">Address</div>
                                <p><a href="#">716 Example
                                        location</a></p><a href="tel:+0-000-000-000"
                                    class="address-link">+0-000-000-000</a>
                            </div>
                        </div>
                        <div id="w-node-b7234a9a-67bb-0b74-f19a-02f99d3aed29-f09ac0cc" class="contact-us-form-element">
                            <div data-w-id="221a5df5-9f48-d8a2-8f2b-5b1c2a94ac8e"
                                style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 0; transform-style: preserve-3d;"
                                class="contact-us-form-block w-form">
                                <h3 class="contact-us-form-title">{{ cms('contact.contact_us_main.form_title', 'contact us!') }}</h3>
                                <form id="wf-form-Contact-Us-Form" name="wf-form-Contact-Us-Form"
                                    data-name="Contact Us Form" class="contact-us-form"
                                    data-wf-element-id="221a5df5-9f48-d8a2-8f2b-5b1c2a94ac8f" aria-label="Contact Us Form" method="POST" action="{{ route('contact.submit') }}">@csrf
                                    <input
                                        class="form-field w-node-_221a5df5-9f48-d8a2-8f2b-5b1c2a94ac92-f09ac0cc w-input"
                                        maxlength="256" name="First-name" data-name="First name"
                                        placeholder="First name" type="text" id="First-name" value="{{ old('First-name') }}"><input
                                        class="form-field w-node-_9cba4c6b-ec70-5294-237e-67b1906b7691-f09ac0cc w-input"
                                        maxlength="256" name="Last-name" data-name="Last name" placeholder="Last name"
                                        type="text" id="Last-name" value="{{ old('Last-name') }}"><input
                                        class="form-field w-node-_221a5df5-9f48-d8a2-8f2b-5b1c2a94ac95-f09ac0cc w-input"
                                        maxlength="256" name="Email" data-name="Email" placeholder="Email" type="email"
                                        id="Email" required="" value="{{ old('Email') }}"><input
                                        class="form-field w-node-_55adfff3-1d83-34e6-65a9-111da15059e2-f09ac0cc w-input"
                                        maxlength="256" name="Phone-number" data-name="Phone number"
                                        placeholder="Phone number" type="tel" id="Phone-number" required="" value="{{ old('Phone-number') }}"><input
                                        class="form-field w-node-eac952a3-338a-9294-9e37-a88080c1f122-f09ac0cc w-input"
                                        maxlength="256" name="Subject" data-name="Subject" placeholder="Subject"
                                        type="text" id="Subject" required="" value="{{ old('Subject') }}"><textarea
                                        placeholder="Please write your messages" maxlength="5000" id="field"
                                        name="field" data-name="Field"
                                        class="form-field text-box w-node-_655061c0-a8f4-4ca5-60c8-5eda961a0d01-f09ac0cc w-input">{{ old('field') }}</textarea><button
                                        id="w-node-c8860e6c-392e-a0c2-a620-83bf95598abf-f09ac0cc" type="submit"
                                        class="primary-button" style="border-color: rgba(255, 255, 255, 0.2);">
                                        <div class="button-text-wrap">
                                            <div class="button-text-inner"
                                                style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                                <div class="text-block">{{ cms('contact.contact_us_main.form_submit_label', 'SUBMIT') }}</div>
                                                <div>{{ cms('contact.contact_us_main.form_submit_label', 'SUBMIT') }}</div>
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
                                    </button>
                                    
                                </form>
                                <div @if (session('form_sent') === 'contact') style="display:block" @endif class="success-message w-form-done" tabindex="-1" role="region"
                                    aria-label="Contact Us Form success">
                                    <div class="form-info-block"><img
                                            src="{{ cms_image('contact.contact_us_main.form_success_icon', '/storage/media/webflow/668c4528a2433dc202d5dd5d_check-circle.svg') }}"
                                            loading="lazy" alt="">
                                        <div>{{ cms('contact.contact_us_main.form_success_message', 'Thank you! Your submission has been received!') }}</div>
                                    </div>
                                </div>
                                <div @if (session('form_failed') === 'contact' || $errors->{'contact'}->any()) style="display:block" @endif class="error-message w-form-fail" tabindex="-1" role="region"
                                    aria-label="Contact Us Form failure">
                                    <div class="form-info-block"><img
                                            src="{{ cms_image('contact.contact_us_main.form_error_icon', '/storage/media/webflow/668c45d06e7cd30793472a3d_alert-circle.svg') }}"
                                            loading="lazy" alt="">
                                        <div>{{ cms('contact.contact_us_main.form_error_message', 'Oops! Something went wrong while submitting the form.') }}</div>
                                    </div>
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
        <section class="section-faq">
            <div class="container-main">
                <div class="faq-component">
                    <div class="faq-element">
                        <div class="faq-caption-wrap">
                            <div class="caption"
                                style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                                {{ cms('contact.contact_faq.faq_caption', 'FAQ') }}</div>
                        </div>
                        <div class="faq-list"
                            style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                            <div class="faq-item">
                                <div class="faq-trigger">
                                    <div class="faq-title" style="color: rgb(120, 120, 120);">WHAT SERVICES DOES PROVIDE
                                        THE EDOLY?</div>
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
                                    <div class="faq-title" style="color: rgb(120, 120, 120);">HOW CAN EDOLY BENEFITS MY
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
                                    <div class="faq-title" style="color: rgb(120, 120, 120);">HOW DOES EDOLY PROVIDE THE
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
                                style="transform: translate3d(0px, 100%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                                <div class="text-gradient cta-text-gradient">
                                    <div class="text-align-center">
                                        <h2 class="display-medium">{{ cms('contact.contact_cta.cta_title_line_1', 'START YOUR') }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cta-title-wrap">
                            <div data-w-id="93ad72e4-cc3e-2e24-6f93-9a3fc7f64ccd" class="title-move-animation"
                                style="transform: translate3d(0px, 100%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                                <div class="text-gradient cta-text-gradient">
                                    <div class="text-align-center">
                                        <div class="display-medium">{{ cms('contact.contact_cta.cta_title_line_2', 'PROJECT NOW') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div data-w-id="fb3d8211-581b-e555-5949-cd34f550b0e3" class="cta-image-wrap"
                            style="opacity: 0;"><img
                                src="{{ cms_image('contact.contact_cta.cta_image', '/storage/media/webflow/664c7b819abdb2098fe1c195_cta-image.jpg') }}"
                                loading="lazy" sizes="100vw"
                                srcset="/storage/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-500.jpg 500w, /storage/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-800.jpg 800w, /storage/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-1080.jpg 1080w, /storage/media/webflow/664c7b819abdb2098fe1c195_cta-image.jpg 1395w"
                                alt="CTA image" class="full-image"></div><a {!! nav_active('/contact') ? 'aria-current="page"' : '' !!}
                            data-w-id="84ff4b69-3bd5-a48a-06c2-d764252bc56d"
                            href="/contact" target="_blank"
                            class="primary-button w-inline-block{{ nav_active('/contact') ? ' w--current' : '' }}" style="border-color: rgba(255, 255, 255, 0.2);">
                            <div class="button-text-wrap">
                                <div class="button-text-inner"
                                    style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                    <div class="text-block">{{ cms('contact.contact_cta.cta_button_label', 'GET IT TOUCH') }}</div>
                                    <div>{{ cms('contact.contact_cta.cta_button_label', 'GET IT TOUCH') }}</div>
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
                    style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                </div>
            </div>
        </section>
@endsection
