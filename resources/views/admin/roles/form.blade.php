@extends('admin.layouts.app')

@section('title', $role->exists ? 'Edit ' . $role->name : 'New role')
@section('subheading', 'Roles')

@section('content')
    @php
        $input = 'mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm ring-1 ring-slate-200 focus:bg-white focus:ring-2 focus:ring-brand-500';
        $current = old('permissions', $role->permissions->pluck('id')->all());
    @endphp

    <form method="POST" action="{{ $role->exists ? route('admin.roles.update', $role) : route('admin.roles.store') }}"
        class="max-w-3xl space-y-6">
        @csrf
        @if ($role->exists)
            @method('PUT')
        @endif

        <section class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-900/5">
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700">Role name</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $role->name) }}" required
                        @readonly($role->is_system) class="{{ $input }} @if($role->is_system) opacity-60 @endif">
                    @if ($role->is_system)
                        <p class="mt-1 text-xs text-slate-400">Built-in roles keep their name.</p>
                    @endif
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700">Description</label>
                    <input id="description" type="text" name="description" value="{{ old('description', $role->description) }}" class="{{ $input }}">
                </div>
            </div>
        </section>

        <section class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-900/5">
            <h2 class="mb-1 text-sm font-semibold uppercase tracking-wide text-slate-500">Permissions</h2>

            @if ($role->isSuperAdmin())
                <p class="rounded-lg bg-amber-50 px-4 py-3 text-sm text-amber-800 ring-1 ring-amber-600/10">
                    The super admin role always holds every permission, so this grid is locked.
                </p>
            @else
                <p class="mb-5 text-xs text-slate-400">Tick everything this role should be able to reach.</p>
                <div class="space-y-6">
                    @foreach ($permissions as $group => $items)
                        <div>
                            <p class="mb-2.5 text-xs font-semibold uppercase tracking-wide text-slate-400">{{ $group }}</p>
                            <div class="grid gap-2 sm:grid-cols-2">
                                @foreach ($items as $permission)
                                    <label class="flex items-center gap-2.5 rounded-lg px-3 py-2 text-sm ring-1 {{ in_array($permission->id, (array) $current) ? 'bg-brand-50 text-brand-900 ring-brand-200' : 'text-slate-700 ring-slate-200' }}">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                            @checked(in_array($permission->id, (array) $current))
                                            class="h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                                        {{ $permission->name }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        <div class="flex items-center gap-3">
            <button type="submit" class="rounded-lg bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-700">
                {{ $role->exists ? 'Save role' : 'Create role' }}
            </button>
            <a href="{{ route('admin.roles.index') }}"
                class="rounded-lg px-4 py-2.5 text-sm font-medium text-slate-600 ring-1 ring-slate-200 transition hover:bg-white">Cancel</a>
        </div>
    </form>
@endsection
