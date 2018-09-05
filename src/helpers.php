<?php

if (! function_exists('bitcoind')) {
    /**
     * Get bitcoind client instance.
     *
	 * @param  string $name
	 *
     * @return \Denpa\Bitcoin\Client
     */
    function bitcoind($name = 'default')
    {
        return app('bitcoind')->get($name);
    }
}
