<?php

namespace Aa\AkeneoDataLoader\Upsert;

use Akeneo\Pim\ApiClient\Api\AttributeOptionApiInterface;
use Traversable;

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

    public function upsert(array $data): iterable
    {
        $responses = [];

        foreach ($data as $attribute => $options) {

            $response = $this->api->upsertList($attribute, $options);
            $responses = array_merge($responses, iterator_to_array($response));
        }

        return $responses;
    }
}
