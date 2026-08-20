<!DOCTYPE html>
<html data-wf-domain="{{ request()->getHost() }}" lang="{{ str_replace('_', '-', app()->getLocale()) }}"
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
