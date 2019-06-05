<?php

namespace spec\Aa\AkeneoDataLoader;

use Aa\AkeneoDataLoader\Api\Configuration;
use Aa\AkeneoDataLoader\Api\Credentials;
use Aa\AkeneoDataLoader\Api\RegistryInterface;
use Aa\AkeneoDataLoader\LoaderInterface;
use Akeneo\Pim\ApiClient\AkeneoPimClientInterface;
use PhpSpec\ObjectBehavior;

class LoaderFactorySpec extends ObjectBehavior
{
    function let(Configuration $configuration, RegistryInterface $registry)
    {
        $this->beConstructedWith($configuration, $registry);
    }

    function it_creates_from_api_client(AkeneoPimClientInterface $client)
    {
        $this->createByApiClient($client)->shouldHaveType(LoaderInterface::class);
    }

    function it_creates_from_credentials(Credentials $credentials)
    {
        $credentials->getBaseUri()->willReturn('uri');
        $credentials->getClientId()->willReturn('clientId');
        $credentials->getSecret()->willReturn('secret');
        $credentials->getUsername()->willReturn('user');
        $credentials->getPassword()->willReturn('pass');

        $this
            ->createByCredentials($credentials)
            ->shouldHaveType(LoaderInterface::class);
    }
}
