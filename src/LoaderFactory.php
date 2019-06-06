<?php

namespace Aa\AkeneoDataLoader;

use Aa\AkeneoDataLoader\Api\Configuration;
use Aa\AkeneoDataLoader\Api\Credentials;
use Aa\AkeneoDataLoader\Api\Registry;
use Aa\AkeneoDataLoader\Api\RegistryInterface;
use Aa\AkeneoDataLoader\ApiAdapter\AssetReferenceFile;
use Aa\AkeneoDataLoader\ApiAdapter\AssetVariationFile;
use Aa\AkeneoDataLoader\ApiAdapter\AttributeOption;
use Aa\AkeneoDataLoader\ApiAdapter\FamilyVariant;
use Aa\AkeneoDataLoader\ApiAdapter\ReferenceEntity;
use Aa\AkeneoDataLoader\ApiAdapter\ReferenceEntityRecord;
use Aa\AkeneoDataLoader\ApiAdapter\StandardAdapter;
use Akeneo\Pim\ApiClient\AkeneoPimClientInterface;
use Akeneo\PimEnterprise\ApiClient\AkeneoPimEnterpriseClientBuilder;
use Akeneo\PimEnterprise\ApiClient\AkeneoPimEnterpriseClientInterface;

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

    protected function createRegistry(AkeneoPimClientInterface $client): RegistryInterface
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

        if ($client instanceof AkeneoPimEnterpriseClientInterface) {

            $uploadDir = $this->configuration->getUploadDir();

            $registry
                ->register('asset',    new StandardAdapter($client->getAssetApi()))
                ->register('asset-reference-file', new AssetReferenceFile($client->getAssetReferenceFileApi(), $uploadDir))
                ->register('asset-variation-file', new AssetVariationFile($client->getAssetVariationFileApi(), $uploadDir))
                ->register('reference-entity',  new ReferenceEntity($client->getReferenceEntityApi()))
                ->register('reference-entity-record',  new ReferenceEntityRecord($client->getReferenceEntityRecordApi()));
        }

        return $registry;
    }

    private function createApiClient(Credentials $apiCredentials): AkeneoPimClientInterface
    {
        $clientBuilder = new AkeneoPimEnterpriseClientBuilder($apiCredentials->getBaseUri());

        return $clientBuilder->buildAuthenticatedByPassword(
            $apiCredentials->getClientId(),
            $apiCredentials->getSecret(),
            $apiCredentials->getUsername(),
            $apiCredentials->getPassword()
        );
    }
}
