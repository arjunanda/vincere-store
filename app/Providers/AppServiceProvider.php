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
        if (config('app.env') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        Paginator::defaultView('vendor.pagination.dashboard');

        // Share Website Settings & Payment Methods globally (Cached for performance)
        if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
            $webSettings = \Illuminate\Support\Facades\Cache::rememberForever('web_settings', function () {
                return \App\Models\Setting::all()->pluck('value', 'key')->toArray();
            });
            \Illuminate\Support\Facades\View::share('webSettings', $webSettings);
        }

        if (\Illuminate\Support\Facades\Schema::hasTable('payment_methods')) {
            $paymentMethodsArray = \Illuminate\Support\Facades\Cache::rememberForever('active_payment_methods', function () {
                return \App\Models\PaymentMethod::where('is_active', true)->get()->toArray();
            });
            
            // Map back to objects so views can use $method->name
            $paymentMethods = collect($paymentMethodsArray)->map(fn($item) => (object) $item);
            
            \Illuminate\Support\Facades\View::share('paymentMethods', $paymentMethods);
        }
    }
}
