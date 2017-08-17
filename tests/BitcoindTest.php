<?php

use Denpa\Bitcoin\Client as BitcoinClient;
use Denpa\Bitcoin\Traits\Bitcoind;
use GuzzleHttp\Psr7\Response;
use Orchestra\Testbench\TestCase;

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
        $this->assertInstanceOf(BitcoinClient::class, \Bitcoind::getFacadeRoot());
    }

    /**
     * Test helper.
     *
     * @return void
     */
    public function testHelper()
    {
        $this->assertInstanceOf(BitcoinClient::class, bitcoind());
    }

    /**
     * Test trait.
     *
     * @return void
     */
    public function testTrait()
    {
        $this->assertInstanceOf(BitcoinClient::class, $this->bitcoind());
    }

    /**
     * Test bitcoin config.
     *
     * @return void
     */
    public function testConfig()
    {
        $config = bitcoind()->getConfig();

        $this->assertEquals(
            config('bitcoind.scheme'),
            $config['base_uri']->getScheme()
        );

        $this->assertEquals(
            config('bitcoind.host'),
            $config['base_uri']->getHost()
        );

        $this->assertEquals(
            config('bitcoind.port'),
            $config['base_uri']->getPort()
        );

        $this->assertEquals(config('bitcoind.user'), $config['auth'][0]);
        $this->assertEquals(config('bitcoind.password'), $config['auth'][1]);
    }
}
