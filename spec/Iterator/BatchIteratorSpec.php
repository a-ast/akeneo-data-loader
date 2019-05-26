<?php

namespace spec\Aa\AkeneoDataLoader\Iterator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Webmozart\Assert\Assert;

class BatchIteratorSpec extends ObjectBehavior
{
    function it_is_iterator()
    {
        $this->shouldHaveType(\Iterator::class);
    }

    function it_iterates()
    {
        $this->beConstructedWith($this->getGenerator(), 2);

        $batches = [];

        foreach ($this as $batch) {
            $batches[] = $batch;
        }

        Assert::same($batches, [[1, 2], [3, 4], [5]]);
    }

    private function getGenerator(): \Traversable
    {
        for($i = 1; $i <= 5; $i++) {
            yield $i;
        }
    }
}
