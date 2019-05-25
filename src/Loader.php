<?php

namespace Aa\AkeneoDataLoader;

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

    public function load(string $apiAlias, iterable $dataProvider)
    {
        $api = $this->apiSelector->select($apiAlias);

        $api->upsert($dataProvider);

//        foreach ($dataProvider as $data) {
//            $api->upsert($data);
//        }
    }
}
