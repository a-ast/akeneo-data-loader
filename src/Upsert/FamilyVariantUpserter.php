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

    public function upsert(array $data)
    {
        $this->api->upsert($data['family_code'], $data['code'], $data);
    }
}
