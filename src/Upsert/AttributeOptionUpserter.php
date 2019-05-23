<?php

namespace Aa\AkeneoDataLoader\Upsert;

use Akeneo\Pim\ApiClient\Api\AttributeOptionApiInterface;

class AttributeOptionUpserter implements Upsertable
{
    /**
     * @var AttributeOptionApiInterface
     */
    private $api;

    public function __construct(AttributeOptionApiInterface $api)
    {
        $this->api = $api;
    }

    public function upsert(array $data)
    {
        $this->api->upsert($data['attribute'], $data['code'], $data);
    }
}
