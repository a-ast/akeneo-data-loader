<?php

namespace Aa\AkeneoDataLoader\ApiAdapter;

use Akeneo\Pim\ApiClient\Api\Operation\UpsertableResourceListInterface;

class StandardAdapter implements ApiAdapterInterface, BatchUploadable
{
    /**
     * @var UpsertableResourceListInterface
     */
    private $api;

    public function __construct(UpsertableResourceListInterface $api)
    {
        $this->api = $api;
    }

    public function upload(array $data): iterable
    {
        $response = $this->api->upsertList($data);

        return $response;
    }

    public function getBatchGroup(): string
    {
        return '';
    }
}
