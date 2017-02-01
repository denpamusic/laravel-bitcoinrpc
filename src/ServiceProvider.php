<?php

namespace Denpa\Bitcoin;

use Denpa\Bitcoin\Client;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/bitcoind.php' => config_path('bitcoind.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/bitcoind.php', 'bitcoind');

        $this->app->singleton(Client::class, function ($app) {
            return new Client([
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
