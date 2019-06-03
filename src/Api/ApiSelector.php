<?php

namespace Aa\AkeneoDataLoader\Api;

use Aa\AkeneoDataLoader\ApiAdapter\AttributeOption;
use Aa\AkeneoDataLoader\ApiAdapter\FamilyVariant;
use Aa\AkeneoDataLoader\ApiAdapter\StandardAdapter;
use Aa\AkeneoDataLoader\ApiAdapter\ApiAdapterInterface;
use Akeneo\Pim\ApiClient\AkeneoPimClientInterface;

class ApiSelector implements ApiSelectorInterface
{
    /**
     * @var AkeneoPimClientInterface
     */
    protected $apiClient;

    /**
     * @var Configuration
     */
    protected $configuration;

    public function __construct(AkeneoPimClientInterface $apiClient, Configuration $configuration)
    {
        $this->apiClient = $apiClient;
        $this->configuration = $configuration;
    }

    public function select(string $apiAlias): ApiAdapterInterface
    {
        switch ($apiAlias) {

            case 'channel':
                return new StandardAdapter($this->apiClient->getChannelApi());

            case 'category':
                return new StandardAdapter($this->apiClient->getCategoryApi());

            case 'attribute':
                return new StandardAdapter($this->apiClient->getAttributeApi());

            case 'attribute-group':
                return new StandardAdapter($this->apiClient->getAttributeGroupApi());

            case 'attribute-option':
                return new AttributeOption($this->apiClient->getAttributeOptionApi());

            case 'family':
                return new StandardAdapter($this->apiClient->getFamilyApi());

            case 'family-variant':
                return new FamilyVariant($this->apiClient->getFamilyVariantApi());

            case 'product':
                return new StandardAdapter($this->apiClient->getProductApi());

            case 'product-model':
                return new StandardAdapter($this->apiClient->getProductModelApi());
        }

        throw new \InvalidArgumentException(sprintf('Unknown api alias: %s', $apiAlias));
    }
}
