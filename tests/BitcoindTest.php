<?php

use Denpa\Bitcoin\ClientFactory;
use Denpa\Bitcoin\Facades\Bitcoind as BitcoindFacade;
use Denpa\Bitcoin\LaravelClient as BitcoinClient;
use GuzzleHttp\Client as GuzzleHttp;

class BitcoindTest extends TestCase
{
    /**
     * Assert that configs are equal.
     *
     * @param  \Denpa\Bitcoin\Client  $client
     * @param  array  $config
     *
     * @return void
     */
    protected function assertConfigEquals(BitcoinClient $client, array $config)
    {
        $this->assertEquals($config['scheme'], $client->getConfig()['scheme']);
        $this->assertEquals($config['host'], $client->getConfig()['host']);
        $this->assertEquals($config['port'], $client->getConfig()['port']);
        $this->assertNotNull($client->getConfig()['user']);
        $this->assertNotNull($client->getConfig()['password']);
        $this->assertEquals($config['user'], $client->getConfig()['user']);
        $this->assertEquals($config['password'], $client->getConfig()['password']);
        $this->assertEquals($config['timeout'], $client->getConfig()['timeout']);
    }

    /**
     * Test service provider.
     *
     * @return void
     */
    public function testServiceIsAvailable()
    {
        $this->assertInstanceOf(
            ClientFactory::class, $this->app['bitcoind']
        );

        $this->assertInstanceOf(
            BitcoinClient::class, $this->app['bitcoind.client']
        );

        $this->assertTrue($this->app->bound('bitcoind'));
        $this->assertTrue($this->app->bound('bitcoind.client'));
    }

    /**
     * Test facade.
     *
     * @return void
     */
    public function testFacade()
    {
        $this->assertInstanceOf(
            ClientFactory::class,
            BitcoindFacade::getFacadeRoot()
        );

        $this->assertInstanceOf(
            BitcoinClient::class,
            BitcoindFacade::getFacadeRoot()->client()
        );

        $this->assertInstanceOf(
            BitcoinClient::class,
            BitcoindFacade::getFacadeRoot()->client('default')
        );
    }

    /**
     * Test helper.
     *
     * @return void
     */
    public function testHelper()
    {
        $this->assertInstanceOf(
            ClientFactory::class, bitcoind()
        );

        $this->assertInstanceOf(
            BitcoinClient::class, bitcoind()->client()
        );

        $this->assertInstanceOf(
            BitcoinClient::class, bitcoind()->client('default')
        );
    }

    /**
     * Test trait.
     *
     * @return void
     */
    public function testTrait()
    {
        $this->assertInstanceOf(
            ClientFactory::class, $this->bitcoind()
        );

        $this->assertInstanceOf(
            BitcoinClient::class, $this->bitcoind()->client()
        );

        $this->assertInstanceOf(
            BitcoinClient::class, $this->bitcoind()->client('default')
        );
    }

    /**
     * Test bitcoin config.
     *
     * @return void
     *
     * @dataProvider nameProvider
     */
    public function testConfig($name)
    {
        $this->assertConfigEquals(
            bitcoind()->client($name),
            config("bitcoind.$name")
        );
    }

    /**
     * Name provider for config test.
     *
     * @return array
     */
    public function nameProvider()
    {
        return [
            ['default'],
            ['litecoin'],
        ];
    }

    /**
     * Test with non existent config.
     *
     * @return void
     */
    public function testNonExistentConfig()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Could not find client configuration [nonexistent]');

        $config = bitcoind()->client('nonexistent')->getConfig();
    }

    /**
     * Test with legacy config format.
     *
     * @return void
     */
    public function testLegacyConfig()
    {
        config()->set('bitcoind', [
            'scheme'   => 'http',
            'host'     => 'localhost',
            'port'     => 8332,
            'user'     => 'testuser3',
            'password' => 'testpass3',
            'ca'       => null,
            'timeout'  => false,
        ]);

        $this->assertConfigEquals(bitcoind()->client(), config('bitcoind'));
        $this->assertLogContains('You are using legacy config format');
    }

    /**
     * Test magic call to client through factory.
     *
     * @return void
     */
    public function testMagicCall()
    {
        $this->assertInstanceOf(GuzzleHttp::class, bitcoind()->getClient());
    }

    /**
     * Test making new client instance.
     *
     * @return void
     */
    public function testFactoryMake()
    {
        $config = [
            'scheme'   => 'http',
            'host'     => '127.0.0.3',
            'port'     => 18332,
            'user'     => 'testuser3',
            'password' => 'testpass3',
            'timeout'  => false,
        ];

        $this->assertConfigEquals(bitcoind()->make($config), $config);
    }
}
