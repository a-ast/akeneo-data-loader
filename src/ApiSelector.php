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
            case 'channel':
                return new StandardUpserter($this->apiClient->getChannelApi());
            case 'category':
                return new StandardUpserter($this->apiClient->getCategoryApi());
            case 'attribute':
                return new StandardUpserter($this->apiClient->getAttributeApi());
            case 'attribute-group':
                return new StandardUpserter($this->apiClient->getAttributeGroupApi());
            case 'attribute-option':
                return new AttributeOptionUpserter($this->apiClient->getAttributeOptionApi());
            case 'family':
                return new StandardUpserter($this->apiClient->getFamilyApi());
            case 'family-variant':
                return new FamilyVariantUpserter($this->apiClient->getFamilyVariantApi());
            case 'product':
                return new StandardUpserter($this->apiClient->getProductApi());
            case 'product-model':
                return new StandardUpserter($this->apiClient->getProductModelApi());
        }

        throw new \InvalidArgumentException(sprintf('Unknown api alias: %s', $apiAlias));
    }
}
