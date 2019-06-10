<?php

namespace spec\Aa\AkeneoDataLoader\Api\Connector\Media;

use Aa\AkeneoDataLoader\Api\Connector\Media\MediaData;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MediaDataSpec extends ObjectBehavior
{
    function it_can_be_created_from_product_data()
    {
        $this->beConstructedThrough('create', [
            'path/image.jpg',
            true,
            'abc',
            'image',
            'print',
            'en_US',
        ]);

        $this->getPath()->shouldBe('path/image.jpg');

        $this->toArray()->shouldBe([
            'type' => 'product',
            // @todo model
            'identifier' => 'abc',
            // @todo: code for model
            'attribute' => 'image',
            'scope' => 'print',
            'locale' => 'en_US',
        ]);
    }
}
