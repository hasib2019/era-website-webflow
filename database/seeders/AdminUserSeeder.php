<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed accounts, one per role, so the multi-admin behaviour can be exercised
     * straight after install. Passwords come from .env when set.
     */
    private const ACCOUNTS = [
        ['Super Admin', 'superadmin@erainfotechbd.com', 'super-admin', 'Managing Director'],
        ['Site Administrator', 'admin@erainfotechbd.com', 'admin', 'Administrator'],
        ['Content Editor', 'editor@erainfotechbd.com', 'editor', 'Content Editor'],
        ['Blog Author', 'author@erainfotechbd.com', 'author', 'Author'],
    ];

    public function run(): void
    {
        $password = env('SEED_ADMIN_PASSWORD', 'Era@2026!');

        foreach (self::ACCOUNTS as [$name, $email, $roleSlug, $designation]) {
            $user = User::withTrashed()->updateOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'password' => Hash::make($password),
                    'designation' => $designation,
                    'is_active' => true,
                    'email_verified_at' => now(),
                    'deleted_at' => null,
                ],
            );

            $role = Role::where('slug', $roleSlug)->first();
            if ($role) {
                $user->roles()->sync([$role->id]);
            }
        }
    }
}
