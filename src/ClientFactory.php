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
     * Gets client config by name.
     *
     * @param  array  $config
     *
     * @return \Illuminate\Support\Collection
     */
    public function getConfig($name = 'default')
    {
        if ($name == 'default') {
            reset($this->config);
            $name = key($this->config);
        }

        if (! array_key_exists($name, $this->config)) {
            throw new \Exception("Could not find client configuration [$name]");
        }

        return collect($this->config[$name]);
    }

    /**
     * Gets client instance by name or creates if not exists.
     *
     * @param  string  $name
     *
     * @return \Denpa\Bitcoin\Client
     */
    public function get($name = 'default')
    {
        if (! $this->clients->has($name)) {
            $this->clients->put($name, $this->make($name));
        }

        return $this->clients->get($name);
    }

    /**
     * Creates client instance.
     *
     * @param  string  $name
     *
     * @return \Denpa\Bitcoin\Client
     */
    public function make($name = 'default')
    {
        $config = $this->getConfig($name);

        return new BitcoinClient([
            'scheme' => $config->get('scheme', 'http'),
            'host'   => $config->get('host', 'localhost'),
            'port'   => $config->get('port', 8332),
            'user'   => $config->get('user'),
            'pass'   => $config->get('password'),
            'ca'     => $config->get('ca'),
        ]);
    }
}
