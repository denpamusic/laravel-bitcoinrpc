<?php

use Denpa\Bitcoin\ClientFactory;
use Orchestra\Testbench\TestCase;
use Denpa\Bitcoin\Traits\Bitcoind;
use GuzzleHttp\Client as GuzzleHttp;
use Denpa\Bitcoin\Client as BitcoinClient;
use Denpa\Bitcoin\Facades\Bitcoind as BitcoindFacade;

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
            'Bitcoind' => 'Denpa\Bitcoin\Facades\Bitcoind',
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
        $config = bitcoind()->client($name)->getConfig();

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

        $this->assertNotNull($config['auth'][0]);
        $this->assertNotNull($config['auth'][1]);
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

        $config = bitcoind()->client()->getConfig();

        $this->assertNotNull($config['auth'][0]);
        $this->assertNotNull($config['auth'][1]);
        $this->assertEquals(config('bitcoind.user'), $config['auth'][0]);
        $this->assertEquals(config('bitcoind.password'), $config['auth'][1]);
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
}
