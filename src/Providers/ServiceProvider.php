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
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../../config/bitcoind.php' => config_path('bitcoind.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/bitcoind.php', 'bitcoind'
        );

        $this->registerAliases();

        $this->registerFactory();
        $this->registerClient();
    }

    /**
     * Register aliases.
     *
     * @return void
     */
    protected function registerAliases(): void
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
    protected function registerFactory(): void
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
    protected function registerClient(): void
    {
        $this->app->bind('bitcoind.client', function ($app) {
            return $app['bitcoind']->client();
        });
    }
}
