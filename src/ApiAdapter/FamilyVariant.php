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
        $responses = [];

        foreach ($data as $family => $variants) {

            $response = $this->api->upsertList($family, $variants);
            $responses = array_merge($responses, iterator_to_array($response));
        }

        return $responses;
    }
}
