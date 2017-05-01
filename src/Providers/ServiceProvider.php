<?php

namespace Denpa\Bitcoin\Providers;

use Denpa\Bitcoin\Client as BitcoinClient;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
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
        $this->app->singleton(BitcoinClient::class, function ($app) {
            return new BitcoinClient([
                'scheme' => config('bitcoind.scheme'),
                'host'   => config('bitcoind.host'),
                'port'   => config('bitcoind.port'),
                'user'   => config('bitcoind.user'),
                'pass'   => config('bitcoind.pass'),
                'ca'     => config('bitcoind.ca')
            ]);
        });
    }
}
