<?php

namespace spec\Aa\AkeneoDataLoader\Connector;

use Aa\AkeneoDataLoader\Connector\RegistryInterface;
use Aa\AkeneoDataLoader\Connector\ConnectorInterface;
use Aa\AkeneoDataLoader\Exception\UnknownDataTypeException;
use PhpSpec\ObjectBehavior;

class RegistrySpec extends ObjectBehavior
{
    function it_implements_api_registry_interface()
    {
        $this->shouldBeAnInstanceOf(RegistryInterface::class);
    }

    function it_registers_an_api(ConnectorInterface $api)
    {
        $this->register('alias', $api)->shouldReturn($this);
    }

    function it_gets_a_registered_api(ConnectorInterface $api)
    {
        $this->register('alias', $api);

        $this->get('alias')->shouldReturn($api);
    }

    function it_throws_an_exception_by_getting_not_registered_api()
    {
        $this
            ->shouldThrow(UnknownDataTypeException::class)
            ->during('get', ['unknown-api-alias']);
    }
}
