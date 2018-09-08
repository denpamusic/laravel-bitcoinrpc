<?php

namespace Denpa\Bitcoin\Traits;

trait Bitcoind
{
    /**
     * Get bitcoind client factory instance.
     *
     * @return \Denpa\Bitcoin\ClientFactory
     */
    public function bitcoind()
    {
        return app('bitcoind');
    }
}
