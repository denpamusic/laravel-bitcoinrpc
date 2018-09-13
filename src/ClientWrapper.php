<?php

namespace Denpa\Bitcoin;

use Illuminate\Support\Arr;

class ClientWrapper extends Client
{
    /**
     * ZeroMQ connection.
     *
     * @var \Denpa\Bitcoin\ZeroMQ\Connection
     */
    protected $zeromq;

    /**
     * Constructs new client wrapper.
     *
     * @param  array  $config
     *
     * @return void
     */
    public function __construct(array $config)
    {
        $this->zeromq = new ZeroMQ\Connection(Arr::pull($config, 'zeromq'));
        parent::__construct($config);
    }

    /**
     * Adds new listener.
     *
     * @param  string    $topic
     * @param  callable  $callback
     *
     * @return void
     */
    public function on($topic, callable $callback)
    {
        $this->zeromq->add(new ZeroMQ\Listener($topic, $callback));
    }
}
