<?php

use Denpa\Bitcoin\ClientWrapper;

class ZeroMQTest extends TestCase
{
    /**
     * Set up environment.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        if (! class_exists('Denpa\ZeroMQ\Manager')) {
            class_alias('FakeManager', 'Denpa\ZeroMQ\Manager');
        }

        if (! class_exists('Denpa\ZeroMQ\Connection')) {
            class_alias('FakeConnection', 'Denpa\ZeroMQ\Connection');
        }

        $this->manager = $this->getMockBuilder('Denpa\ZeroMQ\Manager')
            ->getMock();
        $this->connection = $this->getMockBuilder('Denpa\ZeroMQ\Connection')
            ->getMock();

        $this->app->extend(
            Denpa\ZeroMQ\Manager::class,
            function ($service) {
                return $this->manager;
            }
        );
    }

    /**
     * Test client wrapper.
     *
     * @return void
     */
    public function testWrapper()
    {
        $this->manager->expects($this->once())
            ->method('make')
            ->with(config('bitcoind.default.zeromq'))
            ->willReturn($this->connection);

        $this->assertInstanceOf(
            ClientWrapper::class,
            $this->bitcoind()->client()
        );
    }

    /**
     * Test subscribe.
     *
     * @return void
     */
    public function testSubscribe()
    {
        $callback = function ($message, $sequence) {
            //
        };

        $this->manager->expects($this->once())
            ->method('make')
            ->with(config('bitcoind.default.zeromq'))
            ->willReturn($this->connection);

        $this->connection
            ->expects($this->once())
            ->method('subscribe')
            ->with(['hashblock'], $callback)
            ->will($this->returnCallback(function ($event, $callback) {
                $callback(['hashblock', 'test', '1']);
            }));

        $this->bitcoind()->on('hashblock', $callback);
    }

    /**
     * Test with null config.
     *
     * @return void
     */
    public function testNullConfig()
    {
        $callback = function ($message, $sequence) {
            //
        };

        $this->connection
            ->expects($this->never())
            ->method('subscribe');

        $this->bitcoind()
            ->client('litecoin')
            ->on('hashblock', $callback);
    }
}

class FakeManager
{
    public function make($config)
    {
        //
    }
}

class FakeConnection
{
    public function subscribe($topic, callable $callback)
    {
        //
    }
}
