<?php

namespace Aa\AkeneoDataLoader\Iterator;

use Traversable;

class BatchGenerator
{
    /**
     * @var int
     */
    private $size;

    public function __construct(int $size)
    {
        $this->size = $size;
    }

    public function getBatches(iterable $iterator): Traversable
    {
        $batch = [];

        foreach ($iterator as $item) {

            $batch[] = $item;

            if ($this->size === count($batch)) {
                yield $batch;

                $batch = [];
            }
        }

        yield $batch;
    }
}
