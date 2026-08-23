@extends('admin.layouts.app')

@section('title', 'Job applications')
@section('subheading', $applications->total() . ' applications')

@section('content')
    <form method="GET" class="mb-5">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Search applicants…"
            class="w-full max-w-xs rounded-lg border-0 bg-white px-3.5 py-2 text-sm ring-1 ring-slate-200 focus:ring-2 focus:ring-brand-500">
    </form>

    <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-slate-900/5">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Applicant</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Applied for</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Received</th>
                    <th class="w-px px-4 py-3"><span class="sr-only">Resume</span></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($applications as $application)
                    <tr class="hover:bg-slate-50/70">
                        <td class="px-4 py-3">
                            <p class="font-medium text-slate-900">{{ $application->name }}</p>
                            <p class="text-xs text-slate-500">{{ $application->email }}</p>
                        </td>
                        <td class="px-4 py-3 text-slate-600">{{ $application->jobOpening?->title ?? '—' }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-600">{{ $application->status }}</span>
                        </td>
                        <td class="px-4 py-3 text-xs text-slate-500">{{ $application->created_at->diffForHumans() }}</td>
                        <td class="px-4 py-3 text-right">
                            @if ($application->resume_path)
                                <a href="{{ Storage::disk('public')->url($application->resume_path) }}" target="_blank" rel="noopener"
                                    class="text-xs font-semibold text-brand-700 hover:underline">Resume</a>
                            @else
                                <span class="text-xs text-slate-400">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center text-slate-500">No applications yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($applications->hasPages())
        <div class="mt-5">{{ $applications->links() }}</div>
    @endif
@endsection
