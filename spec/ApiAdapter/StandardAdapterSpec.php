<?php

namespace spec\Aa\AkeneoDataLoader\Upsert;

use Aa\AkeneoDataLoader\ApiAdapter\Uploadable;
use Akeneo\Pim\ApiClient\Api\Operation\UpsertableResourceInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StandardAdapterSpec extends ObjectBehavior
{
    function let(UpsertableResourceInterface $api)
    {
        $this->beConstructedWith($api);
    }

    function it_is_upsertable()
    {
        $this->shouldHaveType(Uploadable::class);
    }

    function it_upserts(UpsertableResourceInterface $api)
    {
        $api->upsert(1, ['code' => 1, 'a' => 2])->shouldBeCalled();

        $this->upload(['code' => 1, 'a' => 2]);
    }
}
