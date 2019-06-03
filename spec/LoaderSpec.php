<?php

namespace spec\Aa\AkeneoDataLoader;

use Aa\AkeneoDataLoader\ApiAdapter\ApiAdapterInterface;
use Aa\AkeneoDataLoader\Api\ApiSelector;
use Aa\AkeneoDataLoader\ApiAdapter\BatchUploadable;
use Aa\AkeneoDataLoader\Response\ResponseValidator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LoaderSpec extends ObjectBehavior
{
    function let(ApiSelector $apiSelector, ResponseValidator $validator)
    {
        $this->beConstructedWith($apiSelector, $validator);
    }

    function it_loads(ApiSelector $apiSelector, ResponseValidator $validator, ApiAdapterInterface $api)
    {
        $data = [['a' => 1]];
        $response = [['b' => 2]];

        $apiSelector->select('product')->willReturn($api);

        $api->implement(BatchUploadable::class);
        $api->getBatchGroup()->willReturn('');
        $api->upload($data)->willReturn($response);

        $validator->validate($response)->shouldBeCalled();

        $this->load('product', $data);
    }
}
