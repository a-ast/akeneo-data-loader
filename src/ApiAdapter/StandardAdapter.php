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
     * @var int
     */
    private $upsertBatchSize;

    public function __construct(UpsertableResourceListInterface $api, int $upsertBatchSize = 100)
    {
        $this->api = $api;

        $this->upsertBatchSize = $upsertBatchSize;
    }

    public function upload(iterable $data): iterable
    {
        $batchGenerator = new BatchGenerator($this->upsertBatchSize);

        foreach ($batchGenerator->getBatches($data) as $batch) {
            $response = $this->api->upsertList($batch);

            yield from $response;
        }
    }
}
