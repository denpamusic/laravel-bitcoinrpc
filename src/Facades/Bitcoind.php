<?php

namespace Denpa\Bitcoin\Facades;

use Illuminate\Support\Facades\Facade;
use Denpa\Bitcoin\Client as BitcoinClient;

class Bitcoind extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return BitcoinClient::class;
    }
}
