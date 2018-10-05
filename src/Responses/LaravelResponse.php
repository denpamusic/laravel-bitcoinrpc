<?php

namespace Denpa\Bitcoin\Responses;

use Illuminate\Support\Collection;

class LaravelResponse extends BitcoindResponse
{
    /**
     * Gets result as Laravel Collection.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collect($key = null)
    {
        return new Collection($this->get($key));
    }
}
