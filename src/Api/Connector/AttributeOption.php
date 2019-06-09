<?php

namespace Aa\AkeneoDataLoader\Api\Connector;

use Aa\AkeneoDataLoader\Api\LoadingResult\Factory;
use Aa\AkeneoDataLoader\Connector\BatchUploadable;
use Aa\AkeneoDataLoader\Connector\ConnectorInterface;
use Akeneo\Pim\ApiClient\Api\AttributeOptionApiInterface;
use Traversable;

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

    public function upload(array $data): Traversable
    {
        $attribute = $data[0]['attribute'];

        $responses = $this->api->upsertList($attribute, $data);

        return Factory::createFromResponses($responses);
    }

    public function getBatchGroup(): string
    {
        return 'attribute';
    }
}
