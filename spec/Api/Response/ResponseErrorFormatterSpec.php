<?php

namespace spec\Aa\AkeneoDataLoader\Api\Response;

use Aa\AkeneoDataLoader\Api\Response\ResponseErrorFormatter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ResponseErrorFormatterSpec extends ObjectBehavior
{
    function it_formats_response_error()
    {
        $response = [

            'status_code' => 422,
            'code' => 'sku',
            'message' => 'Failed',
            'errors' => [
                [
                    'property' => 'a',
                    'message' => 'abc',
                ],
                [
                    'property' => 'd',
                    'message' => 'efg',
                ],
            ]

        ];

        $expectedFormat = <<<EOL
Field "sku": Failed
Status code: 422
Errors:
    - a: abc
    - d: efg
EOL;


        $this
            ->format($response)
            ->shouldReturn($expectedFormat);
    }
}
