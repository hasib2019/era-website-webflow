@extends('admin.layouts.app')

@section('title', 'Messages')
@section('subheading', $messages->total() . ' enquiries')

@section('content')
    <form method="GET" class="mb-5 flex flex-wrap gap-3">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Search messages…"
            class="w-full max-w-xs rounded-lg border-0 bg-white px-3.5 py-2 text-sm ring-1 ring-slate-200 focus:ring-2 focus:ring-brand-500">
        <select name="status" onchange="this.form.submit()"
            class="rounded-lg border-0 bg-white px-3.5 py-2 text-sm ring-1 ring-slate-200 focus:ring-2 focus:ring-brand-500">
            <option value="">All statuses</option>
            @foreach (['new', 'read', 'replied', 'archived'] as $status)
                <option value="{{ $status }}" @selected(request('status') === $status)>
                    {{ ucfirst($status) }} ({{ $counts[$status] ?? 0 }})
                </option>
            @endforeach
        </select>
    </form>

    <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-slate-900/5">
        <ul class="divide-y divide-slate-100">
            @forelse ($messages as $message)
                <li>
                    <a href="{{ route('admin.messages.show', $message) }}"
                        class="flex items-start gap-4 px-5 py-4 transition hover:bg-slate-50">
                        <span class="mt-1.5 h-2 w-2 shrink-0 rounded-full {{ $message->status === 'new' ? 'bg-brand-500' : 'bg-slate-200' }}"></span>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium text-slate-900">
                                {{ $message->name }}
                                <span class="font-normal text-slate-500">&middot; {{ $message->email }}</span>
                            </p>
                            @if ($message->subject)
                                <p class="text-sm text-slate-700">{{ $message->subject }}</p>
                            @endif
                            <p class="mt-0.5 truncate text-xs text-slate-500">{{ Str::limit($message->message, 140) }}</p>
                        </div>
                        <div class="shrink-0 text-right">
                            <span class="inline-flex rounded-full bg-slate-100 px-2 py-0.5 text-[11px] font-medium text-slate-600">{{ $message->status }}</span>
                            <p class="mt-1 text-xs text-slate-400">{{ $message->created_at->diffForHumans() }}</p>
                        </div>
                    </a>
                </li>
            @empty
                <li class="px-5 py-12 text-center text-slate-500">No messages yet.</li>
            @endforelse
        </ul>
    </div>

    @if ($messages->hasPages())
        <div class="mt-5">{{ $messages->links() }}</div>
    @endif
@endsection
