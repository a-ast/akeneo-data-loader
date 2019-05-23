<?php

namespace Aa\AkeneoDataLoader;

use Aa\AkeneoDataLoader\Upsert\AttributeOptionUpserter;
use Aa\AkeneoDataLoader\Upsert\FamilyVariantUpserter;
use Aa\AkeneoDataLoader\Upsert\StandardUpserter;
use Aa\AkeneoDataLoader\Upsert\Upsertable;
use Akeneo\Pim\ApiClient\AkeneoPimClientInterface;

class ApiSelector implements ApiSelectorInterface
{
    /**
     * @var AkeneoPimClientInterface
     */
    private $apiClient;

    public function __construct(AkeneoPimClientInterface $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function select(string $apiAlias): Upsertable
    {
        switch ($apiAlias) {
            case 'attributes':
                return new StandardUpserter($this->apiClient->getAttributeApi());
            case 'categories':
                return new StandardUpserter($this->apiClient->getCategoryApi());
            case 'attribute-groups':
                return new StandardUpserter($this->apiClient->getAttributeGroupApi());
            case 'attribute-options':
                return new AttributeOptionUpserter($this->apiClient->getAttributeOptionApi());
            case 'families':
                return new StandardUpserter($this->apiClient->getFamilyApi());
            case 'family-variants':
                return new FamilyVariantUpserter($this->apiClient->getFamilyVariantApi());
            case 'products':
                return new StandardUpserter($this->apiClient->getProductApi());
            case 'product-models':
                return new StandardUpserter($this->apiClient->getProductModelApi());
        }

        throw new \InvalidArgumentException(sprintf('Unknown api alias: %s', $apiAlias));
    }
}
