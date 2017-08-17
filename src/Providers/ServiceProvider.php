<?php

namespace Denpa\Bitcoin\Providers;

use Denpa\Bitcoin\Client as BitcoinClient;
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

        $this->registerClient();
    }

    /**
     * Register aliases.
     *
     * @return void
     */
    protected function registerAliases()
    {
        $aliases = [
            'bitcoind' => 'Denpa\Bitcoin\Client',
        ];

        foreach ($aliases as $key => $aliases) {
            foreach ((array) $aliases as $alias) {
                $this->app->alias($key, $alias);
            }
        }
    }

    /**
     * Register client.
     *
     * @return void
     */
    protected function registerClient()
    {
        $this->app->singleton('bitcoind', function ($app) {
            return new BitcoinClient([
                'scheme' => $app['config']->get('bitcoind.scheme', 'http'),
                'host'   => $app['config']->get('bitcoind.host', 'localhost'),
                'port'   => $app['config']->get('bitcoind.port', 8332),
                'user'   => $app['config']->get('bitcoind.user'),
                'pass'   => $app['config']->get('bitcoind.password'),
                'ca'     => $app['config']->get('bitcoind.ca')
            ]);
        });
    }
}
