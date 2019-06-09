<?php

namespace Aa\AkeneoDataLoader\Api\Connector;

use Aa\AkeneoDataLoader\Api\LoadingResult\Factory;
use Aa\AkeneoDataLoader\Connector\BatchUploadable;
use Aa\AkeneoDataLoader\Connector\ConnectorInterface;
use Akeneo\Pim\ApiClient\Api\FamilyVariantApiInterface;
use Traversable;

class FamilyVariant implements ConnectorInterface, BatchUploadable
{
    /**
     * @var FamilyVariantApiInterface
     */
    private $api;

    public function __construct(FamilyVariantApiInterface $api)
    {
        $this->api = $api;
    }

    public function upload(array $data): Traversable
    {
        $family = $data[0]['family'];

        foreach ($data as &$variant) {
            unset($variant['family']);
        }

        $responses = $this->api->upsertList($family, $data);

        return Factory::createFromResponses($responses);
    }

    public function getBatchGroup(): string
    {
        return 'family';
    }
}
