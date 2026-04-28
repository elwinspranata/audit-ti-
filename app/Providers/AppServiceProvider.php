<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
        if (config('app.env') !== 'local') {
            URL::forceScheme('https');
        }

        // Share site settings with all views
        if (!app()->runningInConsole() && \Schema::hasTable('site_settings')) {
            $site_settings = \App\Models\SiteSetting::all()->pluck('value', 'key')->toArray();
            view()->share('site_settings', $site_settings);
        }
    }
}
