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
    function let(RegistryInterface $apiRegistry, ResponseValidator $validator, Configuration $configuration)
    {
        $configuration->getUpsertBatchSize()->willReturn(100);

        $this->beConstructedWith($apiRegistry, $validator, $configuration);
    }

    function it_loads_data(RegistryInterface $apiRegistry, ResponseValidator $validator, ApiAdapterInterface $api, ResponseBag $responseBag)
    {
        $data = [['a' => 1]];

        $apiRegistry->get('product')->willReturn($api);

        $api->implement(BatchUploadable::class);
        $api->getBatchGroup()->willReturn('');
        $api->upload($data)->willReturn($responseBag);

        $validator->validate($responseBag)->shouldBeCalled();

        $this->load('product', $data);
    }
}
