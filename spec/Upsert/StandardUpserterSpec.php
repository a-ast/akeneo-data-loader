<?php

namespace spec\Aa\AkeneoDataLoader\Upsert;

use Aa\AkeneoDataLoader\Upsert\Upsertable;
use Akeneo\Pim\ApiClient\Api\Operation\UpsertableResourceInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StandardUpserterSpec extends ObjectBehavior
{
    function let(UpsertableResourceInterface $api)
    {
        $this->beConstructedWith($api);
    }

    function it_is_upsertable()
    {
        $this->shouldHaveType(Upsertable::class);
    }

    function it_upserts(UpsertableResourceInterface $api)
    {
        $api->upsert(1, ['code' => 1, 'a' => 2])->shouldBeCalled();

        $this->upsert(['code' => 1, 'a' => 2]);
    }
}
