<?php

namespace Aa\AkeneoDataLoader;

use Aa\AkeneoDataLoader\Api\ApiSelector;
use Aa\AkeneoDataLoader\Api\Configuration;
use Aa\AkeneoDataLoader\Api\Credentials;
use Aa\AkeneoDataLoader\Response\ResponseValidator;
use Akeneo\Pim\ApiClient\AkeneoPimClientBuilder;
use Akeneo\Pim\ApiClient\AkeneoPimClientInterface;

class LoaderFactory
{
    public function createByApiClient(AkeneoPimClientInterface $client, Configuration $configuration = null): LoaderInterface
    {
        if (null === $configuration) {
            $configuration = Configuration::create('');
        }

        $apiSelector = new ApiSelector($client, $configuration);
        $responseValidator = new ResponseValidator();

        return new Loader($apiSelector, $responseValidator, $configuration->getUpsertBatchSize());
    }

    public function createByCredentials(Credentials $apiCredentials, Configuration $configuration = null): LoaderInterface
    {
        $clientBuilder = new AkeneoPimClientBuilder($apiCredentials->getBaseUri());

        $client = $clientBuilder->buildAuthenticatedByPassword(
            $apiCredentials->getClientId(),
            $apiCredentials->getSecret(),
            $apiCredentials->getUsername(),
            $apiCredentials->getPassword()
        );

        return $this->createByApiClient($client, $configuration);
    }
}
