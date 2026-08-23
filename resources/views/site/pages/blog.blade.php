@extends('site.layouts.app')

@section('title', 'Blog')
@section('wf_page', '66485cbdb8fe5b2ef09ac0c6')
@section('wf_site', '66485cbdb8fe5b2ef09ac0c3')

@section('content')
<header class="section-common-hero">
        <div class="container-main">
            <div class="common-hero-component">
                <div class="common-hero-element">
                    <div id="w-node-_03733d81-c39b-76fe-970e-6d051913db0b-f09ac0cb" class="hero-title-wrap">
                        <div class="title-move-animation"
                            style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                            <div class="text-gradient">
                                <div class="display-large">{{ cms('blog.blog_hero.hero_title_line_1', 'Blog') }} </div>
                            </div>
                        </div>
                    </div>
                    <div id="w-node-_03733d81-c39b-76fe-970e-6d051913db10-f09ac0cb" class="content-group">
                        <div class="content-group-title-wrap">
                            <div class="hero-title-wrap">
                                <div class="title-move-animation"
                                    style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                                    <div class="text-gradient">
                                        <div class="display-large">{{ cms('blog.blog_hero.hero_title_line_2', '& articles') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="w-node-_03733d81-c39b-76fe-970e-6d051913db17-f09ac0cb" class="content-group-para-wrap"
                            style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                            <p class="hero-para">{{ cms('blog.blog_hero.hero_paragraph', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas non massa luctus, rutrum libero in, fermentum orci.') }} </p>
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
    <section class="section-feature-blog">
        <div class="container-main">
            <div class="feature-blog-component">
                <div class="section-title-element">
                    <div class="section-caption-wrap">
                        <div class="caption"
                            style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                            {{ cms('blog.blog_featured.section_caption', 'FEATURED BLOG') }}</div>
                    </div>
                    <div class="section-title-wrap">
                        <div class="text-align-right">
                            <div class="text-animation-block"
                                style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                                <h2>{{ cms('blog.blog_featured.section_heading', 'Browse our latest news and resources') }}</h2>
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
                <div class="feature-blog-element">
                    <div class="w-dyn-list">
                        <div role="list" class="w-dyn-items">
                            <div data-w-id="7df832da-86bf-45ef-9fae-01ffc62761b2"
                                style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 1; transform-style: preserve-3d;"
                                role="listitem" class="feature-blog-collection-item w-dyn-item">
                                <div class="blog-item">
                                    <div id="w-node-_7df832da-86bf-45ef-9fae-01ffc62761b4-f09ac0cb"
                                        class="blog-content-wrap">
                                        <div class="blog-info-wrap blog-item-info-wrap">
                                            <div class="blog-info-inner blog-item-info-inner"><img
                                                    src="/storage/media/webflow/66507334b279af4803571b92_calender-icon.png"
                                                    loading="lazy" alt="">
                                                <p class="blog-info-text">Jul 10, 2024</p>
                                            </div>
                                            <div class="blog-info-inner blog-item-info-inner"><img
                                                    src="/storage/media/webflow/66507334a301d18ef9aa933f_time-icon.png"
                                                    loading="lazy" alt="">
                                                <div class="blog-info-content-wrap">
                                                    <p class="blog-info-text">6</p>
                                                    <p class="blog-info-text">min read</p>
                                                </div>
                                            </div>
                                        </div>
                                        <h3 class="blog-title" style="color: rgb(120, 120, 120);">Navigating search
                                            algorithms for regional impact</h3>
                                        <div class="blog-post-summary-wrap">
                                            <p class="blog-post-summary">Lorem ipsum dolor sit amet, consecteturor
                                                adipiscing elit. Tincidunt donec vulputate ipsum erat urna auctor.
                                                Eget phasellus ideirs. </p>
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
                                                            src="/storage/media/webflow/664c2ad8ce7e660fca0261be_arrow.svg"
                                                            loading="lazy" alt="" class="button-iocn"></div>
                                                    <div class="button-icon-inner"><img
                                                            src="/storage/media/webflow/664c2ad8ce7e660fca0261be_arrow.svg"
                                                            loading="lazy" alt="" class="button-iocn"></div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div id="w-node-_7df832da-86bf-45ef-9fae-01ffc62761c5-f09ac0cb"
                                        class="blog-thumbnail-image-wrap"><img
                                            src="/storage/media/webflow/66876a195c4a30e89f362732_blog-image-1.webp"
                                            loading="lazy" alt="This is a nice image"
                                            sizes="(max-width: 479px) 100vw, (max-width: 767px) 90vw, (max-width: 1439px) 40vw, (max-width: 1919px) 41vw, 44vw"
                                            srcset="/storage/media/webflow/66876a195c4a30e89f362732_blog-image-1-p-500.webp 500w, /storage/media/webflow/66876a195c4a30e89f362732_blog-image-1-p-800.webp 800w, /storage/media/webflow/66876a195c4a30e89f362732_blog-image-1-p-1080.webp 1080w, /storage/media/webflow/66876a195c4a30e89f362732_blog-image-1.webp 1240w"
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
    </section>
    <section class="section-blogs">
        <div class="container-main">
            <div class="blog-component">
                <div class="section-title-element blog-section-title">
                    <div class="section-caption-wrap">
                        <div class="caption"
                            style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                            {{ cms('blog.blog_list.section_caption', 'LATEST BLOG') }}</div>
                    </div>
                    <div class="section-title-wrap">
                        <div class="text-align-right">
                            <div class="text-animation-block"
                                style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                                <h2>{{ cms('blog.blog_featured.section_heading', 'Browse our latest news and resources') }}</h2>
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
                <div class="blog-element">
                    <div class="w-dyn-list">
                        <div role="list" class="w-dyn-items">
                            @foreach (\App\Models\Post::published()->where('is_featured', false)->latestFirst()->get() as $post)<div role="listitem" class="blog-collection-item w-dyn-item"
                                style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                                <div class="blog-item">
                                    <div id="w-node-a0031e10-4441-ce22-c406-e3cd4f99c5f4-f09ac0cb"
                                        class="blog-content-wrap">
                                        <div class="blog-info-wrap blog-item-info-wrap">
                                            <div class="blog-info"><img
                                                    src="/storage/media/webflow/66507334b279af4803571b92_calender-icon.png"
                                                    loading="lazy" alt="">
                                                <p class="font-weight-medium">Jul 10, 2024</p>
                                            </div>
                                            <div class="blog-info"><img
                                                    src="/storage/media/webflow/66507334a301d18ef9aa933f_time-icon.png"
                                                    loading="lazy" alt="">
                                                <div class="blog-info-content-wrap">
                                                    <p class="font-weight-medium">6</p>
                                                    <p class="font-weight-medium">min read</p>
                                                </div>
                                            </div>
                                        </div>
                                        <h3 class="blog-title" style="color: rgb(120, 120, 120);">{{ $post->title }}</h3>
                                        <div class="blog-post-summary-wrap">
                                            <p class="blog-post-summary">{{ $post->summary }}</p>
                                        </div><a {!! nav_active('/blog/navigating-search-algorithms-for-regional-impact') ? 'aria-current="page"' : '' !!} data-w-id="84ff4b69-3bd5-a48a-06c2-d764252bc56d"
                                            href="{{ route('blog.show', $post->slug) }}"
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
                                                            src="/storage/media/webflow/664c2ad8ce7e660fca0261be_arrow.svg"
                                                            loading="lazy" alt="" class="button-iocn"></div>
                                                    <div class="button-icon-inner"><img
                                                            src="/storage/media/webflow/664c2ad8ce7e660fca0261be_arrow.svg"
                                                            loading="lazy" alt="" class="button-iocn"></div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div id="w-node-a0031e10-4441-ce22-c406-e3cd4f99c605-f09ac0cb"
                                        class="blog-thumbnail-image-wrap"><img
                                            src="{{ $post->image?->url }}"
                                            loading="lazy" alt="This is a nice image"
                                            class="blog-image"
                                            style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                    </div>
                                </div>
                            </div>@endforeach
                        </div>
                        <div data-w-id="f70b616a-ddf1-71ff-9109-6c0ee163f6de"
                            style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 0; transform-style: preserve-3d;"
                            role="navigation" aria-label="List" class="w-pagination-wrapper pagination"><a
                                href="?2f3fa35c_page=2" aria-label="Next Page" class="w-pagination-next primary-button"
                                style="border-color: rgba(255, 255, 255, 0.2);">
                                <div class="button-text-wrap">
                                    <div class="button-text-inner"
                                        style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                        <div class="pagination-button-text">{{ cms('blog.blog_list.pagination_next_label', 'NEXT PAGE') }}</div>
                                        <div class="pagination-button-text">{{ cms('blog.blog_list.pagination_next_label', 'NEXT PAGE') }}</div>
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
                            <link rel="prerender" href="?2f3fa35c_page=2">
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
                                    <h2 class="display-medium">{{ cms('blog.blog_cta.cta_title_line_1', 'START YOUR') }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cta-title-wrap">
                        <div data-w-id="93ad72e4-cc3e-2e24-6f93-9a3fc7f64ccd" class="title-move-animation"
                            style="transform: translate3d(0px, 100%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                            <div class="text-gradient cta-text-gradient">
                                <div class="text-align-center">
                                    <div class="display-medium">{{ cms('blog.blog_cta.cta_title_line_2', 'PROJECT NOW') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div data-w-id="fb3d8211-581b-e555-5949-cd34f550b0e3" class="cta-image-wrap" style="opacity: 0;">
                        <img src="{{ cms_image('blog.blog_cta.cta_image', '/storage/media/webflow/664c7b819abdb2098fe1c195_cta-image.jpg') }}"
                            loading="lazy" sizes="100vw"
                            srcset="/storage/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-500.jpg 500w, /storage/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-800.jpg 800w, /storage/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-1080.jpg 1080w, /storage/media/webflow/664c7b819abdb2098fe1c195_cta-image.jpg 1395w"
                            alt="CTA image" class="full-image"></div><a {!! nav_active('/contact') ? 'aria-current="page"' : '' !!} data-w-id="84ff4b69-3bd5-a48a-06c2-d764252bc56d"
                        href="/contact" target="_blank"
                        class="primary-button w-inline-block{{ nav_active('/contact') ? ' w--current' : '' }}" style="border-color: rgba(255, 255, 255, 0.2);">
                        <div class="button-text-wrap">
                            <div class="button-text-inner"
                                style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                <div class="text-block">{{ cms('blog.blog_cta.cta_button_label', 'GET IT TOUCH') }}</div>
                                <div>{{ cms('blog.blog_cta.cta_button_label', 'GET IT TOUCH') }}</div>
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
