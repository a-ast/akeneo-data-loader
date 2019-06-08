<?php

namespace spec\Aa\AkeneoDataLoader\Api\Response;

use Aa\AkeneoDataLoader\Api\Response\ResponseError;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ResponseErrorSpec extends ObjectBehavior
{
    function it_transforms_input_to_string()
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

        $this->beConstructedThrough('createFromResponse', [$response]);
        $this->__toString()->shouldReturn($expectedFormat);
    }
}
