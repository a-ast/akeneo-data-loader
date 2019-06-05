<?php

namespace spec\Aa\AkeneoDataLoader;

use Aa\AkeneoDataLoader\Api\Configuration;
use Aa\AkeneoDataLoader\Api\RegistryInterface;
use Aa\AkeneoDataLoader\ApiAdapter\ApiAdapterInterface;
use Aa\AkeneoDataLoader\ApiAdapter\BatchUploadable;
use Aa\AkeneoDataLoader\Response\ResponseBag;
use Aa\AkeneoDataLoader\Response\ResponseValidator;
use PhpSpec\ObjectBehavior;

class LoaderSpec extends ObjectBehavior
{
    function let(RegistryInterface $apiRegistry, Configuration $configuration)
    {
        $configuration->getUpsertBatchSize()->willReturn(100);

        $this->beConstructedWith($apiRegistry, $configuration);
    }

    function it_loads_data(RegistryInterface $apiRegistry, ApiAdapterInterface $api)
    {
        $data = [['a' => 1]];

        $apiRegistry->get('product')->willReturn($api);

        $api->implement(BatchUploadable::class);
        $api->getBatchGroup()->willReturn('');

        $api->upload($data)->willReturn(ResponseBag::create([['status_code' => 201]]));

        $this->load('product', $data);
    }
}
