@extends('admin.layouts.app')

@section('title', 'Activity log')
@section('subheading', 'Who changed what')

@section('content')
    <form method="GET" class="mb-5 flex flex-wrap gap-3">
        <select name="user" onchange="this.form.submit()"
            class="rounded-lg border-0 bg-white px-3.5 py-2 text-sm ring-1 ring-slate-200 focus:ring-2 focus:ring-brand-500">
            <option value="">All users</option>
            @foreach ($users as $id => $name)
                <option value="{{ $id }}" @selected((int) request('user') === $id)>{{ $name }}</option>
            @endforeach
        </select>
        <select name="action" onchange="this.form.submit()"
            class="rounded-lg border-0 bg-white px-3.5 py-2 text-sm ring-1 ring-slate-200 focus:ring-2 focus:ring-brand-500">
            <option value="">All actions</option>
            @foreach ($actions as $action)
                <option value="{{ $action }}" @selected(request('action') === $action)>{{ ucfirst($action) }}</option>
            @endforeach
        </select>
    </form>

    <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-slate-900/5">
        <ul class="divide-y divide-slate-100">
            @forelse ($entries as $entry)
                <li class="px-5 py-4">
                    <div class="flex flex-wrap items-baseline gap-x-3 gap-y-1">
                        <span class="inline-flex rounded-full bg-slate-100 px-2 py-0.5 text-[11px] font-medium uppercase tracking-wide text-slate-600">
                            {{ $entry->action }}
                        </span>
                        <p class="text-sm text-slate-800">{{ $entry->description }}</p>
                        <p class="ml-auto text-xs text-slate-400">
                            {{ $entry->user?->name ?? 'System' }} &middot; {{ $entry->created_at->format('j M Y, g:i a') }}
                        </p>
                    </div>

                    @if ($entry->changes)
                        <details class="mt-2">
                            <summary class="cursor-pointer text-xs font-medium text-brand-700 hover:underline">
                                {{ count($entry->changes) }} {{ Str::plural('field', count($entry->changes)) }} changed
                            </summary>
                            <dl class="mt-2 space-y-1.5 rounded-lg bg-slate-50 p-3 text-xs">
                                @foreach ($entry->changes as $field => $change)
                                    <div class="grid gap-1 sm:grid-cols-[10rem_1fr]">
                                        <dt class="font-medium text-slate-600">{{ Str::headline($field) }}</dt>
                                        @php
                                            $render = fn ($v) => $v === null || $v === ''
                                                ? '—'
                                                : Str::limit(is_scalar($v) ? (string) $v : json_encode($v), 80);
                                        @endphp
                                        <dd class="min-w-0 break-words text-slate-500">
                                            <span class="line-through opacity-60">{{ $render($change['from'] ?? null) }}</span>
                                            <span class="mx-1">&rarr;</span>
                                            <span class="text-slate-800">{{ $render($change['to'] ?? null) }}</span>
                                        </dd>
                                    </div>
                                @endforeach
                            </dl>
                        </details>
                    @endif
                </li>
            @empty
                <li class="px-5 py-12 text-center text-slate-500">Nothing logged yet.</li>
            @endforelse
        </ul>
    </div>

    @if ($entries->hasPages())
        <div class="mt-5">{{ $entries->links() }}</div>
    @endif
@endsection
