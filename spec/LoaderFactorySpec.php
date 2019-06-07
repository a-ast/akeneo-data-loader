<?php

namespace spec\Aa\AkeneoDataLoader;

use Aa\AkeneoDataLoader\Api\Credentials;
use Aa\AkeneoDataLoader\Connector\Configuration;
use Aa\AkeneoDataLoader\LoaderInterface;
use PhpSpec\ObjectBehavior;

class LoaderFactorySpec extends ObjectBehavior
{
    function let(Configuration $configuration)
    {
        $configuration->getUploadDir()->willReturn('/upload');

        $this->beConstructedWith($configuration);
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
