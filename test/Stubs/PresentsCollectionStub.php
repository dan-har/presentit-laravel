<?php

namespace Presentit\Laravel\Test\Stubs;

use ArrayIterator;
use IteratorAggregate;
use Presentit\Laravel\PresentsCollection;

class PresentsCollectionStub implements IteratorAggregate
{
    use PresentsCollection;

    public function getIterator()
    {
        return new ArrayIterator([]);
    }
}
