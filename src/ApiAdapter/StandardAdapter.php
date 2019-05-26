<?php

namespace Aa\AkeneoDataLoader\ApiAdapter;

use Aa\AkeneoDataLoader\Iterator\IterableToArray;
use Aa\AkeneoDataLoader\Iterator\IterableToBatch;
use Akeneo\Pim\ApiClient\Api\Operation\UpsertableResourceListInterface;
use Traversable;

class StandardAdapter implements Uploadable
{
    /**
     * @var UpsertableResourceListInterface
     */
    private $api;

    /**
     * @var \Aa\AkeneoDataLoader\Iterator\IterableToBatch
     */
    private $batchMaker;

    public function __construct(UpsertableResourceListInterface $api)
    {
        $this->api = $api;

        $this->batchMaker = new IterableToBatch(100);
    }

    public function upload(iterable $data): iterable
    {
        foreach ($this->batchMaker->toBatches($data) as $batch) {
            $response = $this->api->upsertList($batch);

            yield from $response;
        }


    }
}
