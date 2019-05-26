<?php

namespace Aa\AkeneoDataLoader\Iterator;

use Traversable;

class ChannelingBatchGenerator
{
    /**
     * @var int
     */
    private $size;

    /**
     * @var string
     */
    private $channel;

    public function __construct(int $size, string $channel)
    {
        $this->size = $size;
        $this->channel = $channel;
    }

    public function getBatches(iterable $iterator): Traversable
    {
        $batches = [];

        foreach ($iterator as $item) {

            $code = $item[$this->channel];

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
