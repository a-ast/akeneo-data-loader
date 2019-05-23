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
        $code = $data['code'];
        $familyCode = $data['family'];

        unset($data['family'], $data['code']);

        $this->api->upsert($familyCode, $code, $data);
    }
}
