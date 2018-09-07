<?php

namespace Denpa\Bitcoin\Traits;

trait Bitcoind
{
    /**
     * Get bitcoind client instance.
     *
     * @param  string  $name
     *
     * @return \Denpa\Bitcoin\Client
     */
    public function bitcoind($name = 'default')
    {
        return app('bitcoind.factory')->get($name);
    }

    /**
     * Get bitcoind client factory.
     *
     * @return \Denpa\Bitcoin\ClientFactory
     */
    public function bitcoindFactory()
    {
        return app('bitcoind.factory');
    }
}
