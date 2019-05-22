<?php

namespace Aa\AkeneoDataLoader;

use Traversable;

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

    public function load(Traversable $dataProvider)
    {
        foreach ($dataProvider as $apiAlias => $entities) {
            $api = $this->apiSelector->select($apiAlias);

            foreach ($entities as $code => $data) {
                $api->upsert($code, $data);
            }
        }
    }
}
