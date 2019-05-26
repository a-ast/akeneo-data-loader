<?php

namespace Aa\AkeneoDataLoader\ApiAdapter;

use Aa\AkeneoDataLoader\Iterator\IterableToArray;
use Akeneo\Pim\ApiClient\Api\Operation\UpsertableResourceListInterface;
use Traversable;

class StandardAdapter implements Uploadable
{
    /**
     * @var UpsertableResourceListInterface
     */
    private $api;

    public function __construct(UpsertableResourceListInterface $api)
    {
        $this->api = $api;
    }

    public function upload(iterable $data): iterable
    {
        // @todo: split data to 100
        $data = IterableToArray::convert($data);

        $response = $this->api->upsertList($data);

        yield from $response;
    }
}
