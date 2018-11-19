<?php

declare(strict_types=1);

namespace Denpa\Bitcoin\Traits;

use Denpa\Bitcoin\ClientFactory;

trait Bitcoind
{
    /**
     * Get bitcoind client factory instance.
     *
     * @return \Denpa\Bitcoin\ClientFactory
     */
    public function bitcoind() : ClientFactory
    {
        return app('bitcoind');
    }
}
