<?php

namespace Aa\AkeneoDataLoader\ApiAdapter;

use Aa\AkeneoDataLoader\Batch\ChannelingBatchGenerator;
use Akeneo\Pim\ApiClient\Api\FamilyVariantApiInterface;

class FamilyVariant implements Uploadable
{
    /**
     * @var FamilyVariantApiInterface
     */
    private $api;

    /**
     * @var int
     */
    private $upsertBatchSize;

    public function __construct(FamilyVariantApiInterface $api, int $upsertBatchSize = 100)
    {
        $this->api = $api;
        $this->upsertBatchSize = $upsertBatchSize;
    }

    public function upload(iterable $data): iterable
    {
        $batchGenerator = new ChannelingBatchGenerator($this->upsertBatchSize, 'family');

        foreach ($batchGenerator->getBatches($data) as $variants) {

            $family = $variants[0]['family'];

            foreach ($variants as &$variant) {
                unset($variant['family']);
            }

            $response = $this->api->upsertList($family, $variants);

            yield from $response;
        }
    }
}
