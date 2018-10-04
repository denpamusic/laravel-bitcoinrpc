<?php

namespace Denpa\Bitcoin\Responses;

use Illuminate\Support\Collection;

class LaravelResponse extends BitcoindResponse
{
    /**
     * Get result as Laravel Collection.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return new Collection($this->result());
    }
}
