<?php

namespace spec\Aa\AkeneoDataLoader\Connector;

use PhpSpec\ObjectBehavior;

class ConfigurationSpec extends ObjectBehavior
{
    function it_creates()
    {
        $this->beConstructedThrough('create', ['uploadDir', 10]);

        $this->getUploadDir()->shouldReturn('uploadDir');
        $this->getBatchSize()->shouldReturn(10);
    }
}
