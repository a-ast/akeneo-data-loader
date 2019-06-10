<?php

namespace Aa\AkeneoDataLoader;

use Aa\AkeneoDataLoader\Api\Connector\Product;
use Aa\AkeneoDataLoader\Api\Credentials;
use Aa\AkeneoDataLoader\Api\Connector\AssetReferenceFile;
use Aa\AkeneoDataLoader\Api\Connector\AssetVariationFile;
use Aa\AkeneoDataLoader\Api\Connector\AttributeOption;
use Aa\AkeneoDataLoader\Api\Connector\FamilyVariant;
use Aa\AkeneoDataLoader\Api\Connector\ReferenceEntity;
use Aa\AkeneoDataLoader\Api\Connector\ReferenceEntityRecord;
use Aa\AkeneoDataLoader\Api\Connector\StandardAdapter;
use Aa\AkeneoDataLoader\Connector\Configuration;
use Aa\AkeneoDataLoader\Connector\Registry;
use Aa\AkeneoDataLoader\Connector\RegistryInterface;
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
        $baseDir = $this->configuration->getAssetBaseDir();

        $registry = new Registry();

        $registry
            ->register('channel',    new StandardAdapter($client->getChannelApi()))
            ->register('category',   new StandardAdapter($client->getCategoryApi()))
            ->register('attribute',        new StandardAdapter($client->getAttributeApi()))
            ->register('attribute-group',  new StandardAdapter($client->getAttributeGroupApi()))
            ->register('attribute-option', new AttributeOption($client->getAttributeOptionApi()))
            ->register('association-type', new StandardAdapter($client->getAssociationTypeApi() ))
            ->register('family',           new StandardAdapter($client->getFamilyApi()))
            ->register('family-variant',   new FamilyVariant($client->getFamilyVariantApi()))
            ->register('product',          new Product($client->getProductApi(), $client->getProductMediaFileApi(), $baseDir))
            ->register('product-model',    new Product($client->getProductModelApi(), $client->getProductMediaFileApi(), $baseDir));

        if ($client instanceof AkeneoPimEnterpriseClientInterface) {

            $registry
                ->register('asset',             new StandardAdapter($client->getAssetApi()))
                ->register('asset-category',    new StandardAdapter($client->getAssetCategoryApi()))
                ->register('asset-reference-file',    new AssetReferenceFile($client->getAssetReferenceFileApi(), $baseDir))
                ->register('asset-variation-file',    new AssetVariationFile($client->getAssetVariationFileApi(), $baseDir))
                ->register('reference-entity',        new ReferenceEntity($client->getReferenceEntityApi()))
                ->register('reference-entity-record', new ReferenceEntityRecord($client->getReferenceEntityRecordApi()));
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
