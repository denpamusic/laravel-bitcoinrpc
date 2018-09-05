<?php

use Orchestra\Testbench\TestCase;
use Denpa\Bitcoin\ClientFactory;
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
            'Bitcoind' => 'Denpa\Bitcoin\Facades\Bitcoind',
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('bitcoind.user', 'testuser');
        $app['config']->set('bitcoind.password', 'testpass');
    }

    /**
     * Test service provider.
     *
     * @return void
     */
    public function testServiceIsAvailable()
    {
        $this->assertTrue($this->app->bound('bitcoind'));
    }

    /**
     * Test facade.
     *
     * @return void
     */
    public function testFacade()
    {
        $this->assertInstanceOf(ClientFactory::class, \Bitcoind::getFacadeRoot());
        $this->assertInstanceOf(BitcoinClient::class, \Bitcoind::getFacadeRoot()->get());
        $this->assertInstanceOf(BitcoinClient::class, \Bitcoind::getFacadeRoot()->get('default'));
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
}
