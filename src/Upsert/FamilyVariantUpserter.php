<?php

namespace Aa\AkeneoDataLoader\Upsert;

use Akeneo\Pim\ApiClient\Api\FamilyVariantApiInterface;

class FamilyVariantUpserter implements Upsertable
{
    /**
     * @var FamilyVariantApiInterface
     */
    private $api;

    public function __construct(FamilyVariantApiInterface $api)
    {
        $this->api = $api;
    }

    public function upsert(array $data): iterable
    {
        $responses = [];

        foreach ($data as $family => $variants) {

            $response = $this->api->upsertList($family, $variants);
            $responses = array_merge($responses, iterator_to_array($response));
        }

        return $responses;
    }
}
