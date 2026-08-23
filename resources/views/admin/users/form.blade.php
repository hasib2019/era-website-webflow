@extends('admin.layouts.app')

@section('title', $user->exists ? 'Edit ' . $user->name : 'New admin user')
@section('subheading', 'Admin users')

@section('content')
    @php $input = 'mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm ring-1 ring-slate-200 focus:bg-white focus:ring-2 focus:ring-brand-500'; @endphp

    <form method="POST" action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}"
        class="max-w-3xl space-y-6">
        @csrf
        @if ($user->exists)
            @method('PUT')
        @endif

        <section class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-900/5">
            <h2 class="mb-5 text-sm font-semibold uppercase tracking-wide text-slate-500">Account</h2>
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700">Full name</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required class="{{ $input }}">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700">Email address</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required class="{{ $input }}">
                </div>
                <div>
                    <label for="designation" class="block text-sm font-medium text-slate-700">Designation</label>
                    <input id="designation" type="text" name="designation" value="{{ old('designation', $user->designation) }}" class="{{ $input }}">
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-slate-700">Phone</label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="{{ $input }}">
                </div>
            </div>

            <label class="mt-5 flex items-center gap-2.5 text-sm font-medium text-slate-700">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $user->exists ? $user->is_active : true))
                    class="h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                Account is active
            </label>
        </section>

        <section class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-900/5">
            <h2 class="mb-1 text-sm font-semibold uppercase tracking-wide text-slate-500">Password</h2>
            <p class="mb-5 text-xs text-slate-400">
                {{ $user->exists ? 'Leave blank to keep the current password.' : 'At least 8 characters.' }}
            </p>
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700">New password</label>
                    <input id="password" type="password" name="password" autocomplete="new-password"
                        {{ $user->exists ? '' : 'required' }} class="{{ $input }}">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Confirm password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password"
                        {{ $user->exists ? '' : 'required' }} class="{{ $input }}">
                </div>
            </div>
        </section>

        <section class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-900/5">
            <h2 class="mb-1 text-sm font-semibold uppercase tracking-wide text-slate-500">Roles</h2>
            <p class="mb-5 text-xs text-slate-400">A user gets the combined permissions of every role selected.</p>

            @php $current = old('roles', $user->roles->pluck('id')->all()); @endphp
            <div class="grid gap-3 sm:grid-cols-2">
                @foreach ($roles as $role)
                    @php $locked = $role->isSuperAdmin() && ! auth()->user()->isSuperAdmin(); @endphp
                    <label class="flex items-start gap-3 rounded-lg p-3 ring-1 {{ in_array($role->id, (array) $current) ? 'bg-brand-50 ring-brand-200' : 'ring-slate-200' }} {{ $locked ? 'opacity-50' : '' }}">
                        <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                            @checked(in_array($role->id, (array) $current)) @disabled($locked)
                            class="mt-0.5 h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                        <span class="min-w-0">
                            <span class="block text-sm font-medium text-slate-900">{{ $role->name }}</span>
                            <span class="block text-xs text-slate-500">{{ $role->description }}</span>
                            @if ($locked)
                                <span class="mt-1 block text-[11px] font-medium text-amber-700">Only a super admin can grant this.</span>
                            @endif
                        </span>
                    </label>
                @endforeach
            </div>
        </section>

        <div class="flex items-center gap-3">
            <button type="submit" class="rounded-lg bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-700">
                {{ $user->exists ? 'Save changes' : 'Create admin user' }}
            </button>
            <a href="{{ route('admin.users.index') }}"
                class="rounded-lg px-4 py-2.5 text-sm font-medium text-slate-600 ring-1 ring-slate-200 transition hover:bg-white">Cancel</a>
        </div>
    </form>
@endsection
