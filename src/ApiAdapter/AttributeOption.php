<?php

namespace Aa\AkeneoDataLoader\ApiAdapter;

use Akeneo\Pim\ApiClient\Api\AttributeOptionApiInterface;


class AttributeOption implements ApiAdapterInterface, BatchUploadable
{
    /**
     * @var AttributeOptionApiInterface
     */
    private $api;

    public function __construct(AttributeOptionApiInterface $api)
    {
        $this->api = $api;
    }

    public function upload(array $data): iterable
    {
        $attribute = $data[0]['attribute'];

        return $this->api->upsertList($attribute, $data);
    }

    public function getBatchGroup(): string
    {
        return 'attribute';
    }
}
