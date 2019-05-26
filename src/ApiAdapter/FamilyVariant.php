<?php

namespace Aa\AkeneoDataLoader\ApiAdapter;

use Akeneo\Pim\ApiClient\Api\FamilyVariantApiInterface;

class FamilyVariant implements Uploadable
{
    /**
     * @var FamilyVariantApiInterface
     */
    private $api;

    public function __construct(FamilyVariantApiInterface $api)
    {
        $this->api = $api;
    }

    public function upload(iterable $data): iterable
    {
        foreach ($data as $family => $variants) {

            $response = $this->api->upsertList($family, $variants);

            yield from $response;
        }
    }
}
