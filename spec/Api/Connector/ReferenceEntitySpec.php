<?php

namespace spec\Aa\AkeneoDataLoader\Api\Connector;

use Aa\AkeneoDataLoader\Connector\Uploadable;
use Akeneo\PimEnterprise\ApiClient\Api\ReferenceEntityApiInterface;
use PhpSpec\ObjectBehavior;

class ReferenceEntitySpec extends ObjectBehavior
{
    function let(ReferenceEntityApiInterface $api)
    {
        $this->beConstructedWith($api);
    }

    function it_is_uploadable()
    {
        $this->shouldHaveType(Uploadable::class);
    }

    function it_uploads(ReferenceEntityApiInterface $api)
    {
        $data = ['code' => 'brand', 'a' => 1];

        $api
            ->upsert('brand', $data)
            ->willReturn(201)
            ->shouldBeCalled();

        $this->upload($data);
    }
}
