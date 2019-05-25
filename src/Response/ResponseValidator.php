<?php

namespace Aa\AkeneoDataLoader\Response;

use Aa\AkeneoDataLoader\Exception\LoaderValidationException;

class ResponseValidator
{
    /**
     * @throws \Aa\AkeneoDataLoader\Exception\LoaderValidationException
     */
    public function validate(iterable $response)
    {
        $errors = array_values(array_filter($response,
            function (array $item) {
                return false === in_array($item['status_code'], [201, 204]);
            }
        ));

        if (0 !== count($errors)) {
            throw new LoaderValidationException($errors);
        }
    }
}
