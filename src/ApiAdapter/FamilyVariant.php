<?php

namespace Aa\AkeneoDataLoader\ApiAdapter;

use Aa\AkeneoDataLoader\Response\ResponseBag;
use Akeneo\Pim\ApiClient\Api\FamilyVariantApiInterface;

class FamilyVariant implements ApiAdapterInterface, BatchUploadable
{
    /**
     * @var FamilyVariantApiInterface
     */
    private $api;

    public function __construct(FamilyVariantApiInterface $api)
    {
        $this->api = $api;
    }

    public function upload(array $data): ResponseBag
    {
        $family = $data[0]['family'];

        foreach ($data as &$variant) {
            unset($variant['family']);
        }

        $responses = $this->api->upsertList($family, $data);

        return ResponseBag::create($responses);
    }

    public function getBatchGroup(): string
    {
        return 'family';
    }
}
