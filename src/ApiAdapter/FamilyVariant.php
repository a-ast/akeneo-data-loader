<?php

namespace Aa\AkeneoDataLoader\ApiAdapter;

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

    public function upload(array $data): iterable
    {
        $family = $data[0]['family'];

        foreach ($data as &$variant) {
            unset($variant['family']);
        }

        return $this->api->upsertList($family, $data);
    }

    public function getBatchGroup(): string
    {
        return 'family';
    }
}
