<?php

namespace Denpa\Bitcoin\Traits;

use Denpa\Bitcoin\Client as BitcoinClient;

trait UsesBitcoind
{
    public function bitcoind()
    {
        return app(BitcoinClient::class);
    }
}
