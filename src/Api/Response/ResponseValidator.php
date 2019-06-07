<?php

namespace Aa\AkeneoDataLoader\Api\Response;

use Aa\AkeneoDataLoader\Exception\ConnectorException;
use Traversable;

final class ResponseValidator
{
    /**
     * @throws \Aa\AkeneoDataLoader\Exception\ConnectorException
     */
    public static function validate(iterable $responses)
    {
        $errors = [];

        foreach ($responses as $response) {
            if (false === in_array($response['status_code'], [201, 204])) {
                $errors[] = $response;
            }
        }

        if (0 !== count($errors)) {
            throw new ConnectorException($errors);
        }
    }

    /**
     * @throws \Aa\AkeneoDataLoader\Exception\ConnectorException
     */
    public static function validateStatusCode(int $statusCode)
    {
        if (true === in_array($statusCode, [201, 204])) {
            return;
        }

        throw new ConnectorException([
            'status_code' => $statusCode,
            'message' => sprintf('Loading failed. Status code: %d', $statusCode),
        ]);

    }
}
