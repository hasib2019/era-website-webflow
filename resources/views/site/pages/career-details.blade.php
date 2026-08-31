@extends('site.layouts.app')

@section('title', detail_title($job ?? null, 'career-details', 'Brand Expert'))
@section('wf_page', '66485cbdb8fe5b2ef09ac0c6')
@section('wf_site', '66485cbdb8fe5b2ef09ac0c3')

@section('content')
<header class="section-common-hero">
        <div class="container-main">
            <div class="common-hero-component">
                <div class="common-hero-element job-hero-element">
                    <div class="hero-title-wrap job-hero-title-wrap">
                        <div class="title-move-animation"
                            style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 1;">
                            <div class="text-gradient">
                                <h1 class="display-large">{{ ($job->title) ?: cms('career-details.career_hero.job_title', 'Brand expert') }}</h1>
                            </div>
                        </div>
                    </div>
                    <div data-w-id="51215c0d-cb36-2309-ef4e-63fa92589f2d"
                        style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 1; transform-style: preserve-3d;"
                        class="job-hero-info">
                        <div class="job-info-text color-white">new york</div>
                        <div class="job-hero-devider"></div>
                        <div class="job-info-text color-white">Full time</div>
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
    <section class="section-job-details">
        <div class="container-main">
            <div class="job-details-component">
                <div class="job-details-element">
                    <div class="job-details-wrap">
                        <div class="job-details-caption">
                            <div class="caption"
                                style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                                {{ cms('career-details.job_details.about_caption', 'ABOUT THE ROLE') }}</div>
                        </div>
                        <div data-w-id="2fca20c7-8e4a-6117-a83c-79c0e2dafec7"
                            style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 0; transform-style: preserve-3d;"
                            class="career-details-wrap">
                            <div class="career-details-rich-text w-richtext">
                                <h2>{{ cms('career-details.job_details.body_heading_1', 'Job Description') }}</h2>
                                <p>{{ cms('career-details.job_details.body_paragraph_1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque ultricies risus at dolor egestas, vitae cursus urna auctor. Pellentesque efficitur at ex a cursus. Vivamus eget sagittis ligula, a lobortis tortor. Nunc et turpis ut est interdum lobortis.') }}</p>
                                <p>{{ cms('career-details.job_details.body_paragraph_2', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sapien odio, rhoncus eget mi vitae, lobortis interdum velit. Vestibulum malesuada urna massa, id fringilla libero iaculis sed. Proin efficitur lorem a lacus lobortis porttitor eu ac risus. Aenean.') }}</p>
                                <h3>{{ cms('career-details.job_details.body_heading_2', 'In the short term, you will') }}</h3>
                                <ul role="list">
                                    <li>{{ cms('career-details.job_details.body_list_1_item_1', 'Become familiar with our systems, style & process') }}</li>
                                    <li>{{ cms('career-details.job_details.body_list_1_item_2', 'Participate in Continuous Discovery Habits; coaching others on qualitative research.') }}</li>
                                    <li>{{ cms('career-details.job_details.body_list_1_item_3', 'lead your own discovery & interviews with members to understand pains, gains & Jobs to be done') }}</li>
                                    <li>{{ cms('career-details.job_details.body_list_1_item_4', 'Guide research activities to define current member pain points and map ideal future experiences') }}</li>
                                    <li>{{ cms('career-details.job_details.body_list_1_item_5', 'Facilitate research by collecting, analyzing, and producing insights to lead the team toward user outcomes') }}</li>
                                    <li>{{ cms('career-details.job_details.body_list_1_item_6', 'Collaborate with cross-functional project team groups to support the design & creation of new products and features') }}</li>
                                </ul>
                                <h3>{{ cms('career-details.job_details.body_heading_3', 'What you bring to the table') }}</h3>
                                <ul role="list">
                                    <li>{{ cms('career-details.job_details.body_list_2_item_1', '4+ years of professional experience with 2+ years of experience in User Research') }}</li>
                                    <li>{{ cms('career-details.job_details.body_list_2_item_2', 'Experience in conducting research with a clear understanding of various quantitative and qualitative research methodologies') }}</li>
                                    <li>{{ cms('career-details.job_details.body_list_2_item_3', 'Analytical, data-driven, and supremely detail-oriented') }}</li>
                                    <li>{{ cms('career-details.job_details.body_list_2_item_4', 'Highly collaborative and empathetic: you love connecting with and helping others, whether they’re users or teammates') }}</li>
                                    <li>{{ cms('career-details.job_details.body_list_2_item_5', 'You’re legally authorized to work in the United States and able to work US-hours.') }}</li>
                                    <li>{{ cms('career-details.job_details.body_list_2_item_6', 'Preferred: Experience with quantitative analysis and data visualization') }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div id="w-node-fcf161b7-bcbf-07f6-e65f-0e978415c1a6-6def8b4c" class="job-application-block">
                        <div data-w-id="f1ca983b-7aa4-4bbd-c833-af185dd2c819"
                            style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); opacity: 0; transform-style: preserve-3d;"
                            class="job-application-info">
                            <div class="heading-h4">{{ cms('career-details.job_details.apply_box_title', 'APPLY FOR THIS JOB') }}</div>
                            <div class="application-para-wrap">
                                <p>{{ cms('career-details.job_details.apply_box_text', 'Please let Advertise know that you found this position on Jobs as a way to support us, so we can keep posting.') }}</p>
                            </div><a data-w-id="84ff4b69-3bd5-a48a-06c2-d764252bc56d"
                                href="mailto:{{ setting('contact.jobs_email', 'applyexamplejob@gmail.com') }}?subject=Job%20Apply"
                                class="primary-button w-inline-block" style="border-color: rgba(255, 255, 255, 0.2);">
                                <div class="button-text-wrap">
                                    <div class="button-text-inner"
                                        style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                        <div class="text-block">{{ cms('career-details.job_details.apply_button_label', 'APPLY FOR JOB') }}</div>
                                        <div>{{ cms('career-details.job_details.apply_button_label', 'APPLY FOR JOB') }}</div>
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
                            {{ cms('career-details.other_jobs.section_caption', 'BENEFITS') }}</div>
                    </div>
                    <div class="section-title-wrap">
                        <div class="text-align-right">
                            <div class="text-animation-block"
                                style="transform: translate3d(0px, 60px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                                <h2>{{ cms('career-details.other_jobs.section_heading', 'Opportunities to join our awesome team') }}</h2>
                                <div class="text-overlay" style="will-change: width, height; width: 100%;"></div>
                                <div class="text-overlay row-02" style="will-change: width, height; width: 100%;">
                                </div>
                                <div class="text-overlay row-03" style="will-change: width, height; width: 100%;">
                                </div>
                                <div class="text-overlay row-04" style="will-change: width, height; width: 100%;">
                                </div>
                                <div class="text-overlay row-05" style="will-change: width, height; width: 100%;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div data-w-id="3d609608-162d-0d33-e0c8-13eac6d84472"
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
                                            <div class="job-info-text" style="color: rgb(120, 120, 120);">new york
                                            </div>
                                            <div class="job-info-text" style="color: rgb(120, 120, 120);">Full time
                                            </div>
                                        </div>
                                    </div>
                                    <div id="w-node-_3d609608-162d-0d33-e0c8-13eac6d8447c-6def8b4c"
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
                                        <div class="job-item-title" style="color: rgb(120, 120, 120);">Senior SEO
                                            expert</div>
                                        <div class="job-info">
                                            <div class="job-info-text" style="color: rgb(120, 120, 120);">new york
                                            </div>
                                            <div class="job-info-text" style="color: rgb(120, 120, 120);">Full time
                                            </div>
                                        </div>
                                    </div>
                                    <div id="w-node-_3d609608-162d-0d33-e0c8-13eac6d8447c-6def8b4c"
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
                                        <div class="job-item-title" style="color: rgb(120, 120, 120);">Content
                                            writer</div>
                                        <div class="job-info">
                                            <div class="job-info-text" style="color: rgb(120, 120, 120);">new york
                                            </div>
                                            <div class="job-info-text" style="color: rgb(120, 120, 120);">Full time
                                            </div>
                                        </div>
                                    </div>
                                    <div id="w-node-_3d609608-162d-0d33-e0c8-13eac6d8447c-6def8b4c"
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
                                        <div class="job-item-title" style="color: rgb(120, 120, 120);">Copy writer
                                        </div>
                                        <div class="job-info">
                                            <div class="job-info-text" style="color: rgb(120, 120, 120);">new york
                                            </div>
                                            <div class="job-info-text" style="color: rgb(120, 120, 120);">Full time
                                            </div>
                                        </div>
                                    </div>
                                    <div id="w-node-_3d609608-162d-0d33-e0c8-13eac6d8447c-6def8b4c"
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
                                        <div class="job-item-title" style="color: rgb(120, 120, 120);">Digital
                                            marker</div>
                                        <div class="job-info">
                                            <div class="job-info-text" style="color: rgb(120, 120, 120);">new york
                                            </div>
                                            <div class="job-info-text" style="color: rgb(120, 120, 120);">Full time
                                            </div>
                                        </div>
                                    </div>
                                    <div id="w-node-_3d609608-162d-0d33-e0c8-13eac6d8447c-6def8b4c"
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
                                    <h2 class="display-medium">{{ cms('career-details.cta.cta_title_line_1', 'START YOUR') }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cta-title-wrap">
                        <div data-w-id="93ad72e4-cc3e-2e24-6f93-9a3fc7f64ccd" class="title-move-animation"
                            style="transform: translate3d(0px, 100%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d; opacity: 0;">
                            <div class="text-gradient cta-text-gradient">
                                <div class="text-align-center">
                                    <div class="display-medium">{{ cms('career-details.cta.cta_title_line_2', 'PROJECT NOW') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div data-w-id="fb3d8211-581b-e555-5949-cd34f550b0e3" class="cta-image-wrap" style="opacity: 0;">
                        <img src="{{ cms_image('career-details.cta.cta_image', '/era/media/webflow/664c7b819abdb2098fe1c195_cta-image.jpg') }}"
                            loading="lazy" sizes="100vw"
                            srcset="/era/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-500.jpg 500w, /era/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-800.jpg 800w, /era/media/webflow/664c7b819abdb2098fe1c195_cta-image-p-1080.jpg 1080w, /era/media/webflow/664c7b819abdb2098fe1c195_cta-image.jpg 1395w"
                            alt="CTA image" class="full-image"></div><a {!! nav_active('/contact') ? 'aria-current="page"' : '' !!} data-w-id="84ff4b69-3bd5-a48a-06c2-d764252bc56d"
                        href="/contact" target="_blank"
                        class="primary-button w-inline-block{{ nav_active('/contact') ? ' w--current' : '' }}" style="border-color: rgba(255, 255, 255, 0.2);">
                        <div class="button-text-wrap">
                            <div class="button-text-inner"
                                style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg); transform-style: preserve-3d;">
                                <div class="text-block">{{ cms('career-details.cta.cta_button_label', 'GET IT TOUCH') }}</div>
                                <div>{{ cms('career-details.cta.cta_button_label', 'GET IT TOUCH') }}</div>
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
