<?php

namespace spec\Aa\AkeneoDataLoader\Response;

use Aa\AkeneoDataLoader\Response\ResponseBag;
use PhpSpec\ObjectBehavior;

class ResponseBagSpec extends ObjectBehavior
{
    function it_is_created_from_response_list()
    {
        $this->beConstructedThrough('create', [[['a' => 1]]]);

        $this->shouldHaveType(ResponseBag::class);
    }

    function it_is_created_by_status_codes_list()
    {
        $this->beConstructedThrough('createByStatusCodeList', [[['a' => 1]]]);

        $this->shouldHaveType(ResponseBag::class);
    }

    function it_is_iterable()
    {
        $this->beConstructedThrough('create', [[['a' => 1], ['b' => 2]]]);

        $this->shouldIterateLike([['a' => 1], ['b' => 2]]);
    }
}