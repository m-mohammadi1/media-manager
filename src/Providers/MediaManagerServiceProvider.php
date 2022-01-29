<?php

namespace MediaManager\Providers;

use Illuminate\Support\ServiceProvider;

class MediaManagerServiceProvider extends ServiceProvider
{
    public function register()
    {
         $this->mergeConfigFrom(__DIR__.'/../../config/media-manager.php', 'media_manager');
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__. '/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');


    }
}
