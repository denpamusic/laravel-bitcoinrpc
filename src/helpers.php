<?php

declare(strict_types=1);

use Denpa\Bitcoin\ClientFactory;

if (! function_exists('bitcoind')) {
    /**
     * Get bitcoind client instance by name.
     *
     * @return \Denpa\Bitcoin\ClientFactory
     */
    function bitcoind() : ClientFactory
    {
        return app('bitcoind');
    }
}
