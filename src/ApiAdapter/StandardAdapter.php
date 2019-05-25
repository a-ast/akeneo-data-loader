<?php

namespace Aa\AkeneoDataLoader\ApiAdapter;

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

    public function upload(array $data): iterable
    {
        // @todo: split data to 100

        return iterator_to_array($this->api->upsertList($data));
    }
}
