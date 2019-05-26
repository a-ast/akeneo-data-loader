<?php

namespace Aa\AkeneoDataLoader\ApiAdapter;

use Aa\AkeneoDataLoader\Batch\BatchGenerator;
use Akeneo\Pim\ApiClient\Api\Operation\UpsertableResourceListInterface;

class StandardAdapter implements Uploadable
{
    /**
     * @var UpsertableResourceListInterface
     */
    private $api;

    /**
     * @var \Aa\AkeneoDataLoader\Batch\BatchGenerator
     */
    private $batchGenerator;

    public function __construct(UpsertableResourceListInterface $api)
    {
        $this->api = $api;

        $this->batchGenerator = new BatchGenerator(100);
    }

    public function upload(iterable $data): iterable
    {
        foreach ($this->batchGenerator->getBatches($data) as $batch) {
            $response = $this->api->upsertList($batch);

            yield from $response;
        }
    }
}
