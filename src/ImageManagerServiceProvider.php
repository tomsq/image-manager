<?php

namespace Tomsq\ImageManager;

use Illuminate\Support\ServiceProvider;

class ImageManagerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load Package Routes
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        // Publish files
        $this->publishes([
            __DIR__ . '/config/image-manager.php' => config_path('/image-manager.php'),
        ], 'config');


        if (!class_exists('CreateImagesTable')) {
            $this->publishes([
                __DIR__ . '/database/migrations/create_images_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_images_table.php'),
            ], 'migrations');
        }
    }

    public function register()
    {
        app()->bind('ImageManager', function () {
            return new ImageManager();
        });

        $this->mergeConfigFrom(__DIR__.'/config/image-manager.php', 'image-manager');
    }
}
