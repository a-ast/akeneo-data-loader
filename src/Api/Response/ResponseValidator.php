<?php

namespace Aa\AkeneoDataLoader\Api\Response;

use Aa\AkeneoDataLoader\Exception\ConnectorException;

final class ResponseValidator
{
    /**
     * @throws \Aa\AkeneoDataLoader\Exception\ConnectorException
     */
    public static function validate(iterable $responses)
    {
        $errors = [];

        foreach ($responses as $response) {
            if (null === $response || true === in_array($response['status_code'], [201, 204])) {
                continue;
            }

            $errors[] = (string)ResponseError::createFromResponse($response);
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
