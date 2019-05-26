<?php

namespace spec\Aa\AkeneoDataLoader;

use Aa\AkeneoDataLoader\ApiAdapter\Uploadable;
use Aa\AkeneoDataLoader\ApiSelector;
use Aa\AkeneoDataLoader\Loader;
use Aa\AkeneoDataLoader\Response\ResponseValidator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LoaderSpec extends ObjectBehavior
{
    function let(ApiSelector $apiSelector, ResponseValidator $validator)
    {
        $this->beConstructedWith($apiSelector, $validator);
    }

    function it_loads(ApiSelector $apiSelector, ResponseValidator $validator, Uploadable $api)
    {
        $apiSelector->select('product')->willReturn($api);

        $request = ['a' => 1];
        $response = ['b' => 2];
        $api->upload($request)->willReturn($response);

        $validator->validate($response)->shouldBeCalled();

        $this->load('product', $request);
    }
}
