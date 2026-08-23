@extends('admin.layouts.app')

@section('title', 'Roles')
@section('subheading', 'What each kind of administrator may do')

@section('content')
    <div class="mb-5 flex justify-end">
        <a href="{{ route('admin.roles.create') }}"
            class="inline-flex items-center gap-1.5 rounded-lg bg-brand-600 px-3.5 py-2 text-sm font-semibold text-white transition hover:bg-brand-700">
            @include('admin.partials.icon', ['name' => 'plus', 'class' => 'h-4 w-4'])
            New role
        </a>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($roles as $role)
            <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-900/5">
                <div class="flex items-start justify-between gap-3">
                    <h2 class="text-base font-semibold text-slate-900">{{ $role->name }}</h2>
                    @if ($role->is_system)
                        <span class="shrink-0 rounded-full bg-slate-100 px-2 py-0.5 text-[11px] font-medium text-slate-500">Built-in</span>
                    @endif
                </div>
                <p class="mt-1 text-xs text-slate-500">{{ $role->description }}</p>

                <dl class="mt-4 flex gap-5 text-xs text-slate-500">
                    <div><dt class="inline">Users:</dt> <dd class="inline font-medium text-slate-700">{{ $role->users_count }}</dd></div>
                    <div>
                        <dt class="inline">Permissions:</dt>
                        <dd class="inline font-medium text-slate-700">{{ $role->isSuperAdmin() ? 'All' : $role->permissions_count }}</dd>
                    </div>
                </dl>

                <div class="mt-4 flex items-center gap-3">
                    <a href="{{ route('admin.roles.edit', $role) }}" class="text-xs font-semibold text-brand-700 hover:underline">Edit</a>
                    @unless ($role->is_system)
                        <form method="POST" action="{{ route('admin.roles.destroy', $role) }}"
                            data-confirm="Delete the {{ $role->name }} role?">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs font-semibold text-red-600 hover:underline">Delete</button>
                        </form>
                    @endunless
                </div>
            </div>
        @endforeach
    </div>
@endsection
