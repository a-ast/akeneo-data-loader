<?php

namespace Aa\AkeneoDataLoader\Response;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

class ResponseBag implements IteratorAggregate
{
    /**
     * @var Traversable
     */
    private $responses;

    private function __construct(Traversable $responses)
    {
        $this->responses = $responses;
    }

    public static function create(Traversable $responses): ResponseBag
    {
        return new static($responses);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->responses);
    }
}
