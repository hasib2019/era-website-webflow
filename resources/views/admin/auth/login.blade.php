<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign in — {{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('storage/media/webflow/664c37188f9dc64ed32c70a1_favicon.svg') }}">
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
</head>

<body class="h-full bg-slate-100 font-sans antialiased">
    <div class="flex min-h-full items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <div class="mb-8 text-center">
                <img src="{{ asset('storage/media/webflow/668c2e6e687f356e879426a1_Logo-black.svg') }}" alt=""
                    class="mx-auto h-9 w-auto">
                <h1 class="mt-6 text-2xl font-semibold text-slate-900">Content dashboard</h1>
                <p class="mt-1 text-sm text-slate-500">Sign in to manage the website.</p>
            </div>

            <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-slate-900/5">
                @if ($errors->any())
                    <div class="mb-6 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700 ring-1 ring-red-600/10">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.attempt') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700">Email address</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                            autocomplete="username"
                            class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-slate-900 ring-1 ring-slate-200 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-brand-500 sm:text-sm">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                        <input id="password" name="password" type="password" required autocomplete="current-password"
                            class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-slate-900 ring-1 ring-slate-200 focus:bg-white focus:ring-2 focus:ring-brand-500 sm:text-sm">
                    </div>

                    <label class="flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="remember" value="1"
                            class="rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                        Keep me signed in
                    </label>

                    <button type="submit"
                        class="w-full rounded-lg bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2">
                        Sign in
                    </button>
                </form>
            </div>

            <p class="mt-6 text-center text-xs text-slate-400">
                &copy; {{ date('Y') }} {{ config('app.name') }}
            </p>
        </div>
    </div>
</body>

</html>
