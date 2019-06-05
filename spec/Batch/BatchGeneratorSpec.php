<?php

namespace spec\Aa\AkeneoDataLoader\Batch;

use PhpSpec\ObjectBehavior;

class BatchGeneratorSpec extends ObjectBehavior
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

        $this->getBatches($input)->shouldYield([[1, 2], [3, 4], [5]]);
    }
}
