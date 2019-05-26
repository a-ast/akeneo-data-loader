<?php

namespace Aa\AkeneoDataLoader;

use Aa\AkeneoDataLoader\Api\ApiSelector;
use Aa\AkeneoDataLoader\Response\ResponseValidator;
use Akeneo\Pim\ApiClient\AkeneoPimClientBuilder;
use Akeneo\Pim\ApiClient\AkeneoPimClientInterface;

class LoaderFactory
{
    public function createByApiClient(AkeneoPimClientInterface $client, int $upsertBatchSize = 100): LoaderInterface
    {
        $apiSelector = new ApiSelector($client);
        $responseValidator = new ResponseValidator();

        return new Loader($apiSelector, $responseValidator);
    }

    public function createByCredentials(string $baseUri, string $clientId, string $secret, string $username, string $password): LoaderInterface
    {
        $clientBuilder = new AkeneoPimClientBuilder($baseUri);
        $client = $clientBuilder->buildAuthenticatedByPassword($clientId, $secret, $username, $password);

        return $this->createByApiClient($client);
    }
}
