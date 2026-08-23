<!DOCTYPE html>
{{--
    data-wf-page and data-wf-site are load-bearing, not decoration. Webflow's
    interactions runtime uses them to bind the page-scoped animations — the video
    zoom on the home page, the process strip. Without them those silently never
    run while element-level reveals carry on working, so the page looks
    half-animated rather than obviously broken.
--}}
<html data-wf-domain="{{ request()->getHost() }}" data-wf-page="@yield('wf_page')" data-wf-site="@yield('wf_site')"
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="w-mod-js w-mod-ix wf-opensans-n3-active wf-opensans-i3-active wf-opensans-n4-active wf-opensans-i4-active wf-opensans-n6-active wf-opensans-i6-active wf-opensans-n7-active wf-opensans-i7-active wf-opensans-n8-active wf-opensans-i8-active wf-active">

@include('site.partials.head')

<body>
    @yield('cursor')
    @include('site.partials.navbar')
    @yield('content')
    @include('site.partials.footer')
    @include('site.partials.scripts')
    @stack('scripts')
</body>

</html>
