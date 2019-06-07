<?php

namespace spec\Aa\AkeneoDataLoader\Api\Connector;

use Aa\AkeneoDataLoader\Connector\BatchUploadable;
use Akeneo\Pim\ApiClient\Api\Operation\UpsertableResourceListInterface;
use PhpSpec\ObjectBehavior;

class StandardAdapterSpec extends ObjectBehavior
{
    function let(UpsertableResourceListInterface $api)
    {
        $this->beConstructedWith($api);
    }

    function it_is_upsertable()
    {
        $this->shouldHaveType(BatchUploadable::class);
    }

    function it_upserts(UpsertableResourceListInterface $api)
    {
        $api
            ->upsertList([['code' => 1, 'a' => 2]])
            ->willReturn(new \ArrayObject([['status_code' => 201]]))
            ->shouldBeCalled();

        $this->upload([['code' => 1, 'a' => 2]]);
    }
}
