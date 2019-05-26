<?php

namespace spec\Aa\AkeneoDataLoader\Iterator;

use Aa\AkeneoDataLoader\Iterator\IterableToArray;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class IterableToArraySpec extends ObjectBehavior
{
    function it_converts_generator_to_array()
    {
        $this::convert($this->getGenerator())->shouldReturn([1, 2, 3]);
    }

    private function getGenerator(): \Traversable
    {
        for($i = 1; $i <= 3; $i++) {
            yield $i;
        }
    }
}
