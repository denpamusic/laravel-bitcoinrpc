<?php

if (! function_exists('bitcoind')) {
    /**
     * Get bitcoind client instance.
     *
     * @return \Denpa\Bitcoin\Client
     */
    function bitcoind() {
        return app('bitcoind');
    }
}
