<?php

namespace spec\Aa\AkeneoDataLoader\Iterator;

use Aa\AkeneoDataLoader\Iterator\IterableToBatch;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class IterableToBatchSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(2);
    }

    function it_batches()
    {
        $input = [
            1, 2, 3, 4, 5
        ];

        $this->toBatches($input)->shouldYield([[1, 2], [3, 4], [5]]);
    }
}
