<?php

namespace Denpa\Bitcoin\ZeroMQ;

use Denpa\ZeroMQ\Connection as ZMQConnection;

class Listener
{
    /**
     * ZeroMQ topic.
     *
     * @var string
     */
    protected $topic;

    /**
     * ZeroMQ callback.
     *
     * @var callable
     */
    protected $callback;

    /**
     * Sequence number.
     *
     * @var int
     */
    protected $sequence;

    /**
     * Construct ZeroMQ topic.
     *
     * @param  string    $topic
     * @param  callable  $callback
     *
     * @return void
     */
    public function __construct($topic, callable $callback)
    {
        $this->topic = $topic;
        $this->callback = $callback;
    }

    /**
     * Attach listener to connection.
     *
     * @param  \Denpa\ZeroMQ\Connection  $connection
     *
     * @return static
     */
    public function listenOn(ZMQConnection $connection)
    {
        $connection->subscribe([ $this->topic ], function ($message) {
            return $this->onSuccess($message);
        });

        return $this;
    }

    /**
     * Success callback.
     *
     * @param  string  $message
     *
     * @return mixed
     */
    protected function onSuccess($message)
    {
        list($topic, $payload, $sequence) = $message;

        $this->sequence = strlen($sequence) == 4 ?
            unpack('I', $sequence)[1] : -1;

        return ($this->callback)(bin2hex($payload));
    }
}
