<?php

namespace Aa\AkeneoDataLoader\Iterator;

class IterableToBatch
{
    /**
     * @var int
     */
    private $size;

    public function __construct(int $size)
    {
        $this->size = $size;
    }

    public function toBatches(iterable $iterator)
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
