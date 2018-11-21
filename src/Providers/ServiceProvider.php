<?php

declare(strict_types=1);

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
    public function boot() : void
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
    public function register() : void
    {
        $this->registerAliases();

        $this->registerFactory();
        $this->registerClient();
    }

    /**
     * Register aliases.
     *
     * @return void
     */
    protected function registerAliases() : void
    {
        $aliases = [
            'bitcoind'         => 'Denpa\Bitcoin\ClientFactory',
            'bitcoind.client'  => 'Denpa\Bitcoin\LaravelClient',
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
    protected function registerFactory() : void
    {
        $this->app->singleton('bitcoind', function ($app) {
            return new ClientFactory(config('bitcoind'), $app['log']);
        });
    }

    /**
     * Register client shortcut.
     *
     * @return void
     */
    protected function registerClient() : void
    {
        $this->app->bind('bitcoind.client', function ($app) {
            return $app['bitcoind']->client();
        });
    }
}
