<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
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
        Schema::defaultStringLength(191);

        // Set the default timezone to 'Asia/Kolkata'
        config(['app.timezone' => 'Asia/Kolkata']);
        date_default_timezone_set(config('app.timezone'));
        Carbon::setLocale(config('app.locale'));
    }
}
