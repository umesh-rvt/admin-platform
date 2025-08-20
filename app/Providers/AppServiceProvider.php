<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Schema::defaultStringLength(191);
        
        // Share settings with all frontend views
        View::composer('layouts.frontend', function ($view) {
            $settings = Setting::getPublicAsArray();
            $view->with('settings', $settings);
        });
        
        // Also share with frontend page views
        View::composer('frontend.*', function ($view) {
            $settings = Setting::getPublicAsArray();
            $view->with('settings', $settings);
        });
    }
}
