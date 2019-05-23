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
            case 'attributes':
                return $this->apiClient->getAttributeApi();
            case 'categories':
                return $this->apiClient->getCategoryApi();
            case 'attribute-groups':
                return $this->apiClient->getAttributeGroupApi();
            case 'attribute-options':
                return $this->apiClient->getAttributeOptionApi();
            case 'families':
                return $this->apiClient->getFamilyApi();
            case 'family-variants':
                return $this->apiClient->getFamilyVariantApi();
            case 'products':
                return $this->apiClient->getProductApi();
            case 'product-models':
                return $this->apiClient->getProductModelApi();
        }

        throw new \InvalidArgumentException(sprintf('Unknown api alias: %s', $apiAlias));
    }
}
