<?php

use Denpa\Bitcoin\ClientFactory;
use Orchestra\Testbench\TestCase;
use Denpa\Bitcoin\Traits\Bitcoind;
use Denpa\Bitcoin\Client as BitcoinClient;

class BitcoindTest extends TestCase
{
    use Bitcoind;

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Denpa\Bitcoin\Providers\ServiceProvider::class,
        ];
    }

    /**
     * Get package aliases.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'Bitcoind'        => 'Denpa\Bitcoin\Facades\Bitcoind',
            'BitcoindFactory' => 'Denpa\Bitcoin\Facades\BitcoindFactory',
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('bitcoind.default', [
            'scheme'   => 'http',
            'host'     => 'localhost',
            'port'     => 8332,
            'user'     => 'testuser',
            'password' => 'testpass',
            'ca'       => null,
        ]);

        $app['config']->set('bitcoind.litecoin', [
            'scheme'   => 'http',
            'host'     => 'localhost',
            'port'     => 9332,
            'user'     => 'testuser2',
            'password' => 'testpass2',
            'ca'       => null,
        ]);
    }

    /**
     * Test service provider.
     *
     * @return void
     */
    public function testServiceIsAvailable()
    {
        $this->assertTrue($this->app->bound('bitcoind'));
        $this->assertTrue($this->app->bound('bitcoindFactory'));
    }

    /**
     * Test facade.
     *
     * @return void
     */
    public function testFacade()
    {
        $this->assertInstanceOf(BitcoinClient::class, \Bitcoind::getFacadeRoot());
        $this->assertInstanceOf(ClientFactory::class, \BitcoindFactory::getFacadeRoot());
        $this->assertInstanceOf(BitcoinClient::class, \BitcoindFactory::getFacadeRoot()->get());
        $this->assertInstanceOf(BitcoinClient::class, \BitcoindFactory::getFacadeRoot()->get('default'));
    }

    /**
     * Test helper.
     *
     * @return void
     */
    public function testHelper()
    {
        $this->assertInstanceOf(BitcoinClient::class, bitcoind());
        $this->assertInstanceOf(BitcoinClient::class, bitcoind('default'));
        $this->assertInstanceOf(ClientFactory::class, bitcoindFactory());
        $this->assertInstanceOf(BitcoinClient::class, bitcoindFactory()->get());
        $this->assertInstanceOf(BitcoinClient::class, bitcoindFactory()->get('default'));
    }

    /**
     * Test trait.
     *
     * @return void
     */
    public function testTrait()
    {
        $this->assertInstanceOf(BitcoinClient::class, $this->bitcoind());
        $this->assertInstanceOf(BitcoinClient::class, $this->bitcoind('default'));
        $this->assertInstanceOf(ClientFactory::class, $this->bitcoindFactory());
        $this->assertInstanceOf(BitcoinClient::class, $this->bitcoindFactory()->get());
        $this->assertInstanceOf(BitcoinClient::class, $this->bitcoindFactory()->get('default'));
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
        $config = bitcoind($name)->getConfig();

        $this->assertEquals(
            config("bitcoind.$name.scheme"),
            $config['base_uri']->getScheme()
        );

        $this->assertEquals(
            config("bitcoind.$name.host"),
            $config['base_uri']->getHost()
        );

        $this->assertEquals(
            config("bitcoind.$name.port"),
            $config['base_uri']->getPort()
        );

        $this->assertEquals(config("bitcoind.$name.user"), $config['auth'][0]);
        $this->assertEquals(config("bitcoind.$name.password"), $config['auth'][1]);
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

        $config = bitcoind('nonexistent')->getConfig();
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

        $config = bitcoind()->getConfig();

        $this->assertEquals(config("bitcoind.user"), $config['auth'][0]);
        $this->assertEquals(config("bitcoind.password"), $config['auth'][1]);
    }
}
