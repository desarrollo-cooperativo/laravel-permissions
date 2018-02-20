<?php

namespace Cardumen\LaravelPermissions;

use Illuminate\Support\ServiceProvider;

class LaravelPermissions extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');


        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\PermissionsManager::class,
            ]);
        }

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }


}
