<?php

if (! function_exists('bitcoind')) {
    /**
     * Get bitcoind client instance by name.
     *
     * @return \Denpa\Bitcoin\ClientFactory
     */
    function bitcoind()
    {
        return app('bitcoind');
    }
}
