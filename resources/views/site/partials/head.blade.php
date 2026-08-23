<head>
    <style>
        .wf-force-outline-none[tabindex="-1"]:focus {
            outline: none;
        }
    </style>
    <meta charset="utf-8">
    <title>@yield('title', $site['meta_title'] ?? config('app.name'))</title>
    <meta name="description" content="@yield('description', $site['meta_description'] ?? '')">
    <meta content="@yield('og_image', $site['og_image'] ?? asset('storage/media/webflow/66a9cbc3e1c4cea814648e5b_open-graph-image.webp'))" property="og:image">
    <meta content="@yield('og_image', $site['og_image'] ?? asset('storage/media/webflow/66a9cbc3e1c4cea814648e5b_open-graph-image.webp'))" name="twitter:image">
    <meta property="og:type" content="website">
    <meta content="summary_large_image" name="twitter:card">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('site/css/styles.css') }}" rel="stylesheet" type="text/css">
    {{-- Corrections for the export's own responsive gaps; styles.css stays untouched. --}}
    <link href="{{ asset('site/css/responsive-fixes.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin="anonymous">
    <script src="{{ asset('site/js/webfont.js') }}" type="text/javascript"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300italic,400,400italic,600,600italic,700,700italic,800,800italic"
        media="all">
    <script
        type="text/javascript">WebFont.load({ google: { families: ["Open Sans:300,300italic,400,400italic,600,600italic,700,700italic,800,800italic"] } });</script>
    <script src="{{ asset('site/js/mod.js') }}"></script>
    <link href="{{ $site['favicon'] ?? asset('storage/media/webflow/664c37188f9dc64ed32c70a1_favicon.svg') }}"
        rel="shortcut icon" type="image/x-icon">
    <link href="{{ $site['webclip'] ?? asset('storage/media/webflow/66af85a288a99d56b5f70720_webclip-icon.png') }}"
        rel="apple-touch-icon">
    @verbatim
    <script
        type="text/javascript">window.__WEBFLOW_CURRENCY_SETTINGS = { "currencyCode": "USD", "symbol": "$", "decimal": ".", "fractionDigits": 2, "group": ",", "template": "{{wf {\"path\":\"symbol\",\"type\":\"PlainText\"} }} {{wf {\"path\":\"amount\",\"type\":\"CommercePrice\"} }} {{wf {\"path\":\"currencyCode\",\"type\":\"PlainText\"} }}", "hideDecimalForWholeNumbers": false };</script>
    @endverbatim
    {{-- Webflow's interactions runtime hides these until it reveals them on
         scroll. With JavaScript off nothing ever would, so show them outright. --}}
    <noscript>
        <style>
            [data-w-id] {
                opacity: 1 !important;
                transform: none !important;
            }
        </style>
    </noscript>
    @stack('head')
</head>
