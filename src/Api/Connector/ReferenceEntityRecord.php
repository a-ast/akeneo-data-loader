<?php

namespace Aa\AkeneoDataLoader\Api\Connector;

use Aa\AkeneoDataLoader\Api\LoadingResult\Factory;
use Aa\AkeneoDataLoader\Connector\ConnectorInterface;
use Aa\AkeneoDataLoader\Connector\BatchUploadable;
use Akeneo\PimEnterprise\ApiClient\Api\ReferenceEntityRecordApiInterface;
use Traversable;

class ReferenceEntityRecord implements ConnectorInterface, BatchUploadable
{
    /**
     * @var ReferenceEntityRecordApiInterface
     */
    private $api;

    public function __construct(ReferenceEntityRecordApiInterface $api)
    {
        $this->api = $api;
    }

    public function upload(array $data): Traversable
    {
        $referenceEntity = $data[0]['reference_entity'];

        foreach ($data as &$record) {
            unset($record['reference_entity']);
        }

        $responses = $this->api->upsertList($referenceEntity, $data);

        return Factory::createFromResponses($responses);
    }

    public function getBatchGroup(): string
    {
        return 'reference_entity';
    }
}
