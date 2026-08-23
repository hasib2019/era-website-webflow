@extends('admin.layouts.app')

@section('title', 'My profile')

@section('content')
    @php $input = 'mt-1.5 block w-full rounded-lg border-0 bg-slate-50 px-3.5 py-2.5 text-sm ring-1 ring-slate-200 focus:bg-white focus:ring-2 focus:ring-brand-500'; @endphp

    <form method="POST" action="{{ route('admin.profile.update') }}" class="max-w-2xl space-y-6">
        @csrf
        @method('PUT')

        <section class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-900/5">
            <h2 class="mb-5 text-sm font-semibold uppercase tracking-wide text-slate-500">Details</h2>
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700">Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required class="{{ $input }}">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
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
        </section>

        <section class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-900/5">
            <h2 class="mb-1 text-sm font-semibold uppercase tracking-wide text-slate-500">Change password</h2>
            <p class="mb-5 text-xs text-slate-400">Leave blank to keep your current password.</p>
            <div class="grid gap-5 sm:grid-cols-3">
                <div>
                    <label for="current_password" class="block text-sm font-medium text-slate-700">Current</label>
                    <input id="current_password" type="password" name="current_password" autocomplete="current-password" class="{{ $input }}">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700">New</label>
                    <input id="password" type="password" name="password" autocomplete="new-password" class="{{ $input }}">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Confirm</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" class="{{ $input }}">
                </div>
            </div>
        </section>

        <button type="submit" class="rounded-lg bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-700">
            Save profile
        </button>
    </form>
@endsection
