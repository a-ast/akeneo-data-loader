<?php

namespace Aa\AkeneoDataLoader;

use Aa\AkeneoDataLoader\Api\Configuration;
use Aa\AkeneoDataLoader\Api\Credentials;
use Aa\AkeneoDataLoader\Api\Registry;
use Aa\AkeneoDataLoader\Api\RegistryInterface;
use Aa\AkeneoDataLoader\ApiAdapter\AttributeOption;
use Aa\AkeneoDataLoader\ApiAdapter\FamilyVariant;
use Aa\AkeneoDataLoader\ApiAdapter\StandardAdapter;
use Akeneo\Pim\ApiClient\AkeneoPimClientBuilder;
use Akeneo\Pim\ApiClient\AkeneoPimClientInterface;

class LoaderFactory
{
    /**
     * @var Configuration
     */
    private $configuration;

    public function __construct(Configuration $configuration = null)
    {
        $this->configuration = $configuration ?? Configuration::create('');
    }

    public function createByCredentials(Credentials $apiCredentials): LoaderInterface
    {
        $client = $this->createApiClient($apiCredentials);

        $registry = $this->createRegistry($client);

        return new Loader($registry, $this->configuration);
    }

    private function createRegistry(AkeneoPimClientInterface $client): RegistryInterface
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

    private function createApiClient(Credentials $apiCredentials): AkeneoPimClientInterface
    {
        $clientBuilder = new AkeneoPimClientBuilder($apiCredentials->getBaseUri());

        return $clientBuilder->buildAuthenticatedByPassword(
            $apiCredentials->getClientId(),
            $apiCredentials->getSecret(),
            $apiCredentials->getUsername(),
            $apiCredentials->getPassword()
        );
    }
}
