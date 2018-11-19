<?php

use Denpa\Bitcoin\LaravelClient;
use Denpa\Bitcoin\Responses\LaravelResponse;

class LaravelClientTest extends TestCase
{
    /**
     * Test that handler getter returns correct response class.
     *
     * @return void
     */
    public function testResponse()
    {
        $fake = new FakeClient([]);

        $this->assertEquals(
            LaravelResponse::class,
            $fake->getResponseHandler()
        );
    }

    /**
     * Test on() method call without laravel-zeromq package installed.
     *
     * @return void
     */
    public function testSubsribeWithoutZMQ()
    {
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage(
            'ZeroMQ support is not available, because '.
            '"denpa/laravel-zeromq" package is not installed. '.
            'Please install it.'
        );

        $this->bitcoind()->on('hashblock', function () {
        });
    }
}

class FakeClient extends LaravelClient
{
    public function getResponseHandler() : string
    {
        return parent::getResponseHandler();
    }
}
