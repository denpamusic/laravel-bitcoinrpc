<?php

namespace Denpa\Bitcoin\ZeroMQ;

class Connection
{
    /**
     * Is connection open.
     *
     * @var bool
     */
    public $open = false;

    /**
     * ZeroMQ connection instance.
     *
     * @var \Denpa\ZeroMQ\Connection
     */
    protected $zeromq;

    /**
     * Constructs new ZeroMQ connection.
     *
     * @param  array|null  $config
     *
     * @return void
     */
    public function __construct($config)
    {
        if (! is_null($config)) {
            $this->zeromq = zeromq()->make($this->withDefaults($config));
            $this->open = true;
        }
    }

    /**
     * Adds new listener.
     *
     * @param  \Denpa\Bitcoin\ZeroMQ\Listener  $listener
     *
     * @return void
     */
    public function add(Listener $listener)
    {
        if ($this->open) {
            $listener->listenOn($this->zeromq);
        }
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
            'protocol' => 'tcp',
            'host'     => 'localhost',
            'port'     => 28332,
        ], $config);
    }
}
