<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
         * The media library has to exist before the content seeders run: they
         * resolve image filenames to media ids, and anything seeded first ends
         * up with a null image. The command is idempotent.
         */
        Artisan::call('media:import-webflow');

        $this->call([
            RolePermissionSeeder::class,
            AdminUserSeeder::class,
            SettingsSeeder::class,
            MenuSeeder::class,
            ContentSeeder::class,
            PageContentSeeder::class,
            DetailContentSeeder::class,
        ]);
    }
}
