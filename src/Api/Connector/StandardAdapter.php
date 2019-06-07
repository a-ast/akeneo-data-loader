<?php

namespace Aa\AkeneoDataLoader\Api\Connector;

use Aa\AkeneoDataLoader\Connector\BatchUploadable;
use Aa\AkeneoDataLoader\Connector\ConnectorInterface;
use Aa\AkeneoDataLoader\Api\Response\ResponseValidator;
use Akeneo\Pim\ApiClient\Api\Operation\UpsertableResourceListInterface;

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

    public function upload(array $data)
    {
        $responses = $this->api->upsertList($data);

        ResponseValidator::validate($responses);
    }

    public function getBatchGroup(): string
    {
        return '';
    }
}
