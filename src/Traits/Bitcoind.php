<?php

namespace Denpa\Bitcoin\Traits;

trait Bitcoind
{
    /**
     * Get bitcoind client instance.
     *
     * @param  string $name
     *
     * @return \Denpa\Bitcoin\Client
     */
    public function bitcoind($name = 'default')
    {
        return app('bitcoind')->get($name);
    }
}
