<footer class="footer">
        <div class="container-main">
            <div class="footer-component">
                <div class="footer-top-element">
                    <div class="footer-description-column">
                        <div class="text-animation-block"
                            style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                            <h2>{{ setting('footer.headline', 'Ready to elevate your brand with Fables?') }}</h2>
                            <div class="text-overlay" style="will-change: width, height; width: 100%;"></div>
                            <div class="text-overlay row-02" style="will-change: width, height; width: 100%;"></div>
                            <div class="text-overlay row-03" style="will-change: width, height; width: 100%;"></div>
                            <div class="text-overlay row-04" style="will-change: width, height; width: 100%;"></div>
                        </div>
                        <div data-w-id="6ae0aa8d-def1-f227-09ea-ec72da462744" class="form-block w-form"
                            style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                            <form id="wf-form-Subscription-Email-Form" name="wf-form-Subscription-Email-Form"
                                data-name="Subscription Email Form" class="form"
                                data-wf-element-id="6ae0aa8d-def1-f227-09ea-ec72da462745"
                                aria-label="Subscription Email Form" method="POST" action="{{ route('subscribe') }}">@csrf<input class="text-field w-input" maxlength="256"
                                    name="Email" data-name="Email" placeholder="Email address" type="email"
                                    id="Subscription-email" required="" value="{{ old('Email') }}">
                                <div class="submit-button-wrap"><input type="submit" data-wait="Please wait..."
                                        class="submit-button w-button" value=""><img loading="lazy"
                                        src="/era/media/webflow/664c80ccd78ddbcc18790edc_arrow-long.svg"
                                        alt="" class="form-icon"></div>
                            </form>
                            <div @if (session('form_sent') === 'subscribe') style="display:block" @endif class="success-message w-form-done" tabindex="-1" role="region"
                                aria-label="Subscription Email Form success">
                                <div class="form-info-block"><img
                                        src="/era/media/webflow/668c4528a2433dc202d5dd5d_check-circle.svg"
                                        loading="lazy" alt="">
                                    <div>{{ setting('footer.newsletter_success', 'Thank you! Your submission has been received!') }}</div>
                                </div>
                            </div>
                            <div @if (session('form_failed') === 'subscribe' || $errors->{'subscribe'}->any()) style="display:block" @endif class="error-message w-form-fail" tabindex="-1" role="region"
                                aria-label="Subscription Email Form failure">
                                <div class="form-info-block"><img
                                        src="/era/media/webflow/668c45d06e7cd30793472a3d_alert-circle.svg"
                                        loading="lazy" alt="">
                                    <div>{{ setting('footer.newsletter_error', 'Oops! Something went wrong while submitting the form.') }}</div>
                                </div>
                            </div>
                        </div>
                        <div data-w-id="bde28cae-09ae-cfcc-3461-00985d233a50" class="button-wrap"
                            style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                            <a {!! nav_active('/contact') ? 'aria-current="page"' : '' !!} data-w-id="84ff4b69-3bd5-a48a-06c2-d764252bc56d"
                                href="{{ setting('footer.cta_url', '/contact') }}" target="_blank"
                                class="primary-button w-inline-block{{ nav_active('/contact') ? ' w--current' : '' }}" style="border-color: rgba(255, 255, 255, 0.2);">
                                <div class="button-text-wrap">
                                    <div class="button-text-inner"
                                        style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                        <div class="text-block">{{ setting('footer.cta_label', 'BUY TEMPLATE') }}</div>
                                        <div>{{ setting('footer.cta_label', 'BUY TEMPLATE') }}</div>
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
                    <div class="footer-menu-column">
                        <div data-w-id="6ae0aa8d-def1-f227-09ea-ec72da462752" class="footer-menu-list"
                            style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                            @foreach (cms_menu('footer')->groupBy('column_heading') as $heading => $items)<div class="footer-menu-item">
                                <div class="footer-menu-title">{{ $heading }}</div>
                                <div class="footer-menu-link-wrap">@foreach ($items as $item)<a {!! nav_active($item->url) ? 'aria-current="page"' : '' !!} href="{{ $item->url }}" class="link-wrap w-inline-block{{ nav_active($item->url) ? ' w--current' : '' }}">
                                        <div class="link-inner"
                                            style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                            <div class="link-text-wrap">
                                                <div class="nav-link-text">{{ $item->label }}</div>
                                            </div>
                                            <div class="link-text-wrap is-hover">
                                                <div class="nav-link-text">{{ $item->label }}</div>
                                            </div>
                                        </div>
                                    </a>@endforeach</div>
                            </div>@endforeach
                        </div>
                    </div>
                </div>
                <div data-w-id="6ae0aa8d-def1-f227-09ea-ec72da4627cf" class="footer-bottom-element"
                    style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                    <div class="footer-big-text">{{ setting('footer.big_text', 'ERA') }}</div>
                </div>
            </div>
        </div>
        <div class="footer-additional">
            <div class="footer-additional-component">
                <div class="footer-additional-element">
                    <p>© All rights reserved.<a href="{{ setting('general.website_url', 'https://erainfotechbd.com/') }}" target="_blank"> Era Infotech Ltd</a>.</p>
                    <p>Powered by <a href="{{ setting('footer.credit_url', 'https://erainfotechbd.com/') }}" target="_blank">{{ setting('footer.credit_label', 'Era Infotech Ltd.') }}</a></p>
                    <div class="social-icon-element"><a href="{{ setting('social.facebook', 'https://www.facebook.com/') }}" target="_blank"
                            class="social-icon w-inline-block">
                            <div></div>
                        </a><a href="{{ setting('social.twitter', 'https://twitter.com/') }}" target="_blank" class="social-icon w-inline-block">
                            <div></div>
                        </a><a href="{{ setting('social.instagram', 'https://www.instagram.com/') }}" target="_blank" class="social-icon w-inline-block">
                            <div></div>
                        </a><a href="{{ setting('social.dribbble', 'https://dribbble.com/') }}" target="_blank" class="social-icon w-inline-block">
                            <div></div>
                        </a><a href="{{ setting('social.behance', 'https://www.behance.net/') }}" target="_blank" class="social-icon w-inline-block">
                            <div></div>
                        </a></div>
                </div>
            </div>
        </div>
    </footer>
