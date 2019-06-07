<?php

namespace Aa\AkeneoDataLoader\Api\Connector;

use Aa\AkeneoDataLoader\Connector\BatchUploadable;
use Aa\AkeneoDataLoader\Connector\ConnectorInterface;
use Aa\AkeneoDataLoader\Api\Response\ResponseValidator;
use Akeneo\Pim\ApiClient\Api\FamilyVariantApiInterface;

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

    public function upload(array $data)
    {
        $family = $data[0]['family'];

        foreach ($data as &$variant) {
            unset($variant['family']);
        }

        $responses = $this->api->upsertList($family, $data);

        ResponseValidator::validate($responses);
    }

    public function getBatchGroup(): string
    {
        return 'family';
    }
}
