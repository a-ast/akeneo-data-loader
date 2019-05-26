<?php

namespace Aa\AkeneoDataLoader\Response;

use Aa\AkeneoDataLoader\Exception\LoaderValidationException;

class ResponseValidator
{
    /**
     * @throws \Aa\AkeneoDataLoader\Exception\LoaderValidationException
     */
    public function validate(iterable $responses)
    {
        $errors = [];

        foreach ($responses as $response) {
            if (false === in_array($response['status_code'], [201, 204])) {
                $errors[] = $response;
            }
        }

        if (0 !== count($errors)) {
            throw new LoaderValidationException($errors);
        }
    }
}
