<?php

namespace Tomsq\ImageManager;

use Illuminate\Support\ServiceProvider;

class ImageManagerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        app()->bind('ImageManager', function () {
            return new ImageManagerReal();
        });
    }

    public function register()
    { }
}
