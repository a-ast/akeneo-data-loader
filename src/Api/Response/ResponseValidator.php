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
                $errors[] = sprintf(
                    '%s: %s. Response status code: %d.',
                    $response['code'] ?? '',
                    $response['message'] ?? '',
                    $response['status_code'] ?? ''
                );
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
            sprintf('Loading failed. Status code: %d', $statusCode),
        ]);

    }
}
