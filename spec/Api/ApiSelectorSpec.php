<?php

namespace spec\Aa\AkeneoDataLoader\Api;

use Aa\AkeneoDataLoader\Api\Configuration;
use Aa\AkeneoDataLoader\ApiAdapter\ApiAdapterInterface;
use Aa\AkeneoDataLoader\ApiAdapter\BatchUploadable;
use Akeneo\Pim\ApiClient\AkeneoPimClientInterface;
use Akeneo\Pim\ApiClient\Api\ProductApiInterface;
use PhpSpec\ObjectBehavior;

class ApiSelectorSpec extends ObjectBehavior
{
    function let(AkeneoPimClientInterface $apiClient, Configuration $configuration, ProductApiInterface $api)
    {
        $apiClient->getProductApi()->willReturn($api);
        $configuration->getUpsertBatchSize()->willReturn(10);

        $this->beConstructedWith($apiClient, $configuration);
    }

    function it_selects_api()
    {
        $this->select('product')->shouldHaveType(ApiAdapterInterface::class);
        $this->select('product')->shouldHaveType(BatchUploadable::class);
    }
}
