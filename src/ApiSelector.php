<?php

namespace Aa\AkeneoDataLoader;

use Akeneo\Pim\ApiClient\AkeneoPimClientInterface;
use Akeneo\Pim\ApiClient\Api\Operation\UpsertableResourceInterface;

class ApiSelector
{
    /**
     * @var AkeneoPimClientInterface
     */
    private $apiClient;

    public function __construct(AkeneoPimClientInterface $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function select(string $apiAlias): UpsertableResourceInterface
    {
        switch ($apiAlias) {
            case 'product':
                return $this->apiClient->getProductApi();
        }
    }
}
