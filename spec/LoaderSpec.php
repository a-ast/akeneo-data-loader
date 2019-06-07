<?php

namespace spec\Aa\AkeneoDataLoader;

use Aa\AkeneoDataLoader\Connector\Configuration;
use Aa\AkeneoDataLoader\Connector\RegistryInterface;
use Aa\AkeneoDataLoader\Connector\ConnectorInterface;
use Aa\AkeneoDataLoader\Connector\BatchUploadable;
use PhpSpec\ObjectBehavior;

class LoaderSpec extends ObjectBehavior
{
    function let(RegistryInterface $apiRegistry, Configuration $configuration)
    {
        $configuration->getBatchSize()->willReturn(100);

        $this->beConstructedWith($apiRegistry, $configuration);
    }

    function it_loads_data(RegistryInterface $apiRegistry, ConnectorInterface $api)
    {
        $data = [['a' => 1]];

        $apiRegistry->get('product')->willReturn($api);

        $api->implement(BatchUploadable::class);
        $api->getBatchGroup()->willReturn('');

        $api->upload($data)->shouldBeCalled();

        $this->load('product', $data);
    }
}
