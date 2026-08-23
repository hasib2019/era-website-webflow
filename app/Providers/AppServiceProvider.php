<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
class AppServiceProvider extends ServiceProvider
{
    
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /*
         * Keeps indexed varchars inside the limits of older MySQL builds:
         * 191 * 4 bytes (utf8mb4) = 764, just under InnoDB's 767-byte prefix.
         *
         * This alone is not enough — the composite unique keys on `settings`
         * and `media` still come to 1528 bytes, which is why config/database.php
         * also forces InnoDB with ROW_FORMAT=DYNAMIC.
         */
        Schema::defaultStringLength(191);
    }
}
