<?php

namespace spec\Aa\AkeneoDataLoader\ApiAdapter;

use Aa\AkeneoDataLoader\ApiAdapter\Uploadable;
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

        $api->upsert('brand', $data)->shouldBeCalled();

        $this->upload($data);
    }
}
