<?php

namespace Aa\AkeneoDataLoader\Upsert;

use Akeneo\Pim\ApiClient\Api\Operation\UpsertableResourceListInterface;
use Traversable;

class StandardUpserter implements Upsertable
{
    /**
     * @var UpsertableResourceListInterface
     */
    private $api;

    public function __construct(UpsertableResourceListInterface $api)
    {
        $this->api = $api;
    }

    public function upsert(array $data): iterable
    {
        // @todo: split data to 100

        return iterator_to_array($this->api->upsertList($data));
    }
}
