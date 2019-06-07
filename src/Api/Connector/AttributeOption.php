<?php

namespace Aa\AkeneoDataLoader\Api\Connector;

use Aa\AkeneoDataLoader\Connector\BatchUploadable;
use Aa\AkeneoDataLoader\Connector\ConnectorInterface;
use Aa\AkeneoDataLoader\Api\Response\ResponseValidator;
use Akeneo\Pim\ApiClient\Api\AttributeOptionApiInterface;

class AttributeOption implements ConnectorInterface, BatchUploadable
{
    /**
     * @var AttributeOptionApiInterface
     */
    private $api;

    public function __construct(AttributeOptionApiInterface $api)
    {
        $this->api = $api;
    }

    public function upload(array $data)
    {
        $attribute = $data[0]['attribute'];

        $responses = $this->api->upsertList($attribute, $data);

        ResponseValidator::validate($responses);
    }

    public function getBatchGroup(): string
    {
        return 'attribute';
    }
}
