<?php

namespace spec\Aa\AkeneoDataLoader\Api;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConfigurationSpec extends ObjectBehavior
{
    function it_creates()
    {
        $this->beConstructedThrough('create', ['uploadDir', 10]);

        $this->getUploadDir()->shouldReturn('uploadDir');
        $this->getUpsertBatchSize()->shouldReturn(10);
    }
}