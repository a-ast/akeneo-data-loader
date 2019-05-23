<?php

namespace spec\Aa\AkeneoDataLoader\Upsert;

use Aa\AkeneoDataLoader\Upsert\FamilyVariantUpserter;
use Aa\AkeneoDataLoader\Upsert\Upsertable;
use Akeneo\Pim\ApiClient\Api\FamilyVariantApiInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FamilyVariantUpserterSpec extends ObjectBehavior
{
    function let(FamilyVariantApiInterface $api)
    {
        $this->beConstructedWith($api);
    }

    function it_is_upsertable()
    {
        $this->shouldHaveType(Upsertable::class);
    }

    function it_upserts(FamilyVariantApiInterface $api)
    {
        $data = ['family_code' => 'shoes', 'code' => 'shoes_size', 'a' => 2];

        $api->upsert('shoes', 'shoes_size', $data)->shouldBeCalled();

        $this->upsert($data);
    }
}
