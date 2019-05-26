<?php

namespace Aa\AkeneoDataLoader\Api;

use Aa\AkeneoDataLoader\ApiAdapter\AttributeOption;
use Aa\AkeneoDataLoader\ApiAdapter\FamilyVariant;
use Aa\AkeneoDataLoader\ApiAdapter\StandardAdapter;
use Aa\AkeneoDataLoader\ApiAdapter\Uploadable;
use Akeneo\Pim\ApiClient\AkeneoPimClientInterface;

class ApiSelector implements ApiSelectorInterface
{
    /**
     * @var AkeneoPimClientInterface
     */
    private $apiClient;

    /**
     * @var Configuration
     */
    private $configuration;

    public function __construct(AkeneoPimClientInterface $apiClient, Configuration $configuration)
    {
        $this->apiClient = $apiClient;
        $this->configuration = $configuration;
    }

    public function select(string $apiAlias): Uploadable
    {
        $upsertBatchSize = $this->configuration->getUpsertBatchSize();
        
        switch ($apiAlias) {

            case 'channel':
                return new StandardAdapter($this->apiClient->getChannelApi(),
                    $upsertBatchSize
                );

            case 'category':
                return new StandardAdapter($this->apiClient->getCategoryApi(),
                    $upsertBatchSize
                );

            case 'attribute':
                return new StandardAdapter($this->apiClient->getAttributeApi(),
                    $upsertBatchSize
                );

            case 'attribute-group':
                return new StandardAdapter($this->apiClient->getAttributeGroupApi(),
                    $upsertBatchSize
                );

            case 'attribute-option':
                return new AttributeOption($this->apiClient->getAttributeOptionApi(),
                    $upsertBatchSize
                );

            case 'family':
                return new StandardAdapter($this->apiClient->getFamilyApi(),
                    $upsertBatchSize
                );

            case 'family-variant':
                return new FamilyVariant($this->apiClient->getFamilyVariantApi(),
                    $upsertBatchSize
                );

            case 'product':
                return new StandardAdapter($this->apiClient->getProductApi(),
                    $upsertBatchSize
                );

            case 'product-model':
                return new StandardAdapter($this->apiClient->getProductModelApi(),
                    $upsertBatchSize
                );
        }

        throw new \InvalidArgumentException(sprintf('Unknown api alias: %s', $apiAlias));
    }
}
