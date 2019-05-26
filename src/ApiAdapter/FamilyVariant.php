<?php

namespace Aa\AkeneoDataLoader\ApiAdapter;

use Aa\AkeneoDataLoader\Iterator\ChannelingBatchGenerator;
use Akeneo\Pim\ApiClient\Api\FamilyVariantApiInterface;

class FamilyVariant implements Uploadable
{
    /**
     * @var FamilyVariantApiInterface
     */
    private $api;

    public function __construct(FamilyVariantApiInterface $api)
    {
        $this->api = $api;
    }

    public function upload(iterable $data): iterable
    {
        $batchGenerator = new ChannelingBatchGenerator(100, 'family');

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
