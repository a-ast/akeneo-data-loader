<?php

namespace Aa\AkeneoDataLoader\Batch;

use Traversable;

class GroupingBatchGenerator
{
    /**
     * @var int
     */
    private $size;

    /**
     * @var string
     */
    private $group;

    public function __construct(int $size, string $group)
    {
        $this->size = $size;
        $this->group = $group;
    }

    public function getBatches(iterable $iterator): Traversable
    {
        $batches = [];

        foreach ($iterator as $item) {

            $code = $item[$this->group];

            $batches[$code][] = $item;

            foreach ($batches as $batchCode => $batch) {

                if (count($batch) < $this->size) {
                    continue;
                }

                yield $batch;

                unset($batches[$batchCode]);
            }
        }

        foreach ($batches as $batch) {
            yield $batch;
        }
    }
}
