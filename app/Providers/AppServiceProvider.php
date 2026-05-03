<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::defaultView('vendor.pagination.dashboard');

        // Share Website Settings globally
        if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
            $webSettings = \App\Models\Setting::all()->pluck('value', 'key');
            \Illuminate\Support\Facades\View::share('webSettings', $webSettings);
        }
    }
}
