<?php

namespace Denpa\Bitcoin\Facades;

use Illuminate\Support\Facades\Facade;

class BitcoindFactory extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'bitcoindFactory';
    }
}
