<?php

namespace App\Providers;

use URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $protocol = Str::startsWith(config('app.url'), 'https://') ? 'https' : 'http';

        URL::forceSchema($protocol);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
