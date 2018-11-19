<?php

declare(strict_types=1);

namespace Denpa\Bitcoin\Facades;

use Illuminate\Support\Facades\Facade;

class Bitcoind extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() : string
    {
        return 'bitcoind';
    }
}
