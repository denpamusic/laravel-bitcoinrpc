<?php

namespace Denpa\Bitcoin\Traits;

trait Bitcoind
{
    public function bitcoind()
    {
        return app('bitcoind');
    }
}
