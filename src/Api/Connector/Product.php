<?php

namespace Aa\AkeneoDataLoader\Api\Connector;

use Aa\AkeneoDataLoader\Api\Connector\Media\MediaExtractor;
use Aa\AkeneoDataLoader\Api\LoadingResult\Factory;
use Aa\AkeneoDataLoader\Connector\BatchUploadable;
use Aa\AkeneoDataLoader\Connector\ConnectorInterface;
use Aa\AkeneoDataLoader\Report\LoadingResult\Failure;
use Akeneo\Pim\ApiClient\Api\MediaFileApiInterface;
use Akeneo\Pim\ApiClient\Api\Operation\UpsertableResourceListInterface;
use Akeneo\Pim\ApiClient\Exception\HttpException;
use Exception;
use Traversable;

class Product implements ConnectorInterface, BatchUploadable
{
    /**
     * @var UpsertableResourceListInterface
     */
    private $api;

    /**
     * @var MediaFileApiInterface
     */
    private $mediaFileApi;

    public function __construct(UpsertableResourceListInterface $api, MediaFileApiInterface $mediaFileApi)
    {
        $this->api = $api;
        $this->mediaFileApi = $mediaFileApi;
    }

    public function upload(array $data): Traversable
    {
        $mediaExtractor = new MediaExtractor();

        $media = $mediaExtractor->extract($data);
        $mediaExtractor->removeMediaAttributes($data);

        $responses = $this->api->upsertList($data);

        $mediaResults = $this->getMediaLoadingResults($media);

        yield from Factory::createFromResponses($responses);
        yield from $mediaResults;
    }

    public function getBatchGroup(): string
    {
        return '';
    }

    /**
     * @param array|\Aa\AkeneoDataLoader\Api\Connector\Media\MediaData[] $media
     */
    private function getMediaLoadingResults(array $media): Traversable
    {
        foreach ($media as $mediaData) {

            try {
                $this->mediaFileApi->create(
                    $mediaData->getPath(),
                    $mediaData->toArray()
                );

            } catch (Exception $e) {

                $statusCode = ($e instanceof HttpException) ?
                    $statusCode = $e->getResponse()->getStatusCode() : 0;

                $failure = new Failure(
                    $mediaData->getDataCode(),
                    $e->getMessage(),
                    $statusCode,
                    0, // @todo: how to tackle real index ? store indexes separately?
                    []
                );

                yield $failure;
            }

        }
    }
}
