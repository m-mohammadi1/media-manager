<?php

namespace MediaManager\Providers;

use Illuminate\Support\ServiceProvider;

class MediaManagerServiceProvider extends ServiceProvider
{
    public function register()
    {
        // $this->mergeConfigFrom(__DIR__.'/config/mediamanager_config.php', 'mediamanager');
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
    }
}
