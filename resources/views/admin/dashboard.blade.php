@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('subheading', 'Welcome back, ' . Str::before(auth()->user()->name, ' '))

@section('content')
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($tiles as $tile)
            <a href="{{ route($tile['route']) }}"
                class="group rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-900/5 transition hover:shadow-md hover:ring-brand-200">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">{{ $tile['label'] }}</p>
                        <p class="mt-2 text-3xl font-semibold tabular-nums text-slate-900">{{ number_format($tile['value']) }}</p>
                    </div>
                    <span class="rounded-lg bg-brand-50 p-2 text-brand-600 transition group-hover:bg-brand-100">
                        @include('admin.partials.icon', ['name' => $tile['icon'], 'class' => 'h-5 w-5'])
                    </span>
                </div>
            </a>
        @endforeach
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-3">
        @if ($pages->isNotEmpty())
            <section class="rounded-xl bg-white shadow-sm ring-1 ring-slate-900/5 lg:col-span-2">
                <header class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                    <h2 class="text-sm font-semibold text-slate-900">Edit page content</h2>
                    <a href="{{ route('admin.pages.index') }}" class="text-xs font-medium text-brand-700 hover:underline">All pages</a>
                </header>
                <ul class="divide-y divide-slate-100">
                    @foreach ($pages as $page)
                        <li>
                            <a href="{{ route('admin.pages.edit', $page) }}"
                                class="flex items-center justify-between px-5 py-3 transition hover:bg-slate-50">
                                <div>
                                    <p class="text-sm font-medium text-slate-900">{{ $page->name }}</p>
                                    <p class="text-xs text-slate-500">/{{ $page->slug === 'home' ? '' : $page->slug }}</p>
                                </div>
                                <span class="text-xs text-slate-400">{{ $page->sections()->count() }} sections</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif

        <section class="rounded-xl bg-white shadow-sm ring-1 ring-slate-900/5">
            <header class="border-b border-slate-100 px-5 py-4">
                <h2 class="text-sm font-semibold text-slate-900">Recent activity</h2>
            </header>
            @if ($recentActivity->isEmpty())
                <p class="px-5 py-8 text-center text-sm text-slate-400">Nothing logged yet.</p>
            @else
                <ul class="divide-y divide-slate-100">
                    @foreach ($recentActivity as $entry)
                        <li class="px-5 py-3">
                            <p class="text-sm text-slate-700">{{ $entry->description }}</p>
                            <p class="mt-0.5 text-xs text-slate-400">
                                {{ $entry->user?->name ?? 'System' }} &middot; {{ $entry->created_at->diffForHumans() }}
                            </p>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>
    </div>

    @if ($recentMessages->isNotEmpty())
        <section class="mt-6 rounded-xl bg-white shadow-sm ring-1 ring-slate-900/5">
            <header class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                <h2 class="text-sm font-semibold text-slate-900">Latest messages</h2>
                <a href="{{ route('admin.messages.index') }}" class="text-xs font-medium text-brand-700 hover:underline">Inbox</a>
            </header>
            <ul class="divide-y divide-slate-100">
                @foreach ($recentMessages as $message)
                    <li>
                        <a href="{{ route('admin.messages.show', $message) }}"
                            class="flex items-center gap-4 px-5 py-3 transition hover:bg-slate-50">
                            <span class="h-2 w-2 shrink-0 rounded-full {{ $message->status === 'new' ? 'bg-brand-500' : 'bg-slate-200' }}"></span>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-slate-900">{{ $message->name }} &middot;
                                    <span class="font-normal text-slate-500">{{ $message->email }}</span></p>
                                <p class="truncate text-xs text-slate-500">{{ Str::limit($message->message, 90) }}</p>
                            </div>
                            <span class="shrink-0 text-xs text-slate-400">{{ $message->created_at->diffForHumans() }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </section>
    @endif
@endsection
