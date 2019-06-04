<?php

namespace Aa\AkeneoDataLoader\ApiAdapter;

use Aa\AkeneoDataLoader\Response\ResponseBag;
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

    public function upload(array $data): ResponseBag
    {
        $attribute = $data[0]['attribute'];

        $responses = $this->api->upsertList($attribute, $data);

        return ResponseBag::create($responses);
    }

    public function getBatchGroup(): string
    {
        return 'attribute';
    }
}
