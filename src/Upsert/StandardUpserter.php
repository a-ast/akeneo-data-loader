<?php

namespace Aa\AkeneoDataLoader\Upsert;

use Akeneo\Pim\ApiClient\Api\Operation\UpsertableResourceInterface;

class StandardUpserter implements Upsertable
{
    /**
     * @var UpsertableResourceInterface
     */
    private $api;

    public function __construct(UpsertableResourceInterface $api)
    {
        $this->api = $api;
    }

    public function upsert(array $data)
    {
        $code = $data['identifier'] ?? $data['code'];

        unset($data['code']);

        $this->api->upsert($code, $data);
    }
}
