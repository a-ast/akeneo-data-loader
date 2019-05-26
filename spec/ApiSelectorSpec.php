<?php

namespace spec\Aa\AkeneoDataLoader;

use Aa\AkeneoDataLoader\ApiAdapter\Uploadable;
use Akeneo\Pim\ApiClient\AkeneoPimClientInterface;
use Akeneo\Pim\ApiClient\Api\ProductApiInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ApiSelectorSpec extends ObjectBehavior
{

    function let(AkeneoPimClientInterface $apiClient)
    {
        $this->beConstructedWith($apiClient);
    }

    function it_selects_api(AkeneoPimClientInterface $apiClient, ProductApiInterface $api)
    {
        $apiClient->getProductApi()->willReturn($api);

        $this->select('product')->shouldHaveType(Uploadable::class);
    }
}
