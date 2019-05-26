<?php

namespace spec\Aa\AkeneoDataLoader\Api;

use Aa\AkeneoDataLoader\Api\Configuration;
use Aa\AkeneoDataLoader\ApiAdapter\Uploadable;
use Akeneo\Pim\ApiClient\AkeneoPimClientInterface;
use Akeneo\Pim\ApiClient\Api\ProductApiInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ApiSelectorSpec extends ObjectBehavior
{
    function let(AkeneoPimClientInterface $apiClient, Configuration $configuration)
    {
        $this->beConstructedWith($apiClient, $configuration);
    }

    function it_selects_api(AkeneoPimClientInterface $apiClient, ProductApiInterface $api)
    {
        $apiClient->getProductApi()->willReturn($api);

        $this->select('product')->shouldHaveType(Uploadable::class);
    }
}
