<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — {{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('storage/media/webflow/664c37188f9dc64ed32c70a1_favicon.svg') }}">
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
</head>

<body class="h-full bg-slate-100 font-sans text-slate-800 antialiased">
    <div class="flex h-full overflow-hidden">
        @include('admin.partials.sidebar')

        <div class="flex h-full min-w-0 flex-1 flex-col overflow-hidden">
            <header class="z-20 flex h-16 shrink-0 items-center gap-4 border-b border-slate-200 bg-white/90 px-4 backdrop-blur sm:px-6">
                <button type="button" data-sidebar-toggle
                    class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 lg:hidden" aria-label="Toggle navigation">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <div class="min-w-0 flex-1">
                    <h1 class="truncate text-base font-semibold text-slate-900">@yield('heading', View::getSection('title', 'Dashboard'))</h1>
                    @hasSection('subheading')
                        <p class="truncate text-xs text-slate-500">@yield('subheading')</p>
                    @endif
                </div>

                <a href="{{ url('/') }}" target="_blank" rel="noopener"
                    class="hidden rounded-lg px-3 py-1.5 text-sm font-medium text-slate-600 ring-1 ring-slate-200 transition hover:bg-slate-50 sm:inline-flex">
                    View site
                </a>

                <div class="flex items-center gap-3">
                    <div class="hidden text-right sm:block">
                        <p class="text-sm font-medium leading-tight text-slate-900">{{ auth()->user()->name }}</p>
                        <p class="text-xs leading-tight text-slate-500">{{ auth()->user()->role_names }}</p>
                    </div>
                    <img src="{{ auth()->user()->avatar_url }}" alt="" class="h-9 w-9 rounded-full bg-slate-200 object-cover">
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700"
                            title="Sign out" aria-label="Sign out">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                            </svg>
                        </button>
                    </form>
                </div>
            </header>

            <main class="min-h-0 flex-1 overflow-y-auto overscroll-contain px-4 py-6 sm:px-6 lg:px-8">
                @include('admin.partials.flash')
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
