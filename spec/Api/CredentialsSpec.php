<?php

namespace spec\Aa\AkeneoDataLoader\Api;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CredentialsSpec extends ObjectBehavior
{
    function it_creates()
    {
        $this->beConstructedThrough('create',
            ['uri', 'clientId', 'secret', 'user', 'pass']);

        $this->getBaseUri()->shouldReturn('uri');
        $this->getClientId()->shouldReturn('clientId');
        $this->getSecret()->shouldReturn('secret');
        $this->getUsername()->shouldReturn('user');
        $this->getPassword()->shouldReturn('pass');
    }
}
