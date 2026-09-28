<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        // NOTE: intentionally not cached as a model instance — this
        // environment's database cache store fails to unserialize Eloquent
        // models (produces __PHP_Incomplete_Class). It's a single cheap
        // row lookup, so we just query it directly on every request.
        View::composer(['partials.header', 'partials.footer', 'pages.*'], function ($view) {
            $view->with('settings', SiteSetting::current());
        });
    }
}
