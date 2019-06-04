<?php

namespace Aa\AkeneoDataLoader\Response;

use ArrayIterator;
use IteratorAggregate;

class ResponseBag implements IteratorAggregate
{
    /**
     * @var iterable
     */
    private $responses;

    private function __construct(iterable $responses)
    {
        $this->responses = $responses;
    }

    public static function create(iterable $responses): ResponseBag
    {
        return new static($responses);
    }

    public function getIterator()
    {
        if ($this->responses instanceof \Iterator) {
            return $this->responses;
        }

        return new ArrayIterator($this->responses);
    }
}
