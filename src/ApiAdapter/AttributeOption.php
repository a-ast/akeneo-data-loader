<?php

namespace Aa\AkeneoDataLoader\ApiAdapter;

use Aa\AkeneoDataLoader\Batch\ChannelingBatchGenerator;
use Akeneo\Pim\ApiClient\Api\AttributeOptionApiInterface;
use Traversable;

class AttributeOption implements Uploadable
{
    /**
     * @var AttributeOptionApiInterface
     */
    private $api;

    /**
     * @var int
     */
    private $upsertBatchSize;

    public function __construct(AttributeOptionApiInterface $api, int $upsertBatchSize = 100)
    {
        $this->api = $api;
        $this->upsertBatchSize = $upsertBatchSize;
    }

    public function upload(iterable $data): iterable
    {
        $batchGenerator = new ChannelingBatchGenerator($this->upsertBatchSize, 'attribute');

        foreach ($batchGenerator->getBatches($data) as $options) {

            $attribute = $options[0]['attribute'];

            $response = $this->api->upsertList($attribute, $options);

            yield from $response;
        }
    }
}
