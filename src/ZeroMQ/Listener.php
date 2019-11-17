<?php

declare(strict_types=1);

namespace Denpa\Bitcoin\ZeroMQ;

use Denpa\ZeroMQ\Connection as ZMQConnection;
use UnexpectedValueException;

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
    protected $sequence = 0;

    /**
     * Construct ZeroMQ topic.
     *
     * @param  string    $topic
     * @param  callable  $callback
     *
     * @return void
     */
    public function __construct(string $topic, callable $callback)
    {
        $this->topic = $topic;
        $this->callback = $callback;
    }

    /**
     * Attach listener to connection.
     *
     * @param  \Denpa\ZeroMQ\Connection  $connection
     *
     * @return self
     */
    public function listenOn(ZMQConnection $connection) : self
    {
        $connection->subscribe([$this->topic], function ($message) {
            return $this->onSuccess($message);
        });

        return $this;
    }

    /**
     * Success callback.
     *
     * @param  array  $message
     *
     * @return mixed
     */
    protected function onSuccess(array $message)
    {
        [$topic, $payload, $sequence] = $message;

        $sequence = strlen(bin2hex($sequence)) == PHP_INT_SIZE ?
            unpack('I', $sequence)[1] : 0;

        if ($this->sequence > 0 && (($this->sequence + 1) != $sequence)) {
            throw new UnexpectedValueException(
                "Broken sequence on sequence number $sequence. ".
                'Detected lost notifications.'
            );
        }

        return ($this->callback)(
            bin2hex($payload),
            $this->sequence = $sequence
        );
    }
}
