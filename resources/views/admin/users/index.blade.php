@extends('admin.layouts.app')

@section('title', 'Admin users')
@section('subheading', $users->total() . ' accounts')

@section('content')
    <div class="mb-5 flex flex-wrap items-center gap-3">
        <form method="GET" class="flex-1 min-w-56">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Search by name or email…"
                class="w-full max-w-sm rounded-lg border-0 bg-white px-3.5 py-2 text-sm ring-1 ring-slate-200 focus:ring-2 focus:ring-brand-500">
        </form>
        @if (auth()->user()->hasPermission('users.manage'))
            <a href="{{ route('admin.users.create') }}"
                class="inline-flex items-center gap-1.5 rounded-lg bg-brand-600 px-3.5 py-2 text-sm font-semibold text-white transition hover:bg-brand-700">
                @include('admin.partials.icon', ['name' => 'plus', 'class' => 'h-4 w-4'])
                New admin
            </a>
        @endif
    </div>

    <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-slate-900/5">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">User</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Roles</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Last seen</th>
                    <th class="w-px px-4 py-3"><span class="sr-only">Actions</span></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($users as $user)
                    <tr class="hover:bg-slate-50/70">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <img src="{{ $user->avatar_url }}" alt="" class="h-9 w-9 rounded-full bg-slate-200 object-cover">
                                <div class="min-w-0">
                                    <p class="truncate font-medium text-slate-900">{{ $user->name }}</p>
                                    <p class="truncate text-xs text-slate-500">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            @foreach ($user->roles as $role)
                                <span class="mr-1 inline-flex rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-600">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium {{ $user->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' }}">
                                {{ $user->is_active ? 'Active' : 'Disabled' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-xs text-slate-500">
                            {{ $user->last_login_at?->diffForHumans() ?? 'Never' }}
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 text-right">
                            @if (auth()->user()->hasPermission('users.manage'))
                                <a href="{{ route('admin.users.edit', $user) }}"
                                    class="rounded-md px-2.5 py-1.5 text-xs font-semibold text-brand-700 hover:bg-brand-50">Edit</a>
                                @unless ($user->is(auth()->user()))
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline"
                                        data-confirm="Remove {{ $user->name }}'s access?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-md px-2.5 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50">Delete</button>
                                    </form>
                                @endunless
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ($users->hasPages())
        <div class="mt-5">{{ $users->links() }}</div>
    @endif
@endsection
