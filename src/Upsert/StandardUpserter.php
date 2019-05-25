<?php

namespace Aa\AkeneoDataLoader\Upsert;

use Akeneo\Pim\ApiClient\Api\Operation\UpsertableResourceInterface;
use Akeneo\Pim\ApiClient\Api\Operation\UpsertableResourceListInterface;

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
        if ($this->api instanceof UpsertableResourceListInterface) {

            $responses = $this->api->upsertList($data);

            foreach ($responses as $response) {

                var_dump($response['status_code']);
            }

        }


        $code = $data['identifier'] ?? $data['code'];

        unset($data['code']);

        $this->api->upsert($code, $data);
    }
}
