<?php

namespace spec\Aa\AkeneoDataLoader\Api\LoadingResult;

use Aa\AkeneoDataLoader\Report\LoadingResult\Creation;
use Aa\AkeneoDataLoader\Report\LoadingResult\Update;
use PhpSpec\ObjectBehavior;

class FactorySpec extends ObjectBehavior
{
    function it_creates_from_responses()
    {
        $responses = [
            ['status_code' => 201, 'code' => 'abc'],
            ['status_code' => 204, 'code' => 'def'],
        ];

        $loadingResults = [
            new Creation('abc'),
            new Update('def'),
        ];

        $this::createFromResponses($responses)
            ->shouldIterateLike($loadingResults);
    }
}
