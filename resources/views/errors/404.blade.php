@extends('site.layouts.app')

@section('title', '404')
@section('wf_page', '66485cbdb8fe5b2ef09ac0c6')
@section('wf_site', '66485cbdb8fe5b2ef09ac0c3')

@section('content')
<header class="section-not-found-hero">
        <div class="container-main">
            <div class="not-found-component">
                <div class="not-found-content-block">
                    <div data-w-id="34170b8e-1287-c886-d732-c0c26a4a4e55"
                        style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 1; transform-style: preserve-3d;"
                        class="not-found-title-wrap">
                        <div class="text-gradient">
                            <h1 class="not-found-title">404</h1>
                        </div>
                    </div>
                    <div data-w-id="450dd967-f796-9d38-1d9d-b13dba0fd9b7"
                        style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 1; transform-style: preserve-3d;"
                        class="not-found-para-wrap">
                        <p class="not-found-para">Hmmmm... I couldn't find that page. It's just me playing the
                            guitar :)</p>
                    </div>
                    <div data-w-id="93723a48-d034-1878-2e32-fe5ff019571a"
                        style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 1; transform-style: preserve-3d;"
                        class="button-wrap"><a {!! nav_active('/') ? 'aria-current="page"' : '' !!} data-w-id="84ff4b69-3bd5-a48a-06c2-d764252bc56d" href="/"
                            class="primary-button w-inline-block{{ nav_active('/') ? ' w--current' : '' }}" style="border-color: rgba(255, 255, 255, 0.2);">
                            <div class="button-text-wrap">
                                <div class="button-text-inner"
                                    style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                    <div class="text-block">GO BACK TO HOMEPAGE</div>
                                    <div>GO BACK TO HOMEPAGE</div>
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
    </header>
@endsection
