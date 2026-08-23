@extends('admin.layouts.app')

@section('title', 'Subscribers')
@section('subheading', $subscribers->total() . ' newsletter signups')

@section('content')
    <form method="GET" class="mb-5">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Search by email…"
            class="w-full max-w-xs rounded-lg border-0 bg-white px-3.5 py-2 text-sm ring-1 ring-slate-200 focus:ring-2 focus:ring-brand-500">
    </form>

    <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-slate-900/5">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Email</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Source</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Signed up</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($subscribers as $subscriber)
                    <tr class="hover:bg-slate-50/70">
                        <td class="px-4 py-3 font-medium text-slate-900">{{ $subscriber->email }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $subscriber->source ?? '—' }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium {{ $subscriber->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                {{ $subscriber->is_active ? 'Active' : 'Unsubscribed' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-xs text-slate-500">{{ $subscriber->created_at->format('j M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-12 text-center text-slate-500">No subscribers yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($subscribers->hasPages())
        <div class="mt-5">{{ $subscribers->links() }}</div>
    @endif
@endsection
