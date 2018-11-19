<?php

declare(strict_types=1);

namespace Denpa\Bitcoin;

use BadMethodCallException;
use Illuminate\Support\Arr;

class LaravelClient extends Client
{
    /**
     * ZeroMQ connection.
     *
     * @var \Denpa\Bitcoin\ZeroMQ\Connection|null
     */
    protected $zeromq = null;

    /**
     * Constructs new client wrapper.
     *
     * @param  array  $config
     *
     * @return void
     */
    public function __construct(array $config)
    {
        if (class_exists('Denpa\\ZeroMQ\\Manager')) {
            $this->zeromq = new ZeroMQ\Connection(
                Arr::pull($config, 'zeromq'),
                app()->make('Denpa\ZeroMQ\Manager')
            );
        }

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
    public function on(string $topic, callable $callback) : void
    {
        if (is_null($this->zeromq)) {
            throw new BadMethodCallException(
                'ZeroMQ support is not available, because '.
                '"denpa/laravel-zeromq" package is not installed. '.
                'Please install it.'
            );
        }

        $this->zeromq->add(new ZeroMQ\Listener($topic, $callback));
    }

    /**
     * Gets response handler class name.
     *
     * @return string
     */
    protected function getResponseHandler() : string
    {
        return 'Denpa\\Bitcoin\\Responses\\LaravelResponse';
    }
}
