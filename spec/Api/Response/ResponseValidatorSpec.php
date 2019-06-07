<?php

namespace spec\Aa\AkeneoDataLoader\Api\Response;

use ArrayObject;
use Aa\AkeneoDataLoader\Exception\ConnectorException;
use PhpSpec\ObjectBehavior;

class ResponseValidatorSpec extends ObjectBehavior
{
    function it_validates_responses_without_errors()
    {
        $response = new ArrayObject([
            ['status_code' => 201],
            ['status_code' => 204],
        ]);

        $this::validate($response);
    }

    function it_validates_responses_with_errors()
    {
        $response = new ArrayObject([
            ['status_code' => 201],
            ['status_code' => 422, 'code' => 'abc', 'message' => 'Abc failed.'],
            ['status_code' => 204],
            ['status_code' => 422, 'code' => 'def', 'message' => 'Def failed.'],
        ]);

        $this->shouldThrow(ConnectorException::class)->during('validate', [$response]);
    }

    function it_validates_good_status_code()
    {
        $this::validateStatusCode(201);
    }

}
