<?php

namespace spec\Aa\AkeneoDataLoader;

use Aa\AkeneoDataLoader\ApiSelector;
use Aa\AkeneoDataLoader\Loader;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LoaderSpec extends ObjectBehavior
{
    function let(ApiSelector $apiSelector)
    {
        $this->beConstructedWith($apiSelector);
    }

    function it_loads(\Iterator $data, ApiSelector $apiSelector)
    {
        $this->load('product', $data);
    }
}
