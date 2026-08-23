<div data-w-id="98cce219-106e-0917-6727-fde305ae5965" data-animation="default" data-collapse="all"
        data-duration="400" data-easing="ease" data-easing2="ease" role="banner" class="navbar w-nav">
        <div class="nav-container">
            <div class="nav-element">
                <div class="brand-logo"><a {!! nav_active('/') ? 'aria-current="page"' : '' !!} href="/" class="brand-logo-link logo-white w-nav-brand{{ nav_active('/') ? ' w--current' : '' }}"
                        aria-label="home"><img
                            src="{{ setting_image('general.logo_light_id', '/storage/media/webflow/664c33abd0e16d4b14b10a0c_Logo.png') }}"
                            loading="lazy" width="115" alt="" class="brand-logo-image"></a></div>
                <nav role="navigation" class="nav-menu-main w-nav-menu">
                    <div class="nav-main-menu-inner">
                        <div class="nav-main-menu-container">
                            <div class="nav-main-menu-element">
                                <div class="nav-link-wrap main-menu-nav-link-wrap"><a {!! nav_active('/') ? 'aria-current="page"' : '' !!} href="/"
                                        class="brand-logo-link logo-black w-nav-brand{{ nav_active('/') ? ' w--current' : '' }}" aria-label="home"><img
                                            src="{{ setting_image('general.logo_dark_id', '/storage/media/webflow/668c2e6e687f356e879426a1_Logo-black.svg') }}"
                                            loading="lazy" width="115" alt="Black Logo" class="brand-logo-image"></a>
                                    <div class="nav-main-menu-wrap">@foreach (cms_menu('primary') as $item)<a {!! nav_active($item->url) ? 'aria-current="page"' : '' !!} href="{{ $item->url }}"
                                            class="nav-main-menu-link w-inline-block{{ nav_active($item->url) ? ' w--current' : '' }}">
                                            <div class="nav-main-menu-link-inner"
                                                style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                                <div class="main-menu-nav-link-text-gradient">
                                                    <div class="main-menu-nav-link-text">{{ $item->label }}</div>
                                                </div>
                                                <div class="main-menu-nav-link-text-gradient-copy">
                                                    <div class="main-menu-nav-link-text">{{ $item->label }}</div>
                                                </div>
                                            </div>
                                        </a>@endforeach</div>
                                </div>
                                <div id="w-node-_106cdf0f-8ee9-785f-ba3e-5080e6215caa-05ae5965"
                                    class="main-menu-other-info-wrap">
                                    <div class="main-menu-other-info-inner">
                                        <div class="main-menu-info-content-wrap">
                                            <p class="main-menu-info-para">your vision, our mission. let’s start the
                                                journey</p><a {!! nav_active('/contact') ? 'aria-current="page"' : '' !!} data-w-id="98cce219-106e-0917-6727-fde305ae5985"
                                                href="/contact"
                                                target="_blank" class="menu-button-wrapper w-inline-block{{ nav_active('/contact') ? ' w--current' : '' }}"
                                                style="border-color: rgba(0, 0, 0, 0.5);">
                                                <div class="button-text-wrap">
                                                    <div class="button-text-inner main-menu-nav-button-text"
                                                        style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                                        <div class="text-block">BUY TEMPLATE</div>
                                                        <div>BUY TEMPLATE</div>
                                                    </div>
                                                </div>
                                                <div class="button-icon-element main-menu-button-icon-element">
                                                    <div class="button-icon-wrap"
                                                        style="transform: translate3d(-50%, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                                        <div class="button-icon-inner"><img loading="lazy"
                                                                src="/storage/media/webflow/664c2ad8ce7e660fca0261be_arrow.svg"
                                                                alt="" class="button-iocn"></div>
                                                        <div class="button-icon-inner"><img loading="lazy"
                                                                src="/storage/media/webflow/664c2ad8ce7e660fca0261be_arrow.svg"
                                                                alt="" class="button-iocn"></div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="main-menu-social-wrap">
                                            <div class="social-icon-element"><a href="https://www.facebook.com/"
                                                    target="_blank" class="main-menu-social-icon w-inline-block">
                                                    <div></div>
                                                </a><a href="https://twitter.com/" target="_blank"
                                                    class="main-menu-social-icon w-inline-block">
                                                    <div></div>
                                                </a><a href="https://www.instagram.com/" target="_blank"
                                                    class="main-menu-social-icon w-inline-block">
                                                    <div></div>
                                                </a><a href="https://dribbble.com/" target="_blank"
                                                    class="main-menu-social-icon w-inline-block">
                                                    <div></div>
                                                </a><a href="https://www.behance.net/" target="_blank"
                                                    class="main-menu-social-icon w-inline-block">
                                                    <div></div>
                                                </a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="w-node-_98cce219-106e-0917-6727-fde305ae59a3-05ae5965" class="main-menu-bottom-shape">
                        </div>
                    </div>
                </nav>
                <div class="nav-menu">
                    <div class="nav-link-wrap"><a {!! nav_active('/') ? 'aria-current="page"' : '' !!} href="/" class="link-wrap w-inline-block{{ nav_active('/') ? ' w--current' : '' }}">
                            <div class="link-inner"
                                style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                <div class="link-text-wrap">
                                    <div class="nav-link-text">Home</div>
                                </div>
                                <div class="link-text-wrap is-hover">
                                    <div class="nav-link-text">Home </div>
                                </div>
                            </div>
                        </a><a {!! nav_active('/about') ? 'aria-current="page"' : '' !!} href="/about" class="link-wrap w-inline-block{{ nav_active('/about') ? ' w--current' : '' }}">
                            <div class="link-inner"
                                style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                <div class="link-text-wrap">
                                    <div class="nav-link-text">About</div>
                                </div>
                                <div class="link-text-wrap is-hover">
                                    <div class="nav-link-text">About</div>
                                </div>
                            </div>
                        </a><a {!! nav_active('/services') ? 'aria-current="page"' : '' !!} href="/services" class="link-wrap w-inline-block{{ nav_active('/services') ? ' w--current' : '' }}">
                            <div class="link-inner"
                                style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                <div class="link-text-wrap">
                                    <div class="nav-link-text">Services</div>
                                </div>
                                <div class="link-text-wrap is-hover">
                                    <div class="nav-link-text">Services</div>
                                </div>
                            </div>
                        </a><a {!! nav_active('/case-studies') ? 'aria-current="page"' : '' !!} href="/case-studies" class="link-wrap w-inline-block{{ nav_active('/case-studies') ? ' w--current' : '' }}">
                            <div class="link-inner"
                                style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                <div class="link-text-wrap">
                                    <div class="nav-link-text">Case study</div>
                                </div>
                                <div class="link-text-wrap is-hover">
                                    <div class="nav-link-text">Case study</div>
                                </div>
                            </div>
                        </a>
                        <div data-hover="false" data-delay="0" class="dropdown w-dropdown">
                            <div class="dropdown-toggle w-dropdown-toggle" id="w-dropdown-toggle-0"
                                aria-controls="w-dropdown-list-0" aria-haspopup="menu" aria-expanded="false"
                                role="button" tabindex="0">
                                <div class="link-wrap">
                                    <div class="link-inner"
                                        style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                        <div class="link-text-wrap dropdown-nav-item">
                                            <div class="nav-link-text">Other page</div>
                                            <div class="dropdown-icon"></div>
                                        </div>
                                        <div class="link-text-wrap is-hover">
                                            <div class="nav-link-text">Other page</div>
                                            <div class="dropdown-icon-hover"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <nav class="dropdown-list w-dropdown-list" id="w-dropdown-list-0"
                                aria-labelledby="w-dropdown-toggle-0">
                                <div class="nav-dropdown-list-content">
                                    <div class="nav-dropdown-list">
                                        <div class="nav-dropdown-column">@foreach (cms_menu('mega')->where('column_heading', 'Column 1') as $item)<a {!! nav_active($item->url) ? 'aria-current="page"' : '' !!} href="{{ $item->url }}"
                                                class="link-wrap w-inline-block{{ nav_active($item->url) ? ' w--current' : '' }}" tabindex="0">
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
                                        <div class="nav-dropdown-column">@foreach (cms_menu('mega')->where('column_heading', 'Column 2') as $item)<a {!! nav_active($item->url) ? 'aria-current="page"' : '' !!}
                                                href="{{ $item->url }}"
                                                class="link-wrap w-inline-block{{ nav_active($item->url) ? ' w--current' : '' }}" tabindex="0">
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
                                        <div class="nav-dropdown-column">@foreach (cms_menu('mega')->where('column_heading', 'Column 3') as $item)<a {!! nav_active($item->url) ? 'aria-current="page"' : '' !!} href="{{ $item->url }}" class="link-wrap w-inline-block{{ nav_active($item->url) ? ' w--current' : '' }}"
                                                tabindex="0">
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
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="nav-menu-right">
                    <div class="cart-wrap">
                        @if ($showCart ?? true)
@include('site.partials.cart')
@endif
                    </div>
                    <div class="nav-button-wrapper">
                        <div class="menu-button w-nav-button" style="-webkit-user-select: text;" aria-label="menu"
                            role="button" tabindex="0" aria-controls="w-nav-overlay-0" aria-haspopup="menu"
                            aria-expanded="false">
                            <div class="menu-button-inner">
                                <div class="menu-iocn-line-top"
                                    style="background-color: rgb(255, 255, 255); transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                </div>
                                <div class="menu-icon-line-middle" style="display: block;"></div>
                                <div class="menu-iocn-line-bottom"
                                    style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; background-color: rgb(255, 255, 255);">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-nav-overlay" data-wf-ignore="" id="w-nav-overlay-0"></div>
    </div>
