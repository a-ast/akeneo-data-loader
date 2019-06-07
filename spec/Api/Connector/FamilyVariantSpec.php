<?php

namespace spec\Aa\AkeneoDataLoader\Api\Connector;

use Aa\AkeneoDataLoader\Connector\BatchUploadable;
use Aa\AkeneoDataLoader\Connector\Uploadable;
use Akeneo\Pim\ApiClient\Api\FamilyVariantApiInterface;
use PhpSpec\ObjectBehavior;

class FamilyVariantSpec extends ObjectBehavior
{
    function let(FamilyVariantApiInterface $api)
    {
        $this->beConstructedWith($api);
    }

    function it_is_upsertable()
    {
        $this->shouldHaveType(BatchUploadable::class);
    }

    function it_upserts(FamilyVariantApiInterface $api)
    {
        $data = ['family' => 'shoes', 'code' => 'shoes_size', 'a' => 2];

        $api
            ->upsertList('shoes', [['code' => 'shoes_size', 'a' => 2]])
            ->willReturn(new \ArrayObject([['status_code' => 201]]))
            ->shouldBeCalled();

        $this->upload([$data]);
    }
}
