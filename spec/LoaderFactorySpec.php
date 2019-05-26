<?php

namespace spec\Aa\AkeneoDataLoader;

use Aa\AkeneoDataLoader\LoaderInterface;
use Akeneo\Pim\ApiClient\AkeneoPimClientInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LoaderFactorySpec extends ObjectBehavior
{
    function it_creates_from_api_client(AkeneoPimClientInterface $client)
    {
        $this->createByApiClient($client)->shouldHaveType(LoaderInterface::class);
    }

    function it_creates_from_credentials()
    {
        $this
            ->createByCredentials('uri', 'clientId', 'secret', 'username', 'password')
            ->shouldHaveType(LoaderInterface::class);
    }
}
