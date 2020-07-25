<?php

namespace App\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use App\Library\Services\MongoDB;

class MongoServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //container bindings
        $this->app->singleton(MongoDB::class, function ($app) {
            $mongoConfig = $app['config']['database']['mongodb'];
            return new MongoDB($mongoConfig['host'], $mongoConfig['port'], $mongoConfig['username'], $mongoConfig['password'], $mongoConfig['database'], $mongoConfig['srv'], $mongoConfig['options']);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [MongoDB::class];
    }
}
