<?php

namespace App\Providers;

use App\Support\Content;
use Illuminate\Support\Facades\View;
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

        $this->shareSiteHead();
    }

    /**
     * Supplies the `$site` array the head partial has always read.
     *
     * site/partials/head.blade.php reads $site['favicon'], ['webclip'],
     * ['og_image'], ['meta_title'] and ['meta_description'] — but nothing ever
     * defined $site, so every one of them fell through to the export's own
     * hardcoded URL. Five editable settings looked live and reached nothing.
     *
     * A composer rather than View::share, so the settings query only runs for
     * requests that actually render the head.
     */
    private function shareSiteHead(): void
    {
        View::composer('site.partials.head', function ($view) {
            // set by Site\PageController::render(); absent on the error views
            $slug = (string) (View::shared('cmsPageSlug') ?? '');

            $view->with('site', [
                'meta_title' => setting('seo.meta_title', config('app.name')),

                // the page's own description first, then the site default
                'meta_description' => ($slug === '' ? null : Content::pageMeta($slug, 'meta_description'))
                    ?? setting('seo.meta_description', ''),

                // null at the end falls through to the literal in the partial
                'og_image' => ($slug === '' ? null : Content::pageImage($slug))
                    ?? setting_image('seo.og_image_id'),

                'favicon' => setting_image('general.favicon_id'),
                'webclip' => setting_image('general.webclip_id'),
            ]);
        });
    }
}
