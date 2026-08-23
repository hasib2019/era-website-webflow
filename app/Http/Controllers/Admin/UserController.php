<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Support\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

/**
 * Administrator accounts. Roles decide what each one may reach, and a few
 * guards keep the install from losing its last super admin.
 */
class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('roles')->orderBy('name');

        if ($term = trim((string) $request->get('q'))) {
            $query->where(fn ($q) => $q->where('name', 'like', "%{$term}%")->orWhere('email', 'like', "%{$term}%"));
        }

        return view('admin.users.index', [
            'users' => $query->paginate(20)->withQueryString(),
        ]);
    }

    public function create()
    {
        return view('admin.users.form', [
            'user' => new User(),
            'roles' => Role::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'phone' => ['nullable', 'string', 'max:40'],
            'designation' => ['nullable', 'string', 'max:255'],
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['exists:roles,id'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'] ?? null,
            'designation' => $data['designation'] ?? null,
            'is_active' => $request->boolean('is_active'),
            'email_verified_at' => now(),
        ]);

        $user->roles()->sync($this->assignableRoles($request, $data['roles']));

        ActivityLogger::log('created', $user, 'Created admin user: ' . $user->email);

        return redirect()->route('admin.users.index')->with('success', 'Admin user created.');
    }

    public function edit(User $user)
    {
        return view('admin.users.form', [
            'user' => $user->load('roles'),
            'roles' => Role::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Password::min(8)],
            'phone' => ['nullable', 'string', 'max:40'],
            'designation' => ['nullable', 'string', 'max:255'],
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['exists:roles,id'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $active = $request->boolean('is_active');

        // never let the signed-in admin lock themselves out
        if ($user->is($request->user()) && ! $active) {
            return back()->with('error', 'You cannot deactivate your own account.');
        }

        $roles = $this->assignableRoles($request, $data['roles']);

        if ($this->wouldOrphanSuperAdmin($user, $roles)) {
            return back()->with('error', 'At least one active super admin must remain.');
        }

        $user->fill([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'designation' => $data['designation'] ?? null,
            'is_active' => $active,
        ]);

        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();
        $user->roles()->sync($roles);

        ActivityLogger::log('updated', $user, 'Updated admin user: ' . $user->email, ActivityLogger::diff($user));

        return redirect()->route('admin.users.index')->with('success', 'Admin user updated.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->is($request->user())) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        if ($this->wouldOrphanSuperAdmin($user, [])) {
            return back()->with('error', 'At least one active super admin must remain.');
        }

        ActivityLogger::log('deleted', $user, 'Deleted admin user: ' . $user->email);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Admin user removed.');
    }

    /** Only a super admin may hand out the super admin role. */
    private function assignableRoles(Request $request, array $roleIds): array
    {
        if ($request->user()->isSuperAdmin()) {
            return $roleIds;
        }

        $superAdminId = Role::where('slug', Role::SUPER_ADMIN)->value('id');

        return array_values(array_diff($roleIds, [$superAdminId]));
    }

    /** True when the change would leave no active super admin behind. */
    private function wouldOrphanSuperAdmin(User $user, array $newRoleIds): bool
    {
        if (! $user->isSuperAdmin()) {
            return false;
        }

        $superAdminId = Role::where('slug', Role::SUPER_ADMIN)->value('id');

        if (in_array($superAdminId, array_map('intval', $newRoleIds), true)) {
            return false;
        }

        $remaining = User::where('is_active', true)
            ->whereKeyNot($user->id)
            ->whereHas('roles', fn ($q) => $q->where('slug', Role::SUPER_ADMIN))
            ->count();

        return $remaining === 0;
    }
}
