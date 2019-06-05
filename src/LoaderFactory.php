<?php

namespace Aa\AkeneoDataLoader;

use Aa\AkeneoDataLoader\Api\Configuration;
use Aa\AkeneoDataLoader\Api\Credentials;
use Aa\AkeneoDataLoader\Api\Registry;
use Aa\AkeneoDataLoader\Api\RegistryInterface;
use Aa\AkeneoDataLoader\ApiAdapter\AttributeOption;
use Aa\AkeneoDataLoader\ApiAdapter\FamilyVariant;
use Aa\AkeneoDataLoader\ApiAdapter\StandardAdapter;
use Aa\AkeneoDataLoader\Response\ResponseValidator;
use Akeneo\Pim\ApiClient\AkeneoPimClientBuilder;
use Akeneo\Pim\ApiClient\AkeneoPimClientInterface;

class LoaderFactory
{
    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var ?RegistryInterface
     */
    private $apiRegistry;

    public function __construct(Configuration $configuration = null, RegistryInterface $apiRegistry = null)
    {
        $this->configuration = $configuration ?? Configuration::create('');
        $this->apiRegistry = $apiRegistry;
    }

    public function createByApiClient(AkeneoPimClientInterface $client): LoaderInterface
    {
        if (null === $this->apiRegistry) {
            $this->apiRegistry = $this->createApiRegistry($client);
        }

        $responseValidator = new ResponseValidator();

        return new Loader($this->apiRegistry, $responseValidator, $this->configuration->getUpsertBatchSize());
    }

    public function createByCredentials(Credentials $apiCredentials): LoaderInterface
    {
        $clientBuilder = new AkeneoPimClientBuilder($apiCredentials->getBaseUri());

        $client = $clientBuilder->buildAuthenticatedByPassword(
            $apiCredentials->getClientId(),
            $apiCredentials->getSecret(),
            $apiCredentials->getUsername(),
            $apiCredentials->getPassword()
        );

        return $this->createByApiClient($client);
    }

    /**
     * @return Registry
     */
    private function createApiRegistry(AkeneoPimClientInterface $client): Registry
    {
        $registry = new Registry();

        $registry
            ->register('channel',    new StandardAdapter($client->getChannelApi()))
            ->register('category',   new StandardAdapter($client->getCategoryApi()))
            ->register('attribute',        new StandardAdapter($client->getAttributeApi()))
            ->register('attribute-group',  new StandardAdapter($client->getAttributeGroupApi()))
            ->register('attribute-option', new AttributeOption($client->getAttributeOptionApi()))
            ->register('family',           new StandardAdapter($client->getFamilyApi()))
            ->register('family-variant',   new FamilyVariant($client->getFamilyVariantApi()))
            ->register('product',          new StandardAdapter($client->getProductApi()))
            ->register('product-model',    new StandardAdapter($client->getProductModelApi()));
        
        return $registry;
    }
}
