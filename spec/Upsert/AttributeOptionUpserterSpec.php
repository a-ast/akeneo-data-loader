<?php

namespace spec\Aa\AkeneoDataLoader\Upsert;

use Aa\AkeneoDataLoader\Upsert\AttributeOptionUpserter;
use Aa\AkeneoDataLoader\Upsert\Upsertable;
use Akeneo\Pim\ApiClient\Api\AttributeOptionApiInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AttributeOptionUpserterSpec extends ObjectBehavior
{
    function let(AttributeOptionApiInterface $api)
    {
        $this->beConstructedWith($api);
    }

    function it_is_upsertable()
    {
        $this->shouldHaveType(Upsertable::class);
    }

    function it_upserts(AttributeOptionApiInterface $api)
    {
        $data = ['attribute' => 'size', 'code' => 'XL', 'a' => 1];

        $api->upsert('size', 'XL', $data)->shouldBeCalled();

        $this->upsert($data);
    }
}
