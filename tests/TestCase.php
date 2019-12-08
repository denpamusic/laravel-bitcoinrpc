<?php

use Denpa\Bitcoin\Providers\ServiceProvider;
use Denpa\Bitcoin\Traits\Bitcoind;
use Monolog\Handler\TestHandler;
use Monolog\Logger;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
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
            ServiceProvider::class,
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
        if (method_exists($app['log'], 'getMonolog')) {
            $app['log']->getMonolog()->setHandlers([new TestHandler()]);
        }

        $app['config']->set('logging.channels', [
            'testing' => [
                'driver' => 'custom',
                'via' => function () {
                    $monolog = new Logger('testing');
                    $monolog->pushHandler(new TestHandler());

                    return $monolog;
                },
            ],
        ]);

        $app['config']->set('bitcoind.default', [
            'scheme'   => 'http',
            'host'     => 'localhost',
            'port'     => 8332,
            'user'     => 'testuser',
            'password' => 'testpass',
            'ca'       => null,
            'timeout'  => false,
            'zeromq'   => [
                'protocol' => 'tcp',
                'host'     => 'localhost',
                'port'     => 28332,
            ],
        ]);

        $app['config']->set('bitcoind.litecoin', [
            'scheme'   => 'http',
            'host'     => 'localhost',
            'port'     => 9332,
            'user'     => 'testuser2',
            'password' => 'testpass2',
            'ca'       => null,
            'zeromq'   => null,
            'timeout'  => 5,
        ]);
    }

    /**
     * Assert that log contains message.
     *
     * @param  string  $message
     * @param  bool    $strict
     *
     * @return void
     */
    protected function assertLogContains($message = '', $strict = false)
    {
        $found = false;

        $monolog = method_exists($this->app['log'], 'getMonolog') ?
            $this->app['log']->getMonolog() : $this->app['log'];

        $records = $monolog
            ->getHandlers()[0]
            ->getRecords();

        foreach ($records as $record) {
            if (strpos($record['message'], $message) !== false) {
                if ($strict && $record['message'] != $message) {
                    continue;
                }

                $found = true;
            }
        }

        $this->assertTrue($found, "Log message [$message] not found");
    }
}
