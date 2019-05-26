<?php

namespace Aa\AkeneoDataLoader\ApiAdapter;

use Aa\AkeneoDataLoader\Iterator\ChannelingBatchGenerator;
use Akeneo\Pim\ApiClient\Api\AttributeOptionApiInterface;
use Traversable;

class AttributeOption implements Uploadable
{
    /**
     * @var AttributeOptionApiInterface
     */
    private $api;

    public function __construct(AttributeOptionApiInterface $api)
    {
        $this->api = $api;
    }

    public function upload(iterable $data): iterable
    {
        $batchGenerator = new ChannelingBatchGenerator(100, 'code');

        foreach ($batchGenerator->getBatches($data) as $options) {

            $attribute = $options[0]['code'];

            $response = $this->api->upsertList($attribute, $options);

            yield from $response;
        }
    }
}
