<?php

namespace Aa\AkeneoDataLoader\Api\Connector;

use Aa\AkeneoDataLoader\Api\LoadingResult\Factory;
use Aa\AkeneoDataLoader\Connector\BatchUploadable;
use Aa\AkeneoDataLoader\Connector\ConnectorInterface;
use Akeneo\Pim\ApiClient\Api\Operation\UpsertableResourceListInterface;
use Traversable;

class StandardAdapter implements ConnectorInterface, BatchUploadable
{
    /**
     * @var UpsertableResourceListInterface
     */
    private $api;

    public function __construct(UpsertableResourceListInterface $api)
    {
        $this->api = $api;
    }

    public function upload(array $data): Traversable
    {
        $responses = $this->api->upsertList($data);

        return Factory::createFromResponses($responses);
    }

    public function getBatchGroup(): string
    {
        return '';
    }
}
