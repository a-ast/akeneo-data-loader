<?php

namespace spec\Aa\AkeneoDataLoader\Api\Connector;

use Aa\AkeneoDataLoader\Connector\BatchUploadable;
use Aa\AkeneoDataLoader\Connector\Uploadable;
use Akeneo\Pim\ApiClient\Api\AttributeOptionApiInterface;
use PhpSpec\ObjectBehavior;

class AttributeOptionSpec extends ObjectBehavior
{
    function let(AttributeOptionApiInterface $api)
    {
        $this->beConstructedWith($api);
    }

    function it_is_upsertable()
    {
        $this->shouldHaveType(BatchUploadable::class);
    }

    function it_upserts(AttributeOptionApiInterface $api)
    {
        $data = ['attribute' => 'size', 'code' => 'XL', 'a' => 1];

        $api
            ->upsertList('size', [$data])
            ->willReturn(new \ArrayObject([['status_code' => 201]]))
            ->shouldBeCalled();

        $this->upload([$data]);
    }
}
