<?php

namespace Denpa\Bitcoin\Providers;

use Denpa\Bitcoin\ClientFactory;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $path = realpath(__DIR__.'/../../config/config.php');

        $this->publishes([$path => config_path('bitcoind.php')], 'config');
        $this->mergeConfigFrom($path, 'bitcoind');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerAliases();

        $this->registerFactory();
    }

    /**
     * Register aliases.
     *
     * @return void
     */
    protected function registerAliases()
    {
        $aliases = [
            'bitcoind' => 'Denpa\Bitcoin\ClientFactory',
        ];

        foreach ($aliases as $key => $aliases) {
            foreach ((array) $aliases as $alias) {
                $this->app->alias($key, $alias);
            }
        }
    }

    /**
     * Register client factory.
     *
     * @return void
     */
    protected function registerFactory()
    {
        $this->app->singleton('bitcoind', function ($app) {
            return new ClientFactory(config('bitcoind'));
        });
    }
}
