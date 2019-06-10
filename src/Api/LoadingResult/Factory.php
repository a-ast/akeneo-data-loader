<?php

namespace Aa\AkeneoDataLoader\Api\LoadingResult;

use Aa\AkeneoDataLoader\Report\LoadingResult\Creation;
use Aa\AkeneoDataLoader\Report\LoadingResult\Failure;
use Aa\AkeneoDataLoader\Report\LoadingResult\LoadingResultInterface;
use Aa\AkeneoDataLoader\Report\LoadingResult\Update;
use Traversable;

class Factory
{
    /**
     * @param iterable $responses
     *
     * @return \Traversable|\Aa\AkeneoDataLoader\Report\LoadingResult\LoadingResultInterface[]
     */
    public static function createFromResponses(iterable $responses): Traversable
    {
        foreach ($responses as $response) {

            if (null === $response) {
                continue;
            }

            yield static::createFromResponse($response);
        }

    }

    public static function createFromResponse(array $response): LoadingResultInterface
    {
        switch ($response['status_code'])
        {
            case 201:
                return new Creation(self::getDataCode($response));

            case 204:
                return new Update(self::getDataCode($response));

            default:

                $errors = [];

                foreach ($response['errors'] ?? [] as $error) {
                    $errors[] = sprintf('%s: %s',$error['property'] ?? '',$error['message'] ?? '');
                }

                return new Failure(self::getDataCode($response),
                    $response['message'] ?? '',
                    (int)$response['status_code'] ?? 0,
                    $response['line'] ?? 0,
                    $errors);
        }
    }

    public static function createFromStatusCode(int $statusCode, string $dataCode): LoadingResultInterface
    {
        return static::createFromResponse(['status_code' => $statusCode, 'code' => $dataCode]);
    }

    private static function getDataCode(array $response): string
    {
        return $response['code'] ?? $response['identifier'] ?? '';
    }
}
