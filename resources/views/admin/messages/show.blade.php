@extends('admin.layouts.app')

@section('title', 'Message from ' . $message->name)
@section('subheading', 'Messages')

@section('content')
    <a href="{{ route('admin.messages.index') }}" class="mb-5 inline-block text-sm font-medium text-slate-500 hover:text-slate-800">&larr; Inbox</a>

    <div class="grid max-w-4xl gap-6 lg:grid-cols-3">
        <section class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-900/5 lg:col-span-2">
            <h2 class="text-base font-semibold text-slate-900">{{ $message->subject ?: 'No subject' }}</h2>
            <p class="mt-1 text-sm text-slate-500">
                {{ $message->name }} &lt;{{ $message->email }}&gt;
                @if ($message->phone) &middot; {{ $message->phone }} @endif
            </p>
            <p class="mt-0.5 text-xs text-slate-400">{{ $message->created_at->format('j M Y, g:i a') }}</p>

            <div class="mt-5 whitespace-pre-line border-t border-slate-100 pt-5 text-sm leading-relaxed text-slate-700">{{ $message->message }}</div>

            <dl class="mt-6 grid gap-4 border-t border-slate-100 pt-5 text-sm sm:grid-cols-2">
                @foreach (['company' => 'Company', 'service_interest' => 'Interested in', 'budget' => 'Budget', 'ip_address' => 'IP address'] as $field => $label)
                    @if ($message->{$field})
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">{{ $label }}</dt>
                            <dd class="mt-0.5 text-slate-700">{{ $message->{$field} }}</dd>
                        </div>
                    @endif
                @endforeach
            </dl>

            <div class="mt-6 flex flex-wrap gap-3 border-t border-slate-100 pt-5">
                <a href="mailto:{{ $message->email }}"
                    class="rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-700">
                    Reply by email
                </a>
                @if (auth()->user()->hasPermission('messages.manage'))
                    <form method="POST" action="{{ route('admin.messages.destroy', $message) }}"
                        data-confirm="Delete this message permanently?">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="rounded-lg px-4 py-2 text-sm font-medium text-red-600 ring-1 ring-red-200 transition hover:bg-red-50">
                            Delete
                        </button>
                    </form>
                @endif
            </div>
        </section>

        @if (auth()->user()->hasPermission('messages.manage'))
            <section class="h-fit rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-900/5">
                <h2 class="mb-4 text-sm font-semibold uppercase tracking-wide text-slate-500">Handling</h2>
                <form method="POST" action="{{ route('admin.messages.update', $message) }}" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="status" class="block text-sm font-medium text-slate-700">Status</label>
                        <select id="status" name="status"
                            class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm ring-1 ring-slate-200 focus:bg-white focus:ring-2 focus:ring-brand-500">
                            @foreach (['new', 'read', 'replied', 'archived'] as $status)
                                <option value="{{ $status }}" @selected($message->status === $status)>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="admin_notes" class="block text-sm font-medium text-slate-700">Internal notes</label>
                        <textarea id="admin_notes" name="admin_notes" rows="5"
                            class="mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm ring-1 ring-slate-200 focus:bg-white focus:ring-2 focus:ring-brand-500">{{ $message->admin_notes }}</textarea>
                    </div>
                    <button type="submit"
                        class="w-full rounded-lg bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-700">
                        Save
                    </button>
                </form>
            </section>
        @endif
    </div>
@endsection
