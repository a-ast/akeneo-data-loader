<?php

namespace spec\Aa\AkeneoDataLoader\Upsert;

use Aa\AkeneoDataLoader\ApiAdapter\Uploadable;
use Akeneo\Pim\ApiClient\Api\AttributeOptionApiInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AttributeOptionSpec extends ObjectBehavior
{
    function let(AttributeOptionApiInterface $api)
    {
        $this->beConstructedWith($api);
    }

    function it_is_upsertable()
    {
        $this->shouldHaveType(Uploadable::class);
    }

    function it_upserts(AttributeOptionApiInterface $api)
    {
        $data = ['attribute' => 'size', 'code' => 'XL', 'a' => 1];

        $api->upsert('size', 'XL', $data)->shouldBeCalled();

        $this->upload($data);
    }
}
