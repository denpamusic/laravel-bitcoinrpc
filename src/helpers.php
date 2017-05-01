<?php

use Denpa\Bitcoin\Client as BitcoinClient;

/**
 * Get bitcoind client instance.
 *
 * @return BitcoinClient
 */
function bitcoind() {
    return app(BitcoinClient::class);
}
