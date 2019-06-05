<?php

namespace spec\Aa\AkeneoDataLoader\Batch;

use PhpSpec\ObjectBehavior;

class ChannelingBatchGeneratorSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(2, 'id');
    }

    function it_batches()
    {
        $input = [
            ['id' => 'a', 'value' => 1],
            ['id' => 'b', 'value' => 2],
            ['id' => 'b', 'value' => 3],
            ['id' => 'c', 'value' => 4],
            ['id' => 'a', 'value' => 5],
            ['id' => 'b', 'value' => 6],
            ['id' => 'a', 'value' => 7],
            ['id' => 'a', 'value' => 8],
        ];

        $this->getBatches($input)->shouldYield([

            [
                ['id' => 'b', 'value' => 2],
                ['id' => 'b', 'value' => 3],
            ],

            [
                ['id' => 'a', 'value' => 1],
                ['id' => 'a', 'value' => 5],
            ],

            [
                ['id' => 'a', 'value' => 7],
                ['id' => 'a', 'value' => 8],
            ],

            [
                ['id' => 'c', 'value' => 4],
            ],

            [
                ['id' => 'b', 'value' => 6],
            ],
        ]);
    }
}
