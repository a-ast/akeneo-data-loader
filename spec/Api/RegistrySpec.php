<?php

namespace spec\Aa\AkeneoDataLoader\Api;

use Aa\AkeneoDataLoader\ApiAdapter\ApiAdapterInterface;
use Aa\AkeneoDataLoader\Exception\UnknownDataTypeException;
use PhpSpec\ObjectBehavior;

class RegistrySpec extends ObjectBehavior
{
    function it_registers_an_api(ApiAdapterInterface $api)
    {
        $this->register('alias', $api);
    }

    function it_gets_a_registered_api(ApiAdapterInterface $api)
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
