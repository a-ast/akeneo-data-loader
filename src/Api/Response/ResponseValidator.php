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
        $formatter = new ResponseErrorFormatter();

        $errors = [];

        foreach ($responses as $response) {
            if (false === in_array($response['status_code'], [201, 204])) {
                $errors[] = $formatter->format($response);
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
