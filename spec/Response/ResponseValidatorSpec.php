<?php

namespace spec\Aa\AkeneoDataLoader\Response;

use Aa\AkeneoDataLoader\Exception\LoaderValidationException;
use Aa\AkeneoDataLoader\Response\ResponseBag;
use Aa\AkeneoDataLoader\Response\ResponseValidator;
use ArrayObject;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ResponseValidatorSpec extends ObjectBehavior
{
    function it_validates_response_without_errors()
    {
        $response = ResponseBag::create([
            ['status_code' => 201],
            ['status_code' => 204],
        ]);

        $this->validate($response);
    }

    function it_validates_response_with_errors()
    {
        $response = ResponseBag::create([
            ['status_code' => 201],
            ['status_code' => 422, 'code' => 'abc', 'message' => 'Abc failed.'],
            ['status_code' => 204],
            ['status_code' => 422, 'code' => 'def', 'message' => 'Def failed.'],
        ]);

        $exception = new LoaderValidationException([
            ['status_code' => 422, 'code' => 'abc', 'message' => 'Abc failed.'],
            ['status_code' => 422, 'code' => 'def', 'message' => 'Def failed.'],
        ]);

        $this->shouldThrow($exception)->during('validate', [$response]);
    }
}
