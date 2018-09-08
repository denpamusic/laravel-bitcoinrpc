<?php

namespace Denpa\Bitcoin;

use Denpa\Bitcoin\Client as BitcoinClient;

class ClientFactory
{
    /**
     * Client configurations.
     *
     * @var array
     */
    protected $config;

    /**
     * Client instances.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $clients;

    /**
     * Constructs client factory instance.
     *
     * @param  array  $config
     *
     * @return void
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->clients = collect();
    }

    /**
     * Appends configuration array with default values.
     *
     * @param  array  $config
     *
     * @return array
     */
    protected function withDefaults(array $config = [])
    {
        return array_merge([
            'scheme'   => 'http',
            'host'     => 'localhost',
            'port'     => 8332,
            'user'     => null,
            'password' => null,
            'ca'       => null,
        ], $config);
    }

    /**
     * Gets client config by name.
     *
     * @param  array  $config
     *
     * @return array
     */
    public function getConfig($name = 'default')
    {
        if (isset($this->config['host']) && ! is_array($this->config['host'])) {
            /*
             * Legacy config format with single configuration.
             * Please update it manually or via 'php artisan vendor:publish'
             * See: https://github.com/denpamusic/laravel-bitcoinrpc/blob/master/config/config.php
             */
            return $this->withDefaults($this->config);
        }

        if ($name == 'default') {
            reset($this->config);
            $name = key($this->config);
        }

        if (! array_key_exists($name, $this->config)) {
            throw new \Exception("Could not find client configuration [$name]");
        }

        return $this->withDefaults($this->config[$name]);
    }

    /**
     * Gets client instance by name or creates if not exists.
     *
     * @param  string  $name
     *
     * @return \Denpa\Bitcoin\Client
     */
    public function client($name = 'default')
    {
        if (! $this->clients->has($name)) {
            $config = $this->getConfig($name);

            $this->clients->put($name, $this->make($config));
        }

        return $this->clients->get($name);
    }

    /**
     * Creates client instance.
     *
     * @param  array  $config
     *
     * @return \Denpa\Bitcoin\Client
     */
    public function make(array $config = [])
    {
        return new BitcoinClient($config);
    }

    /**
     * Pass methods onto the default client.
     *
     * @param  string  $method
     * @param  array   $parameters
     *
     * @return mixed
     */
    public function __call($method, array $parameters)
    {
        return $this->client()->{$method}(...$parameters);
    }
}
