<?php

namespace App\Providers;

use Storage;
use Enl\Flysystem\Cloudinary\ApiFacade;
use CarlosOCarvalho\Flysystem\Cloudinary\CloudinaryAdapter;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;


class CloudinaryServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot() {
        Storage::extend('cloudinary', function ($app, $config) {
            return new Filesystem(new CloudinaryAdapter($config));
        });

        $this->app->singleton('cloudinary.api', function ($app) {
            return new ApiFacade(config('filesystems.disks.cloudinary'));
        });
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register() {
        //
    }
}
