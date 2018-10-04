<?php

use Denpa\Bitcoin\ClientFactory;
use GuzzleHttp\Client as GuzzleHttp;
use Denpa\Bitcoin\ClientWrapper as BitcoinClient;
use Denpa\Bitcoin\Facades\Bitcoind as BitcoindFacade;

class BitcoindTest extends TestCase
{
    /**
     * Checks if client config was correctly set.
     *
     * @param  \Denpa\Bitcoin\Client  $client
     * @param  array  $config
     *
     * @return void
     */
    protected function assertClientConfig(BitcoinClient $client, array $config)
    {
        $clientConfig = $client->getConfig();

        $this->assertEquals(
            $config['scheme'],
            $clientConfig['base_uri']->getScheme()
        );

        $this->assertEquals(
            $config['host'],
            $clientConfig['base_uri']->getHost()
        );

        $this->assertEquals(
            $config['port'],
            $clientConfig['base_uri']->getPort()
        );

        $this->assertNotNull($clientConfig['auth'][0]);
        $this->assertNotNull($clientConfig['auth'][1]);
        $this->assertEquals($config['user'], $clientConfig['auth'][0]);
        $this->assertEquals($config['password'], $clientConfig['auth'][1]);
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
        $this->assertClientConfig(
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
        ]);

        $this->assertClientConfig(bitcoind()->client(), config('bitcoind'));
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
        ];

        $this->assertClientConfig(bitcoind()->make($config), $config);
    }
}
