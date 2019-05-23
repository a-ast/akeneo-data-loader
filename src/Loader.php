<?php

namespace Aa\AkeneoDataLoader;

use Akeneo\Pim\ApiClient\Exception\UnprocessableEntityHttpException;

class Loader
{
    /**
     * @var ApiSelector
     */
    private $apiSelector;

    public function __construct(ApiSelector $apiSelector)
    {
        $this->apiSelector = $apiSelector;
    }

    public function load(iterable $dataProvider)
    {
        foreach ($dataProvider as $apiAlias => $entities) {
            $api = $this->apiSelector->select($apiAlias);

            foreach ($entities as $data) {

                $code = $data['identifier'] ?? $data['code'];

                $api->upsert($code, $data);
            }
        }
    }
}
